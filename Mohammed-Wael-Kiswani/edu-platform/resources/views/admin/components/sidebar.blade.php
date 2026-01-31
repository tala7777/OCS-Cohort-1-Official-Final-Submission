<!-- Sidebar -->
<div id="sidebar">
    <div class="sidebar-header p-3">
        <h4><i class="fas fa-graduation-cap me-2"></i>CodeLearn</h4>
    </div>

    <ul class="sidebar-menu list-unstyled">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}" data-page="dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>

        <!-- Users Management -->
        <li>
            <a href="{{ route('admin.users.index') }}" data-page="users">
                <i class="fas fa-user-friends"></i>
                <span class="menu-text">Users Management</span>
            </a>
        </li>

        <!-- Courses Management -->
        <li>
            <a href="{{ route('admin.courses.index') }}" data-page="courses">
                <i class="fas fa-book-open"></i>
                <span class="menu-text">Courses Management</span>
            </a>
        </li>

        <!-- Lessons / Videos -->
        <li>
            <a href="{{ route('admin.lessons.index') }}" data-page="lessons">
                <i class="fas fa-play-circle"></i>
                <span class="menu-text">Lessons / Videos</span>
            </a>
        </li>

        <!-- Payments / Revenue -->
        <li>
            <a href="{{ route('admin.payments.index') }}" data-page="payments">
                <i class="fas fa-credit-card"></i>
                <span class="menu-text">Payments / Revenue</span>
            </a>
        </li>

    
       
    </ul>

    <div class="sidebar-footer p-4 mt-auto text-center text-white-50">
        <small>Version 2.1.0</small>
        <div class="mt-2">
            <i class="fas fa-circle text-success me-1"></i>
            <small>System is running smoothly</small>
        </div>
    </div>
</div>
