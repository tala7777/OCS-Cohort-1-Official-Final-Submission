<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Apartment;



class IndexController extends Controller
{



    public function index()
    {

        $universities = University::limit(3)->get();



        $apartments = Apartment::with(['images', 'university'])->latest()->take(4)->get();

        




        return view('index', compact('universities', 'apartments'));


    }



}
