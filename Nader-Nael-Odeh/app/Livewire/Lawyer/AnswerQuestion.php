<?php

namespace App\Livewire\Lawyer;

use App\Models\Question;
use Livewire\Component;

class AnswerQuestion extends Component
{
      public $id;
       public $answer;

    public function mount($id)
    {
        $this->id = $id;
        // $this->question = Question::findOrFail($id); etc
    }
    public function render()
    {
$question= Question::findOrFail($this->id);



        return view('livewire.lawyer.answer-question', compact('question'));
    }
    public function store()
    {
        $this->validate([
    'answer' => 'required|string|min:3',
]);
        $question= Question::findOrFail($this->id);
        $question->replies()->create([
            'body' => $this->answer,
            'lawyer_id' => auth()->id(),
        ]);
        $this->dispatch('questionAnswered', $question->id);
        $this->dispatch('refreshQuestions');
        $this->dispatch('refreshAnswers');
       return redirect()->route('lawyer.questions.index')->with('success', 'Your answer has been submitted successfully!');
    }
}
