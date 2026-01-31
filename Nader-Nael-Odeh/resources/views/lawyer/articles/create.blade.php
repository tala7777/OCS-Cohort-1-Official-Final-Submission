@extends('layouts.lawyer')

@section('title', 'Write Article - Legal Q&A')
@section('page-title', 'Write New Article')

@section('styles')
    <!-- Optional: Site specific styles if needed, though admin.css should cover most -->
@endsection

@section('content')
  <livewire:lawyer.articles.create-article />
@endsection

@section('scripts')
    <script>
     
    </script>
@endsection
