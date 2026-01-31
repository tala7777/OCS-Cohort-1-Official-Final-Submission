<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{



    public function index()
    {
        // Fetch all conversations for the sidebar
        $conversations = Conversation::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver'])
            ->get();

        return view('messages', [
            'conversations' => $conversations,
            'currentConversation' => null // No active chat yet
        ]);
    }
    public function show($receiver_id)
    {
        $sender_id = Auth::id();

        // 1. Find or Create a conversation between these two users
        $conversation = Conversation::where(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)->where('receiver_id', $receiver_id);
        })->orWhere(function ($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)->where('receiver_id', $sender_id);
        })->first();

        

        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
            ]);
        }



        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->get();


        // Use 'currentConversation' to match what your Blade file is looking for
        return view('messages', [
            'currentConversation' => $conversation,
            'conversations' => $conversations
        ]);


    }
}

