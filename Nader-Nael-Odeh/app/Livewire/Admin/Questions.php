<?php

namespace App\Livewire\Admin;

use App\Models\Question;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use WithPagination;

    public $isViewQuestion = false;
    public $selectedQuestion;
    public $replies;
        public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
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
        $questions = Question::query()
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                          ->orWhere('description', 'like', "%{$this->search}%")
                          ->orWhereHas('category', function ($catQuery) {
                              $catQuery->where('name', 'like', "%{$this->search}%");
                          })
                          ->orWhereHas('owner', function ($userQuery) {
                              $userQuery->where('name', 'like', "%{$this->search}%");
                          });
                });
            })
            ->when($this->categoryFilter, function ($q) {
                $q->whereHas('category', function ($query) {
                    $query->where('name', $this->categoryFilter);
                });
            })
            ->when($this->statusFilter, function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->when($this->sort, function ($q) {
                match ($this->sort) {
                    'created-desc' => $q->orderBy('created_at', 'desc')->orderBy('id', 'desc'),
                    'created-asc'  => $q->orderBy('created_at', 'asc')->orderBy('id', 'asc'),
                    'answers-desc' => $q->withCount('replies')->orderBy('replies_count', 'desc'),
                    default        => $q->orderBy('created_at', 'desc')->orderBy('id', 'desc'),
                };
            })
            ->paginate(10);
            
        $categories = \App\Models\Category::all();

        return view('livewire.admin.questions', compact('questions', 'categories'));
    }
    public function viewQuestion($QuestionId)
    { 
        $this->isViewQuestion = true;
        $this->selectedQuestion = Question::find($QuestionId);
        $this->replies=$this->selectedQuestion->replies;
    }
    public function closeViewQuestion()
    {
        $this->isViewQuestion = false;
    }
    public function deleteQuestion($QuestionId)
    {
        $question = Question::findOrFail($QuestionId);
        $question->delete();
        $this->isViewQuestion = false;
        session()->flash('success', 'Question deleted successfully.');
        $this->dispatch('action-completed');
    }

    public function deleteReply($replyId)
    {
        $reply = \App\Models\QuestionReply::findOrFail($replyId);
        $reply->delete();
        
        $this->selectedQuestion->refresh();
        $this->replies = $this->selectedQuestion->replies;

        session()->flash('success', 'Reply deleted successfully.');
        $this->dispatch('action-completed');
    }

    public function toggleStatus($questionId)
    {
        $question = Question::findOrFail($questionId);
        if ($question->status === 'closed') {
            $question->status = 'open';
        } else {
            $question->status = 'closed';
        }
        $question->save();
        session()->flash('success', 'Question status updated successfully.');
    }
}
