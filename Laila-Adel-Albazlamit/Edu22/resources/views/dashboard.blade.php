@extends('layouts.' . auth()->user()->role)

@section('content')
    <div class="container-fluid p-4">
        <div class="card border-0 shadow-sm p-4">
            <h3>Welcome, {{ auth()->user()->name }}!</h3>
            <p class="text-muted">You are logged in as {{ ucfirst(auth()->user()->role) }}.</p>
        </div>
    </div>
@endsection