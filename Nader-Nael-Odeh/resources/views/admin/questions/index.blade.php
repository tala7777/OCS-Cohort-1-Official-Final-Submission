@extends('layouts.admin')

@section('title', 'Questions Management')

@section('topbar')
    @include('partials.admin-topbar', ['title' => 'Questions Management'])
@endsection

@section('content')
    <livewire:admin.questions />
@endsection

@section('scripts')
<script>
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
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(event.callback, { id: event.id });
                }
            });
        });
    });
</script>
@endsection
