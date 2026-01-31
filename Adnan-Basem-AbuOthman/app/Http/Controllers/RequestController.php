<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Request;
use App\Notifications\RequestStatusUpdated;
use Illuminate\Notifications\Notifiable; // <-- Must have this

class RequestController extends Controller
{

    use Notifiable;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $requests = Request::whereHas('apartment', function ($query) {
            $query->where('owner_id', auth()->id());
        })
            ->with(['student', 'apartment']) // Eager load for performance
            ->latest()
            ->get();

        return view('owner.owner-requests', compact('requests'));
    }


    public function updateStatus(Request $request, $status)
    {
        // Basic security: Ensure this owner actually owns the apartment in the request
        if ($request->apartment->owner_id !== auth()->id()) {
            abort(403);
        }

        // Validate the new status
        if (in_array($status, ['approved', 'rejected', 'pending'])) {
            $request->update(['status' => $status]);
        }

        // Send notification to the student
        $student = $request->student; // Assumes relation in model
        $student->notify(new RequestStatusUpdated($request, $status));

        return back()->with('success', 'Status updated to ' . ucfirst($status));
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
    public function destroy(Request $request)
    {

        $request->delete();



        return back()->with('success', 'Request Deleted Successfully!');

    }
}
