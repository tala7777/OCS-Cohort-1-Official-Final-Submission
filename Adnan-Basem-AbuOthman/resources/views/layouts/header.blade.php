@auth
    @if (Auth::user()->role == 'student')
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">Sakan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavStudent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavStudent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('universitiesPage') }}">Universities</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('apartmentspage') }}">Apartments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact Us</a></li>
                    </ul>



                    <div class="dropdown pe-3">
                        <a href="#" class="text-dark position-relative me-2" id="notificationDropdownStudent"
                            data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                            <i class="bi bi-bell fs-5"></i>
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.7rem;">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                            aria-labelledby="notificationDropdownStudent" style="min-width: 280px;">
                            <li>
                                <h6 class="dropdown-header">Notifications</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <li class="d-flex align-items-center px-3 py-2 border-bottom">
                                    <a class="text-decoration-none text-dark flex-grow-1 me-2"
                                        href="{{ $notification->data['url'] ?? '#' }}">
                                        <div class="small fw-bold" style="line-height: 1.2;">
                                            {{ $notification->data['message'] }}</div>
                                        <small class="text-muted"
                                            style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                    </a>

                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm text-danger border-0 p-0" title="Delete">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="dropdown-item text-center text-muted py-3">No new notifications</li>
                            @endforelse
                        </ul>
                    </div>




                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('messages.index') }}" class="text-dark position-relative me-2" title="Messages">
                            <i class="bi bi-chat-dots fs-5"></i>

                        </a>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="studentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-2"
                                    style="width: 35px; height: 35px;">
                                    <i class="bi bi-person text-secondary"></i>
                                </div>
                                <span class="text-dark fw-medium">{{ Auth::user()->name }} </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="studentDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('profile.edit', Auth::user()->id) }}">Profile</a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>


                                <li>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                            class="dropdown-item text-danger">Sign out</a>

                                    </form>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @elseif(Auth::user()->role == 'owner')
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">Sakan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavOwner">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavOwner">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('universitiesPage') }}">Universities</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('apartmentspage') }}">Apartments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold text-primary"
                                href="{{ route('owner.index') }}">Owner Dashboard</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">





                        <div class="dropdown pe-3">
                            <a href="#" class="text-dark position-relative me-2" id="notificationDropdownStudent"
                                data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                                <i class="bi bi-bell fs-5"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                        style="font-size: 0.65rem;">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                                aria-labelledby="notificationDropdownStudent" style="min-width: 280px;">
                                <li>
                                    <h6 class="dropdown-header">Notifications</h6>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li class="d-flex align-items-center px-3 py-2 border-bottom">
                                        <a class="text-decoration-none text-dark flex-grow-1"
                                            href="{{ $notification->data['url'] ?? '#' }}">
                                            <div class="small fw-semibold" style="line-height: 1.2;">
                                                {{ $notification->data['message'] }}</div>
                                            <small class="text-muted"
                                                style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                        </a>

                                        <form action="{{ route('notifications.destroy', $notification->id) }}"
                                            method="POST" class="ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0" title="Delete">
                                                <i class="bi bi-x-lg" style="font-size: 0.85rem;"></i>
                                            </button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="dropdown-item text-center text-muted py-3">No new notifications</li>
                                @endforelse
                            </ul>
                        </div>





                        <a href="{{ route('messages.index') }}" class="text-dark position-relative me-2"
                            title="Messages">
                            <i class="bi bi-chat-dots fs-5"></i>
                        </a>

                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="ownerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-2"
                                    style="width: 35px; height: 35px;">
                                    <i class="bi bi-building text-secondary"></i>
                                </div>
                                <span class="text-dark fw-medium">{{ Auth::user()->name }} </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="ownerDropdown">
                                <li><a class="dropdown-item" href="{{ route('owner.index') }}">Dashboard</a></li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                            class="dropdown-item text-danger">Sign out</a>

                                    </form>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @elseif(Auth::user()->role == 'admin')
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">Sakan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAdmin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAdmin">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('universitiesPage') }}">Universities</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('apartmentspage') }}">Apartments</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold text-danger"
                                href="{{ route('admin.index') }}">Dashboard</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-2"
                                    style="width: 35px; height: 35px;">
                                    <i class="bi bi-shield-lock text-danger"></i>
                                </div>
                                <span class="text-dark fw-medium">{{ Auth::user()->name }} </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.index') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin_profile.index') }}">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                            class="dropdown-item text-danger">Sign out</a>

                                    </form>
                                </li>





                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @endif
@else
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">Sakan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('universitiesPage') }}">Universities</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('apartmentspage') }}">Apartments</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact Us</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-nav-signup">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>



@endauth
