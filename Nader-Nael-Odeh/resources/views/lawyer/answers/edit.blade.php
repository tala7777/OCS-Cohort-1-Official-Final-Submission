@extends('layouts.lawyer')

@section('title', 'Edit Answer')
@section('page-title', 'Edit Answer')

@section('content')
   <livewire:lawyer.edit-answer :id="request()->route('id')" />
@endsection
