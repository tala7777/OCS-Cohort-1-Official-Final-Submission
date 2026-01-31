<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Legal Q&A</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/shared.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @yield('styles')
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
</head>
<body>
    <div class="admin-layout">
        
        @include('partials.admin-sidebar')

        <!-- Main Content -->
        <main class="admin-content">
            
            @yield('topbar')

            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script src="{{ asset('assets/js/admin-ui.js') }}"></script>
    @yield('scripts')
    @livewireScripts
    <script>
        document.addEventListener('livewire:auto-scroll-top', () => {
             window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Handle common livewire events
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('action-completed', () => {
                setTimeout(() => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 100);
            });
        });
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
