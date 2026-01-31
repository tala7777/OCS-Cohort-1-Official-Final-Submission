<?php
namespace App\Livewire;



use Livewire\Attributes\Url; // Only for Livewire v3
use App\Models\Apartment;
use App\Models\University;
use Livewire\Component;
use Livewire\WithPagination;

class StudentApartmentSearch extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';

    #[Url] // This is the magic line
    public $university_id = '';

    public $minArea, $maxArea;
    public $rentType = '';
    public $gender = '';

    public $minPrice, $maxPrice;



    // Reset page on filter change
    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Apartment::query()->with(['images', 'university']);

        $query->when($this->search, function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('location', 'like', '%' . $this->search . '%');
        })
            ->when($this->university_id, fn($q) => $q->where('university_id', $this->university_id))
            ->when($this->rentType, fn($q) => $q->where('rent_type', $this->rentType))
            ->when($this->gender, fn($q) => $q->where('allowed_gender', $this->gender))
            ->when($this->minArea, fn($q) => $q->where('area', '>=', $this->minArea))
            ->when($this->maxArea, fn($q) => $q->where('area', '<=', $this->maxArea))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice));

        return view('livewire.student-apartment-search', [
            'apartments' => $query->simplePaginate(5),
            'universities' => University::all()
        ]);
    }


}
