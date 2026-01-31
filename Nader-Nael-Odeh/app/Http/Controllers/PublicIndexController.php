<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\question;
use  App\Models\Category;
use App\Models\Article;
use App\Models\LawyerProfile;

class publicIndexController extends Controller
{
    public function landing()
    {
        $latestQuestions = Question::with(['category'])->withCount('replies')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        return view('public.landing', compact('latestQuestions'));
    }

    public function index()
    {
        
        return view('public.index');
    }

    public function blog()
    {
        return view('public.blog');
    }

    public function articleDetails($id)
    {
        $article = Article::with('author', 'category')->findOrFail($id);
        return view('public.article-details', compact('article'));
    }

    public function lawyerProfile($id)
    {
        $lawyer = LawyerProfile::where('user_id', $id)->firstOrFail();
        return view('public.lawyer-profile', compact('lawyer'));
    }

    public function addQuestion()
    {
       $categories= Category::all(); 
       return view('public.ask-question', compact('categories'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);
        $question= new Question();
        $question->title= $request->title;
        $question->description= $request->description;
        $question->category_id= $request->category_id;
        $question->user_id= auth()->user()->id;
        $question->save();
        return redirect()->route('index')->with('success', 'Your question has been submitted successfully!');
    }
    public function search(Request $request)
    {
        $search= $request->search;
        $questions= Question::where('title', 'like', '%'.$search.'%')->get();
        $lawyers= LawyerProfile::wherehas('user',function($query) use($search){
            $query->where('name', 'like', '%'.$search.'%');
            $query->where('role','lawyer');
        })->get();
        $articles= Article::where('title', 'like', '%'.$search.'%')->get();
        return view('public.search-results', compact('questions', 'lawyers', 'articles','search'));
    }
}
