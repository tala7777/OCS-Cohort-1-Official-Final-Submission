<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Request as ApartmentRequest; // Alias to avoid confusion with the Request class
use App\Notifications\NewApartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{



    public function index(Apartment $apartment)
    {

        return view('request', compact('apartment'));

    }


    public function store(Request $request, Apartment $apartments)
    {

        // 1. Check if the user is the owner (Owner shouldn't request their own apartment)
        if (Auth::id() === $apartments->owner_id) {
            return back()->with('error', 'You cannot request your own apartment.');
        }



        // 2. Prevent duplicate requests
        $exists = ApartmentRequest::where('student_id', Auth::id())
            ->where('apartment_id', $apartments->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'You have already sent a request for this apartment.');
        }

        $request->validate([

            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',

        ]);


        // 3. Create the request
        $newRequest = ApartmentRequest::create([
            'student_id' => Auth::id(),
            'apartment_id' => $apartments->id,
            'status' => 'pending', // Default status
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);


        /*notification*/
        $owner = $apartments->owner;

        $owner->notify(new NewApartmentRequest($newRequest));



        return redirect()->route('apartments_d', $apartments->id)->with('success', 'Your request has been sent to the owner!');
    }
}