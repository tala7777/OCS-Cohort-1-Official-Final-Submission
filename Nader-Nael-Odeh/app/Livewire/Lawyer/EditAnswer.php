<?php

namespace App\Livewire\Lawyer;

use App\Models\Question;
use Livewire\Component;
use App\Models\QuestionReply;

class EditAnswer extends Component
{
    public $questionId;
    public $answer;
    public function mount($id)
    {
        $this->questionId = $id;

      
        $reply = QuestionReply::where('question_id', $this->questionId)
            ->where('lawyer_id', auth()->id())
            ->first();

        
        if ($reply) {
            $this->answer = $reply->body;
        }
    }

    public function render()
    {
        $question = Question::find($this->questionId);
        
      
   
        return view('livewire.lawyer.edit-answer', compact('question'));
    }
    public function update()
    {
        $this->validate([
            'answer' => 'required|string|min:3',
        ]);
        $reply = QuestionReply::where('question_id', $this->questionId)
        ->where('lawyer_id', auth()->id())
        ->first();
        
        if ($reply) {
            $reply->update([
                'body' => $this->answer,
            ]);
        }
        
        $this->dispatch('refreshAnswers');
       return redirect()->route('lawyer.answers.index')->with('success', 'Your answer has been updated successfully!');
    }
  
}
