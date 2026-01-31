<?php

namespace App\Livewire\Lawyer\Articles;
use App\Models\Article;
use Livewire\Component;
use App\Models\Category;
class EditArticle extends Component
{
    public $articleId;
    public $title;
    public $content;
    public $categoryId;
    public $tags;
    public $categories;
    public $categoryName;


    public function mount($id)
    {
        $this->articleId = $id;
        $article = Article::findOrFail($id);
        $this->title = $article->title;
        $this->content = $article->content;
        $this->categoryId = $article->category->id;
        $this->categoryName = $article->category->name;
        $this->tags = ''; 
        
        $this->categories = Category::all();
    }

   

    public function render()
    {
        return view('livewire.lawyer.articles.edit-article');
    }

    public function publishArticle()
    {
        $this->updateStatus('published');
        session()->flash('success', 'Article published successfully!');
        return redirect()->route('lawyer.articles.index');
    }

    public function saveDraft()
    {
        $this->updateStatus('draft');
        session()->flash('success', 'Article draft saved successfully!');
        return redirect()->route('lawyer.articles.index');
    }

    private function updateStatus($status)
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'categoryId' => 'required',
        ]);

        $article = Article::findOrFail($this->articleId);
        $article->title = $this->title;
        $article->content = $this->content;
        $article->category_id = $this->categoryId;
        $article->status = $status;
        $article->save();
        $this->dispatch('refresh-articles');
    }
}
