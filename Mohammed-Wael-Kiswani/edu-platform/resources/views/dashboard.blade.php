{{-- إذا كان المستخدم أدمن، استخدم layout الأدمن --}}
@if(auth()->user()->is_admin ?? false)
    @extends('layouts.admin')

    @section('title', 'Dashboard')
    @section('page-title', 'Dashboard')
    @section('page-subtitle', 'Welcome to admin panel')

    @section('content')
        <div class="row g-4">
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="stat-number">42</div>
                    <div class="stat-title">Total Courses</div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-number">1,284</div>
                    <div class="stat-title">Total Users</div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="stat-number">892</div>
                    <div class="stat-title">Active Students</div>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="stat-number">$42,580</div>
                    <div class="stat-title">Total Revenue</div>
                </div>
            </div>
        </div>

        <div class="table-container mt-4">
            <div class="table-header">
                <h5 class="table-title">Recent Activity</h5>
            </div>
            <div class="text-center py-4">
                <p class="text-gray-600">No recent activity to display</p>
            </div>
        </div>
    @endsection
@else
{{-- إذا كان مستخدم عادي، استخدم layout Breeze العادي --}}
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif