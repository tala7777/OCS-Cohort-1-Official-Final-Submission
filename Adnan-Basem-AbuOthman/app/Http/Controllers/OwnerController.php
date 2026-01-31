<?php

namespace App\Http\Controllers;

use App\Models\Request;

use App\Models\Apartment;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $owner = auth()->user();

        $totalViews = $owner->ownedApartments()->sum('views');

        $apartments = Apartment::with('images')
            ->where('owner_id', auth()->id())
            ->latest() ->take(5)
            ->get();

        $apartments_num = Apartment::where('owner_id', auth()->id())->count();

        $requests = Request::whereHas('apartment', function ($query) {
            $query->where('owner_id', auth()->id());
        })
            ->with(['student', 'apartment']) // Eager load for performance
            ->latest()->take(5)
            ->get();


        $requests_num = Request::whereHas('apartment', function ($query) {
            $query->where('owner_id', auth()->id());
        })
            ->count();





        return view('owner.owner-dashboard', compact('totalViews', 'apartments', 'apartments_num', 'requests', 'requests_num'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
