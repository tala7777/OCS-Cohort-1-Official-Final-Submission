@extends('layouts.admin')

@section('title', 'User Management')

@section('topbar')
    @include('partials.admin-topbar', ['title' => 'User Management'])
@endsection

@section('content')
    <livewire:admin.users-management />
@endsection

@section('scripts')
<script>
    // Livewire SweetAlert Listeners for Confirmations
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:confirm', (data) => {
            const event = Array.isArray(data) ? data[0] : data;
            Swal.fire({
                title: event.title,
                text: event.text,
                icon: event.type,
                background: '#1e293b',
                color: '#e5e7eb',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteConfirmed', { id: event.id });
                }
            });
        });
    });
</script>
@endsection
