<?php
namespace App\Livewire;

use App\Models\Apartment;
use App\Models\University;
use Livewire\Component;
use Livewire\WithPagination;

class ApartmentTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Filters
    public $search = '';
    public $university_id = '';
    public $gender = '';
    public $sort = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Apartment::query();

        // Search by Name
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Filter by University
        if ($this->university_id) {
            $query->where('university_id', $this->university_id);
        }

        // Filter by Gender
        if ($this->gender) {
            $query->where('allowed_gender', $this->gender);
        }

        // Sort by Price
        if ($this->sort === 'min-max') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sort === 'max-min') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        return view('livewire.apartment-table', [
            'apartments' => $query->simplePaginate(8),
            'universities' => University::all() // To populate the dropdown
        ]);
    }
}