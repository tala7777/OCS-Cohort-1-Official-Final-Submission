<?php

namespace App\Livewire;

use Livewire\Component;


use App\Models\User;

use Livewire\WithPagination;

class UserTable extends Component
{

    use WithPagination; // Enables AJAX pagination
    
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $role = '';

    // This resets the page to 1 whenever the user types/filters
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingRole()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->role, function ($query) {
                $query->where('role', $this->role);
                
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->simplePaginate(8);

        return view('livewire.user-table', [
            'users' => $users
        ]);
    }


}
