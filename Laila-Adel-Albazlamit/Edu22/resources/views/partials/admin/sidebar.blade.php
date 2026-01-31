<aside class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-mortarboard-fill me-2" style="color: var(--primary);"></i>
        EduTrack Admin
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.classes.index') }}"
            class="nav-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Classes</span>
        </a>
        <a href="{{ route('admin.sections.index') }}"
            class="nav-item {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">
            <i class="bi bi-layers"></i>
            <span>Sections</span>
        </a>
        <a href="{{ route('admin.subjects.index') }}"
            class="nav-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            <span>Subjects</span>
        </a>
        <a href="{{ route('admin.users.index') }}"
            class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-users"></i>
            <span>Users</span>
        </a>
    </nav>
</aside>