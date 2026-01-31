<?php

namespace App\Livewire\Lawyer;

use Livewire\Component;
use App\Models\Question;
use App\Models\Category;
use \Livewire\WithPagination;



class BrowseQuestions extends Component
{
    use WithPagination;
    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $dateFilter = 'newest';
    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingDateFilter() { $this->resetPage(); }

    public function render()
    {
        $questions = Question::query()
    ->when($this->search, function ($query) {
        $query->where(function ($q) {
            $q->where('title', 'like', '%'.$this->search.'%')
              ->orWhere('description', 'like', '%'.$this->search.'%');
        });
    })
    ->when($this->categoryFilter, function ($query) {
        $query->whereHas('category', function ($q) {
            $q->where('id', $this->categoryFilter);
        });
    })
    ->when($this->statusFilter, function ($query) {
        if ($this->statusFilter === 'answered') {
            $query->has('replies');         
        } elseif ($this->statusFilter === 'unanswered') {
            $query->doesntHave('replies');   
        }
    })
    ->when($this->dateFilter === 'oldest', function ($query) {
        $query->orderBy('created_at', 'asc');
    }, function ($query) {
        $query->orderBy('created_at', 'desc');
    })
    ->where('status', 'open')
    ->whereDoesntHave('replies', function ($q) {
        $q->where('lawyer_id', auth()->id());
    })
    
    ->paginate(5);

            $categories=Category::all();

        return view('livewire.lawyer.browse-questions', compact('questions','categories'));
    }
}

