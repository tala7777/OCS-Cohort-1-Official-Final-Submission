@extends('layouts.app')

@section('title', 'Payments Dashboard')

@section('content')
<div id="payments" class="page active">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Payments / Revenue</h2>
            <p class="text-muted mb-0">Track all transactions and revenue generated</p>
        </div>
        <button class="btn btn-success"><i class="fas fa-download me-2"></i> Export Report</button>
    </div>
    
    <div class="data-table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Course</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->course->name }}</td>
                    <td class="fw-bold {{ $payment->status == 'completed' ? 'text-success' : ($payment->status == 'failed' ? 'text-danger' : 'text-warning') }}">
                        ${{ $payment->amount }}
                    </td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge 
                            {{ $payment->status == 'completed' ? 'bg-success bg-opacity-10 text-success' : '' }}
                            {{ $payment->status == 'pending' ? 'bg-warning bg-opacity-10 text-warning' : '' }}
                            {{ $payment->status == 'failed' ? 'bg-danger bg-opacity-10 text-danger' : '' }}
                            border-0">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="dashboard-footer">
        <p class="mb-0">© {{ date('Y') }} LearnHub Admin Dashboard. All rights reserved.</p>
    </div>
</div>
@endsection
