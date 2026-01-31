<?php

namespace App\Livewire\Lawyer\Articles;

use App\Models\Category;
use App\Models\Article;
use Livewire\Component;

class CreateArticle extends Component
{
    public $title;
    public $category_id;
    public $content;

    
   
    public function render()
    {
        $categories = Category::all();

        return view('livewire.lawyer.articles.create-article', compact('categories'));
    }

public function publishArticle(){
    $this->validate([
        'title' => 'required',
        'category_id' => 'required',
        'content' => 'required',
    ]);

$article = Article::create([
    'title' => $this->title,
    'category_id' => $this->category_id,
    'content' => $this->content,
    'author_id' => auth()->id(),
    'status' => 'published',
]);

$this->reset();
$this->dispatch('articlePublished', $article);
 session()->flash('success', 'Article published successfully!');
        return redirect()->route('lawyer.articles.index');


}

public function saveDraft(){
    $this->validate([
        'title' => 'required',
        'category_id' => 'required',
        'content' => 'required',
    ]);

$article = Article::create([
    'title' => $this->title,
    'category_id' => $this->category_id,
    'content' => $this->content,
    'author_id' => auth()->id(),
    'status' => 'draft',
]);

$this->reset();
$this->dispatch('articlePublished', $article);
 session()->flash('success', 'Article saved as draft successfully!');
        return redirect()->route('lawyer.articles.index');


}

}
