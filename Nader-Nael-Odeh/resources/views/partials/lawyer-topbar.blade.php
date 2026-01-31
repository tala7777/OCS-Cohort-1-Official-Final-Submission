<header class="admin-topbar">
    <div class="topbar-left">
        <button id="mobile-menu-toggle" class="btn btn-link d-md-none">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0">@yield('page-title', 'Lawyer Workspace')</h5>
    </div>
    



    
    <div class="topbar-right">
        <div class="user-menu dropdown">
            <button class="btn btn-link dropdown-toggle text-decoration-none" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                @php
                    $profilePhoto = auth()->user()->lawyerProfile->profile_photo_path ?? null;
                @endphp
                
                @if($profilePhoto)
                    <img src="{{ asset('storage/' . $profilePhoto) }}" alt="User" class="user-avatar rounded-circle object-fit-cover" width="32" height="32">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="User" class="user-avatar rounded-circle" width="32" height="32">
                @endif
                <span class="d-none d-md-inline ms-2 fw-medium">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-secondary bg-dark p-2" aria-labelledby="userMenu">
                <li>
                    <a class="dropdown-item rounded py-2 text-white hover-bg-primary d-flex align-items-center" href="{{ route('lawyer.profile.edit') }}">
                        <i class="fas fa-user-circle me-3 opacity-75"></i>My Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider bg-secondary opacity-25 my-2"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item rounded py-2 text-danger hover-bg-danger-subtle d-flex align-items-center w-100">
                            <i class="fas fa-sign-out-alt me-3"></i>Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
