<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class CardController extends Controller
{

    // Inject the Plan model directly from the URL {plan}
    public function create(Plan $plan)
    {
        // No need for findOrFail anymore, Laravel does it automatically
        return view('owner.owner-checkout', compact('plan'));
    }




    public function store(Request $request)
    {

     
        $request->validate([
            'card_token' => 'required',
            'plan_id' => 'required'
        ]);

        // Save the "External Token" to our user
        auth()->user()->update([
            'card_token' => $request->card_token
        ]);

        // Now go back to the Subscription controller to finish the job
        return redirect()->route('plans.subscribe', $request->plan_id);
    }



}
