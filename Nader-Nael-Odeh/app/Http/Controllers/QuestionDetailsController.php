<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionReply;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LawyerProfile;
use App\Models\Like;
class questionDetailsController extends Controller
{
   

    public function index($id)
    {
       $topAnswerer = User::query()
    ->where('role', 'lawyer')
    ->whereHas('replies', function ($q) use ($id) {
        $q->where('question_id', $id);
        
    })
    ->withCount('replies')
    ->orderByDesc('replies_count')
    ->first();



        $question= Question::findOrFail($id);
        $relatedQuestions= Question::where('category_id', $question->category_id)->where('id', '!=', $question->id)->limit(3)->get();
    return view('public.question-details', compact('question', 'relatedQuestions', 'topAnswerer'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required',
        ]);

        $answer = new QuestionReply();
        $answer->question_id = $id;
        $answer->lawyer_id = auth()->id();
        $answer->body = $request->answer;
        $answer->save();
      
        return redirect()->back()->with('success', 'Answer posted successfully!');
    }
    public function likereply($id)
    {
        $user = auth()->user();
      
        $reply = QuestionReply::where('id', $id)->firstOrFail();
        
      
        $user->likedReplies()->toggle($reply->id);
        
        return redirect()->back();
    }



    //
   
}
