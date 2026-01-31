<header class="navbar px-4">
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-secondary d-lg-none me-3" id="sidebar-toggle">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="mb-0 d-none d-md-block">Teacher Portal</h5>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
            <button class="btn dropdown-toggle d-flex align-items-center gap-2 border-0" type="button"
                data-bs-toggle="dropdown">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                            class="bi bi-person me-2"></i>Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i
                                class="bi bi-box-arrow-right me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>