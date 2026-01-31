<!-- Sidebar -->
<aside class="dashboard-sidebar" style="background-color: #111827;">
    <a href="{{ route('admin.index') }}" class="sidebar-brand">
        <i class="bi bi-shield-lock"></i> Sakan Admin
    </a>





    <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
            <a href="{{ route('admin.index') }}" id="Overview" class="sidebar-nav-link">
                <i class="bi bi-speedometer2"></i> Overview
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('universities.index') }}" id="Universities" class="sidebar-nav-link">
                <i class="bi bi-mortarboard"></i> Universities
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('users.index') }}" id="Users" class="sidebar-nav-link">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('apartments.index') }}" id="Apartments" class="sidebar-nav-link">
                <i class="bi bi-houses"></i> Apartments
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('admins.index') }}" id="Admins" class="sidebar-nav-link">
                <i class="bi bi-person-plus"></i> Admins
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('admin_profile.index') }}" id="Profile" class="sidebar-nav-link">
                <i class="bi bi-person-circle"></i> Profile
            </a>
        </li>
    </ul>








    <div class="sidebar-footer">

        <a href="{{ route('index') }}" class="sidebar-nav-link text-white">
            <i class="bi bi-box-arrow-right"></i> Home Page
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <a href="{{ route('logout') }}" class="sidebar-nav-link text-danger"
                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>

        </form>


    </div>




</aside>
