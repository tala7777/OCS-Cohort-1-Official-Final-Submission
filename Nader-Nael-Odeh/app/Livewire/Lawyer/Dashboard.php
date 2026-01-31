<?php

namespace App\Livewire\Lawyer;

use Livewire\Component;
use App\Models\LawyerProfile;
use App\Models\Article;
use App\Models\Question;
use App\Models\QuestionReply;
class Dashboard extends Component
{


    public function render()
    {
        $answers= QuestionReply::where('lawyer_id', auth()->user()->id)->count();
        $articles= Article::where('author_id', auth()->user()->id)->count();
        $questions = Question::where('user_id', '!=', auth()->user()->id)
            ->whereDoesntHave('replies', function($query) {
                $query->where('lawyer_id', auth()->user()->id);
            })
            ->latest()
            ->limit(3)
            ->get();
        return view('livewire.lawyer.dashboard', compact('answers', 'articles', 'questions'));
    }
}
