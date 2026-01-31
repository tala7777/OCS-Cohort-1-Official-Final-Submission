<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CodeMaster Admin | @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Admin Dashboard CSS -->

    {{-- لو بدك ستايل خاص لكل صفحة --}}
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
 @stack('styles')
</head>
<body>

    <!-- Overlay (Mobile) -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <div class="wrapper">

        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Main Content -->
        <div id="content">
            @yield('content')
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar   = document.getElementById('sidebar');
            const overlay   = document.getElementById('overlay');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>

    {{-- سكربتات إضافية لكل صفحة --}}
    @stack('scripts')

</body>
</html>
