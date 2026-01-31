@extends('layouts.lawyer')

@section('title', 'Answer Question')
@section('page-title', 'Answer Question')

@section('content')
   <livewire:lawyer.answer-question :id="$id" />
@endsection
