<nav class="navbar navbar-expand-lg navbar-dark fixed-top public-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-balance-scale me-2"></i>Ask a Lawyer
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('index') || request()->routeIs('question-details') ? 'active' : '' }}" href="{{ route('index') }}">Questions</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('lawyers') || request()->routeIs('lawyer-profile') ? 'active' : '' }}" href="{{ route('lawyers') }}">Lawyers</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog') || request()->routeIs('article.*') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a></li>
                @auth
                    @if(Auth::user()->role === 'lawyer')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('lawyer.dashboard') ? 'active' : '' }}" href="{{ route('lawyer.dashboard') }}">Lawyer Panel</a></li>
                    @endif
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                    @endif
                @endauth
                @if(request()->routeIs('ask-question'))
                 <li class="nav-item"><a class="nav-link active" href="{{ route('ask-question') }}">Ask Question</a></li>
                @endif
            </ul>
            
            <form class="d-flex mx-lg-4 my-2 my-lg-0 flex-grow-1" action="{{ url('/search') }}" method="GET" style="max-width: 400px;">
                <div class="input-group">
                    <button class="input-group-text bg-transparent border-secondary text-light" type="submit"><i class="fas fa-search"></i></button>
                    <input type="search" name="search" class="form-control bg-transparent border-secondary text-light" placeholder="Search questions, lawyers..." aria-label="Search" value="{{ request()->get('search')??null }}">
                </div>
            </form>

            <div class="d-flex align-items-center gap-3">
            
                
                @guest
                <div class="auth-buttons d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                </div>
                @endguest

                @auth
                <div class="user-menu ms-lg-2">
                     <div class="dropdown">
                        <button class="btn btn-link text-white text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->lawyerProfile?->profile_photo_path)   
                                <img src="{{ Str::startsWith(Auth::user()->lawyerProfile?->profile_photo_path, 'http') ? Auth::user()->lawyerProfile?->profile_photo_path : asset('storage/' . Auth::user()->lawyerProfile?->profile_photo_path) }}" class="rounded-circle shadow-sm" alt="Profile">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; font-size: 0.8rem; font-weight: 700;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow border-secondary animate-fade-up" style="border-radius: 12px; min-width: 200px;">
                             <li>
                                <div class="px-3 py-2 border-bottom border-white/10 mb-2">
                                    <p class="text-white fw-bold mb-0 small">{{ Auth::user()->name }}</p>
                                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">{{ Auth::user()->email }}</p>
                                </div>
                             </li>
                             
                             @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line me-2 opacity-75"></i>Admin Dashboard</a></li>
                             @elseif(Auth::user()->role === 'lawyer')
                                <li><a class="dropdown-item py-2" href="{{ route('lawyer.dashboard') }}"><i class="fas fa-columns me-2 opacity-75"></i>Lawyer Dashboard</a></li>
                             @endif

                             <li><hr class="dropdown-divider opacity-10"></li>
                             <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                </form>
                                <a class="dropdown-item py-2 text-warning" href="#" onclick="confirmUserLogout(event)">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                             </li>
                        </ul>
                     </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    function confirmUserLogout(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your account.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#eab308', // Using gold/warning color for public site
            cancelButtonColor: '#d33',
            background: '#1e293b',
            color: '#fff',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
@php
    $isPendingLawyer = Auth::check() && Auth::user()->role === 'lawyer' && Auth::user()->lawyerProfile?->status === 'pending';
@endphp

<div id="pendingLawyerBanner" class="bg-warning text-dark text-center py-2 fw-bold {{ $isPendingLawyer ? '' : 'd-none' }}" style="margin-top: 75px;">
    <div class="container">
        <i class="fas fa-exclamation-triangle me-2"></i> Pending admin approval. You cannot answer or post articles yet.
    </div>
</div>
