@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('topbar')
    @include('partials.admin-topbar', ['title' => 'Dashboard'])
@endsection

@section('content')
    <!-- Stats Cards -->
    <livewire:admin.dashboard />
@endsection

@section('scripts')
    <script>
        console.log('Dashboard loaded');
    </script>
@endsection
