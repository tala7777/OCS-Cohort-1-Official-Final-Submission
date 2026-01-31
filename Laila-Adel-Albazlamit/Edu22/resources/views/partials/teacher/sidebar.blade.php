<aside class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-book-half me-2" style="color: var(--primary);"></i>
        EduTrack Teacher
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('teacher.dashboard') }}"
            class="nav-item {{ request()->is('teacher/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('teacher.subjects.index') }}"
            class="nav-item {{ request()->routeIs('teacher.subjects.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            <span>My Subjects</span>
        </a>
        <a href="{{ route('teacher.attendance.index') }}"
            class="nav-item {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Attendance</span>
        </a>
        <a href="{{ route('teacher.assignments.index') }}"
            class="nav-item {{ request()->routeIs('teacher.assignments.*') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i>
            <span>Homework</span>
        </a>
        <a href="{{ route('teacher.grades.index') }}"
            class="nav-item {{ request()->routeIs('teacher.grades.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Gradebook</span>
        </a>
    </nav>
</aside>