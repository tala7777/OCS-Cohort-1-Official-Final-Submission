<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Dotenv\Repository\Adapter\ApacheAdapter;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\University;
use App\Models\Subscription;
use App\Models\Plan;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // Get all users to show in a table

        $users = User::orderBy('created_at', 'desc')->limit(5)->get();

        $apartments = Apartment::with(['images','owner'])
            ->latest()
            ->take(5)
            ->get();


        // Count numbers
        $totalUniversities = University::count();

        $totalStudents = User::where('role', 'student')->count();

        $totalOwners = User::where('role', 'owner')->count();

        $totalApartments = Apartment::count();

        // Calculate Revenue from Subscriptions
        // We join with the 'plans' table to get the price of each active subscription
        $totalRevenue = Subscription::join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->where('subscriptions.status', 'active')
            ->sum('plans.price');



        $totalUsers = $totalStudents + $totalOwners;


        //***************************************************** */
        // Get users who are owners, and load their subscriptions and the plans for those subscriptions
        // $owners = User::where('role', 'owner')->with('subscriptions.plan')->get();

        //then in blade:
//         @foreach($owners as $owner)
//     <tr>
//         <td>{{ $owner->name }}</td>
//         <td>
//             {{-- Check if they have an active subscription --}}
//             @if($owner->subscriptions->where('status', 'active')->first())
//                 <span class="badge bg-success">
//                     {{-- Access the Plan name through the relationship chain --}}
//                     {{ $owner->subscriptions->where('status', 'active')->first()->plan->name }}
//                 </span>
//             @else
//                 <span class="badge bg-secondary">No Active Plan</span>
//             @endif
//         </td>
//     </tr>
// @endforeach



        return view('admin.admin-dashboard', compact(
            'users',
            'totalUniversities',
            'totalStudents',
            'totalOwners',
            'totalRevenue',
            'totalUsers',
            'totalApartments',
            'apartments'
        ));


    }


    public function profile()
    {

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
    public function destroy(string $id)
    {
        //
    }
}
