<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllApartments extends Controller
{


    public function index()
    {

        // $apartments = Apartment::with(['images', 'university'])->paginate(4);

        // return view('apartments', compact('apartments'));

        // Just return the view. Livewire will handle the data fetching.
        return view('apartments');




    }


    public function show(Apartment $apartment)
    {

        $viewed = session()->get('viewed_apartments', []);

        if (!in_array($apartment->id, $viewed)) {
            $apartment->increment('views');
            session()->push('viewed_apartments', $apartment->id);
        }

        $apartment->load(['images', 'university', 'owner', 'features']);

        // Check if THIS specific student has already requested THIS apartment
        $alreadyRequested = false;
        if (Auth::check()) {
            $alreadyRequested = \App\Models\Request::where('student_id', Auth::id())
                ->where('apartment_id', $apartment->id)
                ->exists();
        }

        return view('apartment-details', compact('apartment', 'alreadyRequested'));
    }









}
