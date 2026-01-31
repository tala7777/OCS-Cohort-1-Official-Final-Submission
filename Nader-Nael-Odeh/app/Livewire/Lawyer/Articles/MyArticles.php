<?php

namespace App\Livewire\Lawyer\Articles;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;


class MyArticles extends Component
{
    public function delete($id)
    {
        $article = Article::where('id', $id)
            ->where('author_id', auth()->id())
            ->first();

        if ($article) {
            $article->delete();
            session()->flash('success', 'Article deleted successfully.');
        }
    }

    public function render()
    {
        $articles= Article::query()
        ->where('author_id', auth()->id())
        ->where('status', 'published')
        ->get();

        $articles->each(function ($article) {
            $article->content = Str::limit($article->content, 100);
        });

        $drafts= Article::query()
        ->where('author_id', auth()->id())
        ->where('status', 'draft')
        ->get();

        $drafts->each(function ($article) {
            $article->content = Str::limit($article->content, 100);
        });
        return view('livewire.lawyer.articles.my-articles', compact('articles', 'drafts'));
    }
}
