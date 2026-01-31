@extends('layouts.owner_master')
@section('title', 'Messages - Owner Dashboard')



@section('head')





    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">





@endsection

@section('content')



    @livewire('chat-component', ['conversation' => $activeConversation])



@endsection


@section('js')

    <script>
        const el = document.getElementById("Messages");
        el.classList.add("active");
    </script>







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
