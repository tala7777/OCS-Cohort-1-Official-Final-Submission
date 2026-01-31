<?php

namespace App\Livewire\Public;

use App\Models\Question;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

 
    public $search='';
    
   
    public $category='';
    
    
    public $sort='date-newest';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
          $questions= Question::query()
          ->withCount('replies')
          ->where(function($query){
            $query->where('title', 'like', '%'.$this->search.'%')
          ->orWhere('description', 'like', '%'.$this->search.'%');
          })
          ->where('status', 'open')
          ->when($this->category,function($query){
            $query->where('category_id', $this->category);
          })
          ->when($this->sort,function($query){
            if($this->sort == 'date-newest'){
              $query->orderBy('created_at', 'desc');
            }elseif($this->sort == 'date-oldest'){
              $query->orderBy('created_at', 'asc');
            }elseif($this->sort == 'answers-most'){
              $query->orderBy('replies_count', 'desc');
            }
          })
          ->paginate(5);

        $categories= Category::all(); 
        return view('livewire.public.index', compact('questions', 'categories'));
    }
}
