<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;
class Articles extends Component
{
  
    use WithPagination;

    public $isViewArticle = false;
    public $selectedArticle;
 
        public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $authorFilter = '';
    public $sort = 'created-desc';

    // Reset pagination when any filter changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
        $articles = Article::query()
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                          ->orWhereHas('category', function ($catQuery) {
                              $catQuery->where('name', 'like', "%{$this->search}%");
                          })
                          ->orWhereHas('author', function ($userQuery) {
                              $userQuery->where('name', 'like', "%{$this->search}%");
                          });
                });
            })
            ->when($this->authorFilter, function ($q) {
                $q->whereHas('author', function ($query) {
                    $query->where('name', 'like', "%{$this->authorFilter}%");
                });
            })
            ->when($this->categoryFilter, function ($q) {
                $q->whereHas('category', function ($query) {
                    $query->where('name', $this->categoryFilter);
                });
            })
            
            ->when($this->sort, function ($q) {
                match ($this->sort) {
                    'created-desc' => $q->orderBy('created_at', 'desc')->orderBy('id', 'desc'),
                    'created-asc'  => $q->orderBy('created_at', 'asc')->orderBy('id', 'asc'),
                    default        => $q->orderBy('created_at', 'desc')->orderBy('id', 'desc'),
                };
            })
            ->paginate(10);
            
        $categories = \App\Models\Category::all();

        return view('livewire.admin.articles', compact('articles', 'categories'));
    }
    public function viewArticle($ArticleId)
    { 
        $this->isViewArticle = true;
        $this->selectedArticle = Article::find($ArticleId);
    }
    public function closeViewArticle()
    {
        $this->isViewArticle = false;
    }
    public function deleteArticle($ArticleId)
    {
        $article = Article::findOrFail($ArticleId);
        $article->delete();
        $this->isViewArticle = false;
        session()->flash('success', 'Article deleted successfully.');
        $this->dispatch('action-completed');
    }

    
}


