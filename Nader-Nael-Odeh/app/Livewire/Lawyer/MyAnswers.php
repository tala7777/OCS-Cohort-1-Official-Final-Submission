<?php

namespace App\Livewire\Lawyer;

use App\Models\Category;
use App\Models\Question;
use Livewire\Component;
use App\Models\QuestionReply;
use Illuminate\Support\Facades\Auth;

class MyAnswers extends Component
{
    public $category = '';
    public $sort = 'newest';

    public function render()
    {
        $userId = Auth::id();
        $categories = Category::all();

        $questions = Question::query()
            ->join('question_replies', 'questions.id', '=', 'question_replies.question_id')
            ->where('question_replies.lawyer_id', $userId)
            ->whereNull('question_replies.deleted_at') // Fix: Exclude soft-deleted answers
            ->when($this->category, function ($query) {
                $query->where('questions.category_id', $this->category);
            })
            ->when($this->sort === 'oldest', function ($query) {
                $query->orderBy('question_replies.created_at', 'asc');
            }, function ($query) {
                $query->orderBy('question_replies.created_at', 'desc');
            })
            ->select('questions.*')
            ->distinct()
            ->with(['category', 'replies' => fn ($q) => $q->where('lawyer_id', $userId)])
            ->paginate(5);

        return view('livewire.lawyer.my-answers', compact('categories', 'questions'));
    }

    public $deleteId;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('open-delete-modal');
    }

    public function deleteAnswer()
    {
        if ($this->deleteId) {
            $reply = QuestionReply::where('question_id', $this->deleteId)
                ->where('lawyer_id', auth()->id())
                ->first();
            
            if ($reply) {
                $reply->delete();
                session()->flash('success', 'Answer deleted successfully.');
            }
        }
        
        $this->dispatch('close-delete-modal');
        $this->dispatch('refreshAnswers'); 
        $this->deleteId = null; 
    }

}
