<header class="admin-topbar">
    <h1 class="topbar-title">{{ $title ?? 'Admin Panel' }}</h1>
    
    <div class="topbar-search ms-4 flex-grow-1" style="max-width: 400px;">
      
    </div>
    
    <div class="topbar-actions">
        <div class="user-menu">
            <div class="user-avatar">A</div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" id="admin-logout-form">
            @csrf
        </form>
        <button class="btn btn-outline-danger btn-sm" onclick="confirmAdminLogout()">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </div>
</header>
<script>
    function confirmAdminLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of the admin panel.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            background: '#1e293b',
            color: '#fff',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('admin-logout-form').submit();
            }
        })
    }
</script>
