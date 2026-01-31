<aside class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-mortarboard-fill me-2" style="color: var(--primary);"></i>
        EduTrack Student
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('student.dashboard') }}"
            class="nav-item {{ request()->is('student/dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('student.subjects.index') }}"
            class="nav-item {{ request()->routeIs('student.subjects.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            <span>My Subjects</span>
        </a>
        <a href="{{ route('student.assignments.index') }}"
            class="nav-item {{ request()->routeIs('student.assignments.*') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i>
            <span>Homework</span>
        </a>
        <a href="{{ route('student.attendance.index') }}"
            class="nav-item {{ request()->routeIs('student.attendance.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Attendance</span>
        </a>
        <a href="{{ route('student.grades.index') }}"
            class="nav-item {{ request()->routeIs('student.grades.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span>Grades</span>
        </a>
    </nav>
</aside>