<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\LawyerProfile;
use Livewire\WithPagination;

class Lawyers extends Component
{
    use WithPagination;

    public $search;
    public $categoryFilter;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $lawyers = LawyerProfile::query()
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->categoryFilter, function ($query)  {
                $query->whereHas('categories', function ($q) {
                    $q->where('categories.id', $this->categoryFilter);
                });
            })
            ->paginate(12);
            
        $categories = \App\Models\Category::all();
        
        return view('livewire.public.lawyers', compact('lawyers', 'categories'));
    }
}
