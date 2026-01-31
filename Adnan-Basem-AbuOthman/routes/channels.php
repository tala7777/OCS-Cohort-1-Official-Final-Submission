<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
//     $conversation = \App\Models\Conversation::find($conversationId);
    
//     // Check if the logged-in user is part of this specific chat
//     return $user->id === $conversation->sender_id || $user->id === $conversation->receiver_id;
// });

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    // This MUST return true for the user to hear messages
    $conversation = \App\Models\Conversation::find($conversationId);
    return (int) $user->id === (int) $conversation->sender_id || 
           (int) $user->id === (int) $conversation->receiver_id;
});