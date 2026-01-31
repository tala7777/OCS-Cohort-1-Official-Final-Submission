<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\LawyerProfile;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\LawyerApproved;
use  Illuminate\Support\Facades\Log;
class LawyersRequests extends Component
{

    
   public $search = '';
   public $roleFilter = '';
   public $statusFilter = '';
   public $categoryFilter = '';
  

public $sort = 'created-desc';  
    public function render()
    {
    $lawyers = LawyerProfile::query()
    ->with(['user.specializations']) // or ['user.specializations'] if that's your real structure
    ->when($this->search, function ($q) {
        $q->whereHas('user', function ($uq) {
            $uq->where('name', 'like', "%{$this->search}%")
               ->orWhere('email', 'like', "%{$this->search}%");
        });
    })
    ->when($this->roleFilter, function ($q) {
        $q->whereHas('user', fn ($uq) => $uq->where('role', $this->roleFilter));
    })
    ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
    ->when($this->categoryFilter, fn ($q) => $q->whereHas('user.specializations', fn ($sq) => $sq->where('categories.name', $this->categoryFilter)))
    ->when($this->sort, function ($q) {
        match ($this->sort) {
            'created-desc' => $q->orderBy('created_at', 'desc')->orderBy('id', 'desc'),
            'created-asc'  => $q->orderBy('created_at', 'asc')->orderBy('id', 'asc'),

            // Sort by related user's name using a subquery (no joins)
            'name-asc'     => $q->orderBy(
                User::select('name')->whereColumn('users.id', 'lawyer_profiles.user_id'),
                'asc'
            ),
            'name-desc'    => $q->orderBy(
                User::select('name')->whereColumn('users.id', 'lawyer_profiles.user_id'),
                'desc'
            ),

            default        => $q->orderBy('created_at', 'desc'),
        };
    })
    ->get();
    $categories = Category::all();

        return view('livewire.admin.lawyers-requests', [
            'lawyers' => $lawyers,
            'categories' => $categories
        ]);
    }

    public function approveRequest($lawyerId)
    {
        $lawyer = LawyerProfile::findOrFail($lawyerId);
        $lawyer->status = 'accepted';
        $lawyer->save();

       
        $lawyer->user->status = 'active';
        $lawyer->user->save();

        try {
            Mail::to($lawyer->user->email)->send(new LawyerApproved($lawyer->user));
        } catch (\Exception $e) {
            // Log the error but don't fail the request
           Log::error("Failed to send lawyer approval email to {$lawyer->user->email}: " . $e->getMessage());
        }

        session()->flash('success', 'Request approved successfully!');
        $this->dispatch('action-completed');
    }

    public function rejectRequest($lawyerId)
    {
        $lawyer = LawyerProfile::findOrFail($lawyerId);
        $lawyer->status = 'rejected';
        $lawyer->save();

        session()->flash('success', 'Request rejected and deleted.');
        $this->dispatch('action-completed');
    }
    
}
