<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use Stripe\Stripe;
use Stripe\Charge;
use Exception;

class SubscriptionController extends Controller
{
    public function subscribe(Plan $plan)
    {
        $user = auth()->user()->refresh();
        $activeSub = $user->subscription;

        if ($activeSub && $activeSub->plan_id == $plan->id && $activeSub->status == 'active') {
            return redirect()->back()->with('error', 'You are already subscribed to the ' . $plan->name . ' plan.');
        }

        if (!$user->card_token) {
            return redirect()->route('card.create', ['plan' => $plan->id]);
        }

        return redirect()->route('plans.confirm', ['plan' => $plan->id]);
    }

    public function confirm(Plan $plan)
    {
        return view('owner.confirm', compact('plan'));
    }

    public function finalize(Plan $plan)
    {
        $user = auth()->user();

        if (!$user->card_token) {
            return redirect()->route('card.create', ['plan' => $plan->id]);
        }

        return $this->processSubscription($user, $plan);
    }

    protected function processSubscription($user, $plan)
    {
        try {
            // 1. SET STRIPE KEY (Read from .env)
            Stripe::setApiKey(config('services.stripe.secret'));

            // 2. CREATE THE REAL CHARGE
            Charge::create([
                "amount" => $plan->price * 100, // Stripe expects cents
                "currency" => "usd",
                "source" => $user->card_token,
                "description" => "Payment for " . $plan->name . " Plan - User: " . $user->email
            ]);

            // 3. DATABASE LOGIC (Only runs if Charge succeeds)
            $existingSub = Subscription::where('owner_id', $user->id)
                ->where('status', 'active')
                ->first();

            if ($existingSub) {
                $existingSub->update([
                    'plan_id' => $plan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration_days),
                ]);
                $message = "Your plan has been upgraded to " . $plan->name;
            } else {
                Subscription::create([
                    'owner_id' => $user->id,
                    'plan_id' => $plan->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($plan->duration_days),
                    'status' => 'active',
                ]);
                $message = "Successfully subscribed to " . $plan->name;
            }

            return redirect()->route('owner_apartments.index')->with('success', $message);

        } catch (Exception $e) {
            // If payment fails, send them back to the card page with the error
            return redirect()->route('card.create', ['plan' => $plan->id])
                ->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}