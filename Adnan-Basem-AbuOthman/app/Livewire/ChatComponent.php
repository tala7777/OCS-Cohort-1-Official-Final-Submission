<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\Conversation;
use App\Events\MessageSent;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    public $conversation;
    public $newMessage = '';

    // This is the magic part! 
    // It tells Livewire: "Listen to the private socket channel 'chat.ID'"
    public function getListeners()
    {
        return [
            "echo-private:chat.{$this->conversation->id},MessageSent" => 'handleIncomingMessage',
        ];
        // "echo-private:chat.{$this->conversation->id},MessageSent" => 'broadcastedMessageReceived',


    }

    // The name here MUST be $conversation to match your Blade file
    public function mount(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function sendMessage()
    {
        if (empty($this->newMessage))
            return;

        // 1. Save to Database
        $message = Message::create([
            // Change this line from conversationId to conversation->id
            'conversation_id' => $this->conversation->id,
            'user_id' => auth()->id(),
            'body' => $this->newMessage,
        ]);

        // 2. Broadcast to Sockets
        broadcast(new MessageSent($message))->toOthers();

        // 3. Clear input
        $this->newMessage = '';

        // Scroll down
        $this->dispatch('scroll-bottom');
    }

    public function refreshMessages()
    {
        // This function is called automatically when the socket hears a new message
    }

    public function render()
    {
        return view('livewire.chat-component', [
            'messages' => Message::where('conversation_id', $this->conversation->id)
                ->oldest() // Sort messages from oldest to newest
                ->get()
        ]);
    }




    public function handleIncomingMessage()
    {
        // This refreshes the component and then tells the browser to scroll
        $this->dispatch('scroll-bottom');
    }


    public function broadcastedMessageReceived()
    {
        // Trigger the scroll event when someone else sends a message
        $this->dispatch('scroll-bottom');
    }



}