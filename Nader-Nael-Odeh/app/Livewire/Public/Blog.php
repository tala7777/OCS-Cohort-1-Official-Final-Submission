<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
use App\Models\Category;

class Blog extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::query()
            ->with(['author', 'category'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        $articles = $query->paginate(6);
        $categories = Category::all();

        return view('livewire.public.blog', [
            'articles' => $articles,
            'categories' => $categories
        ])->layout('layouts.public'); 
    }
}
