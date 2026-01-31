@extends('layouts.lawyer')

@section('title', 'Edit Article - LegalQ&A')
@section('page-title', 'Edit Article')

@section('styles')
    <!-- Optional styles -->
@endsection

@section('content')
    <livewire:lawyer.articles.edit-article :id="$id" />
@endsection

@section('scripts')
    <script>
       
        
    </script>
@endsection
