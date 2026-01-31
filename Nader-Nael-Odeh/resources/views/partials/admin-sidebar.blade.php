<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <h3><i class="fas fa-balance-scale"></i> Legal Admin</h3>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        
        <div class="nav-section-title">Management</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->is('admin/users*') || request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        <a href="{{ route('admin.lawyer-requests') }}" class="nav-item {{ request()->is('admin/lawyer-requests*') || request()->routeIs('admin.lawyer-requests*') ? 'active' : '' }}">
            <i class="fas fa-user-check"></i>
            <span>Lawyer Requests</span>
        </a>
        <a href="{{ route('admin.questions') }}" class="nav-item {{ request()->is('admin/questions*') || request()->routeIs('admin.questions*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i>
            <span>Questions</span>
        </a>
        <a href="{{ route('admin.articles') }}" class="nav-item {{ request()->is('admin/articles*') || request()->routeIs('admin.articles*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Articles</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="nav-item {{ request()->is('admin/categories*') || request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>Categories</span>
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="nav-item" target="_blank">
            <i class="fas fa-external-link-alt"></i>
            <span>Public Site</span>
        </a>
    </div>
</aside>
