<!-- Sidebar -->
<aside class="dashboard-sidebar">
    <a href="{{ route('index') }}" class="sidebar-brand">
        <i class="bi bi-house-check"></i> Sakan
    </a>

    <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
            <a href="{{ route('owner.index') }}" id="Dashboard" class="sidebar-nav-link">
                <i class="bi bi-grid"></i> Dashboard
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('owner_apartments.index') }}" id="Apartments" class="sidebar-nav-link">
                <i class="bi bi-building"></i> My Apartments
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('request.index') }}" id="Requests" class="sidebar-nav-link">
                <i class="bi bi-people"></i> Requests
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('messages.index') }}" id="Messages" class="sidebar-nav-link">
                <i class="bi bi-chat"></i> Messages
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('ownerprofile.edit', Auth::user()->id) }}" id="Profile" class="sidebar-nav-link">
                <i class="bi bi-person"></i> My Profile
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
