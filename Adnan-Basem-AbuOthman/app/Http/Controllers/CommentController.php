<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

class CommentController extends Controller
{


    public function store(Request $request, $apartmentId)
    {
        $request->validate([
            'content' => 'required|min:3|max:500',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'apartment_id' => $apartmentId,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment posted!');
    }






}
