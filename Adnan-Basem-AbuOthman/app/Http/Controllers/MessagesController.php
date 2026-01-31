<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        

            $contacts = $this->getContactsList($userId);

        $view = Auth::user()->role == 'owner' ? 'owner.owner-messages' : 'messages';
        return view($view, compact('contacts'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $contact = User::findOrFail($id);
        $contacts = $this->getContactsList($userId);

        $messages = Message::where(function ($q) use ($userId, $id) {
            $q->where('sender_id', $userId)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($userId, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $id)->where('receiver_id', $userId)->update(['is_read' => true]);

        $view = Auth::user()->role == 'owner' ? 'owner.owner-messages' : 'messages';
        return view($view, compact('contacts', 'messages', 'contact'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        return back()->with('success', 'Message sent!');
    }

    private function getContactsList($userId)
    {
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->select(DB::raw('CASE WHEN sender_id = ' . $userId . ' THEN receiver_id ELSE sender_id END as contact_id'), DB::raw('MAX(created_at) as last_message_time'))
            ->groupBy('contact_id')
            ->orderBy('last_message_time', 'desc')
            ->get();

        return $conversations->map(function ($convo) use ($userId) {
            $contactUser = User::find($convo->contact_id);
            $lastMsg = Message::where(function ($q) use ($userId, $convo) {
                $q->where('sender_id', $userId)->where('receiver_id', $convo->contact_id);
            })->orWhere(function ($q) use ($userId, $convo) {
                $q->where('sender_id', $convo->contact_id)->where('receiver_id', $userId);
            })->latest()->first();

            return [
                'user' => $contactUser,
                'last_message' => $lastMsg,
            ];
        });
    }
}