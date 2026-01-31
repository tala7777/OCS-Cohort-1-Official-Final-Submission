<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-sans antialiased">
    <div class="layout">
        @include('partials.teacher.sidebar')

        <div class="main-content">
            @include('partials.teacher.header')

            <main class="page-content">
                @if(session('success'))
                    <div class="alert alert-success mx-4 mt-4">
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('sidebar-toggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    document.querySelector('.sidebar').classList.toggle('open');
                });
            }
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>

</html>