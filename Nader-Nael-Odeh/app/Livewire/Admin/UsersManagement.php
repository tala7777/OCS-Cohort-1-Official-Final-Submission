<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UsersManagement extends Component
{
    use \Livewire\WithPagination;

    public $isviewopen = false;
    public $iseditopen = false;
    public $isaddopen = false;
    
    public ?User $selectedUser = null;

   public $search = '';
   public $roleFilter = '';
   public $statusFilter = '';
   public $sort = 'created-desc';
    public $name;
    public $email;
    public $role;
    public $status;
    public $password;   
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|string',
        'password' => 'required|string|min:8',
        'status' => 'required|string',
    ];

    public function render()
    {
       $users = User::query()
    ->when($this->search, function ($q) {
        $q->where(function ($qq) {
            $qq->where('name', 'like', "%{$this->search}%")
               ->orWhere('email', 'like', "%{$this->search}%");
        });
    })
    ->when($this->roleFilter, fn ($q) => $q->where('role', $this->roleFilter))
    ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
    ->when($this->sort, function ($q) {
        match ($this->sort) {
            'created-desc' => $q->orderBy('created_at', 'desc'),
            'created-asc'  => $q->orderBy('created_at', 'asc'),
            'name-asc'     => $q->orderBy('name', 'asc'),
            'name-desc'    => $q->orderBy('name', 'desc'),
            default        => $q->orderBy('created_at', 'desc'),
        };
    })
    ->paginate(10);

        return view('livewire.admin.users-management', compact('users'));
    }


    public function viewUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->isviewopen = true;
    }   
    
    public function closeModal()
    {
        $this->isviewopen = false;
        $this->iseditopen = false;
        $this->isaddopen = false;
        $this->selectedUser = null;
        $this->reset(['name', 'email', 'role', 'status', 'password', 'password_confirmation']);
    }

    public function editUser($id)
    {
        
        $this->selectedUser = User::find($id);
        if ($this->selectedUser) {
            $this->name = $this->selectedUser->name;
            $this->email = $this->selectedUser->email;
            $this->role = $this->selectedUser->role;
            $this->status = $this->selectedUser->status;
            $this->iseditopen = true;
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', 
            type: 'warning',
            title: 'Are you sure?',
            text: 'You cannot revert this action!',
            id: $id
        );
    }

    #[On('deleteConfirmed')]
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            session()->flash('success', 'User has been deleted successfully.');
            $this->dispatch('action-completed');
        }
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string',
            'status' => 'required|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($this->password) {
            if ($this->password !== $this->password_confirmation) {
                $this->addError('password_confirmation', 'Passwords do not match');
                return;
            }
        }

        if ($this->selectedUser) {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'status' => $this->status,
            ];

            if ($this->password) {
                $data['password'] = bcrypt($this->password);
            }

            $this->selectedUser->update($data);
            
            session()->flash('success', 'User details have been updated successfully.');
            $this->dispatch('action-completed');
        }
        
        $this->closeModal();
    }
     public function addUser(){
        $this->isaddopen = true;
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'status' => 'required|string',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => bcrypt($this->password),
            'status' => $this->status,
        ]);
        
        session()->flash('success', 'New user has been created successfully.');
        $this->dispatch('action-completed');
        
        $this->closeModal();
        $this->reset(['name', 'email', 'role', 'status', 'password', 'password_confirmation']);
        $this->isaddopen = false;
    }
}
