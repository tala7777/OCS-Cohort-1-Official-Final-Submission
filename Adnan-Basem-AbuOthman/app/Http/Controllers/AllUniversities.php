<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;

class AllUniversities extends Controller
{


    public function index()
    {

        $universities = University::all();



        return view('universities' , compact('universities'));

    }


}
