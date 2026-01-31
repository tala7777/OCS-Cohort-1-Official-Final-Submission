<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ApartmentAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $apartments = Apartment::with(['images', 'owner', 'university'])
            ->latest()
            ->get();


        $universities = University::all();


        return view('admin.admin-apartments', compact('apartments'));
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
        //
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
    public function destroy(Apartment $apartments)
    {


        foreach ($apartments->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $apartments->delete();

        return redirect()->route('apartments.index')->with('success', 'Apartment Deleted Successfully!');



    }
}
