@extends('layouts.master')

@section('title', 'Sakan - Messages')



@section('head')





    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">



@endsection

@section('content')
    <div class="chat-container">


        <div class="chat-sidebar {{ isset($currentConversation) ? 'd-none d-md-flex' : 'd-flex' }}">
            <div class="p-3 border-bottom bg-white sticky-top">
                <h5 class="fw-bold mb-0">Messages</h5>
            </div>
            <ul class="chat-list">
                @forelse ($conversations as $conv)
                    @php
                        $otherUser = $conv->sender_id == auth()->id() ? $conv->receiver : $conv->sender;
                        $isActive = isset($currentConversation) && $currentConversation->id == $conv->id;
                    @endphp

                    <li class="chat-item {{ $isActive ? 'active' : '' }}">
                        <a href="{{ route('messages.show', $otherUser->id) }}">
                            <div class="chat-avatar me-3"
                                style="width: 45px; height: 45px; border-radius: 50%; background: #e2e8f0; display:flex; align-items:center; justify-content:center;">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>
                            <div class="chat-info">
                                <div class="chat-name">{{ $otherUser->name }}</div>
                                <small class="text-muted text-truncate d-block" style="max-width: 180px;">
                                    Click to view messages
                                </small>
                            </div>
                        </a>
                    </li>

                @empty
                    <ul class="chat-list" style="text-align: center; margin-top:4%;">
                        <li class="chat-item">
                            <p class="">No chats Yet</p>
                        </li>

                    </ul>
                @endforelse
            </ul>
        </div>

        <div class="chat-area {{ isset($currentConversation) ? 'd-flex' : 'd-none d-md-flex' }}">
            @if ($currentConversation)
                @livewire('chat-component', ['conversation' => $currentConversation])
            @else
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                    <i class="bi bi-chat-dots fs-1"></i>
                    <p class="mt-3">Select a conversation to start chatting</p>
                </div>
            @endif
        </div>


    </div>
@endsection

@section('js')


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





    <script>
        function scrollToBottom() {
            const container = document.getElementById('chatMessages');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        // 1. Scroll on initial page load
        document.addEventListener('DOMContentLoaded', scrollToBottom);

        // 2. Scroll after Livewire updates the DOM (when sending/receiving messages)
        window.addEventListener('scroll-bottom', () => {
            // Use requestAnimationFrame to ensure the DOM has finished rendering
            requestAnimationFrame(() => {
                scrollToBottom();
            });
        });
    </script>




@endsection