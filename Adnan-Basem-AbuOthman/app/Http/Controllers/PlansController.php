<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlansController extends Controller
{
    public function index()
    {

        $plans = Plan::all();
        return view('owner.owner-plans', compact('plans'));

    }
}
