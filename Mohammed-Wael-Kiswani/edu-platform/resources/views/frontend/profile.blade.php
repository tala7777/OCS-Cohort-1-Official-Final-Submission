{{-- resources/views/frontend/profile.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - CodeLearn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="https://img.icons8.com/color/96/000000/code.png">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-code text-primary"></i> Code<span>Learn</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown" id="userDropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ $user->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Dashboard -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h1 class="fw-bold">My Dashboard</h1>
                    <p class="text-muted">Welcome back, {{ $user->name }}! Here's your learning progress.</p>
                </div>
            </div>
            
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="card dashboard-card border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <!-- User Info -->
                            <div class="position-relative d-inline-block mb-3">
                              
                                <div class="position-relative d-inline-block mb-3">

    <img src="{{ $user->profile_photo_url }}"
         alt="Profile"
         class="rounded-circle"
         width="120"
         height="120">

    <!-- زر تغيير الصورة -->
    <form id="photoForm"
          action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data"
          class="position-absolute"
          style="bottom: 10px; right: 10px;">

        @csrf
        @method('PATCH')

        <label for="profile_photo_input"
               class="btn btn-primary btn-sm rounded-circle m-0"
               style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
            <i class="fas fa-camera"></i>
        </label>

        <input type="file"
               id="profile_photo_input"
               name="profile_photo"
               accept="image/*"
               hidden
               onchange="document.getElementById('photoForm').submit();">
    </form>

</div>

                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-3">{{ $user->role ?? 'Student' }}</p>
                            <div class="d-grid">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    <i class="fas fa-edit me-2"></i>Edit Profile
                                </button>
                            </div>

                            <!-- Stats -->
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Courses Enrolled</span>
                                    <span class="fw-bold">{{ $user->courses ? $user->courses->count() : 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Completed</span>
                                    <span class="fw-bold">{{ $user->courses ? $user->courses->where('pivot.completed', 1)->count() : 0 }} ?? 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Hours Watched</span>
                                    <span class="fw-bold">{{ $user->total_hours ?? 0 }}</span>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="list-group list-group-flush mt-4">
                                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action border-0 active">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-book-open me-2"></i>My Courses
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-certificate me-2"></i>Certificates
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-cog me-2"></i>Account Settings
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-question-circle me-2"></i>Help & Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-book-open fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ optional($user->courses)->count() ?? 0 }}</h3>
                                        <p class="text-muted mb-0">Courses</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-clock fa-2x text-success"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ $user->total_hours ?? 0 }}</h3>
                                        <p class="text-muted mb-0">Hours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-trophy fa-2x text-warning"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ optional($user->certificates)->count() ?? 0 }}</h3>
                                        <p class="text-muted mb-0">Certificates</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card dashboard-card border-0 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-calendar-alt fa-2x text-info"></i>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">{{ $user->streak_days ?? 0 }}</h3>
                                        <p class="text-muted mb-0">Days Streak</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enrolled Courses -->
                    <div class="card dashboard-card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">My Courses</h4>
                                <a href="#" class="btn btn-outline-primary">Browse More Courses</a>
                            </div>
                            
                            @foreach($user->courses ?? [] as $course)
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <img src="{{ $course->image ?? '' }}" class="img-fluid rounded-start" alt="Course" style="height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="card-title">{{ $course->title ?? '' }}</h5>
                                                    <p class="card-text text-muted">
                                                        Started on: {{ optional($course->pivot->started_at)->format('M d, Y') ?? 'N/A' }}
                                                    </p>
                                                </div>
                                                <span class="badge {{ optional($course->pivot)->completed ? 'bg-success' : 'bg-primary' }}">
                                                    {{ optional($course->pivot)->completed ? 'Completed' : 'In Progress' }}
                                                </span>
                                            </div>
                                            <p class="card-text">{{ $course->description ?? '' }}</p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="small">Progress</span>
                                                        <span class="small fw-bold">{{ optional($course->pivot)->progress ?? 0 }}%</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar" role="progressbar" style="width: {{ optional($course->pivot)->progress ?? 0 }}%"></div>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-primary">Continue Learning</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card dashboard-card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Recent Activity</h4>
                            @foreach($user->activities ?? [] as $activity)
                                <div class="timeline-item mb-4">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">{{ $activity->title ?? '' }}</h6>
                                        <p class="text-muted small mb-1">{{ $activity->course->title ?? '' }}</p>
                                        <p class="text-muted small">{{ optional($activity->created_at)->diffForHumans() ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Profile Photo</label>
                           <input type="file" name="profile_photo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3">{{ $user->bio ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <input type="text" class="form-control" id="skills" name="skills" value="{{ $user->skills ?? '' }}">
                            <div class="form-text">Separate skills with commas</div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ $user->location ?? '' }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <!-- Footer content as before -->
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <style>
        .timeline { position: relative; padding-left: 30px; }
        .timeline-item { position: relative; }
        .timeline-marker { position: absolute; left: -30px; top: 5px; width: 12px; height: 12px; border-radius: 50%; }
        .timeline-content { padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .timeline-item:last-child .timeline-content { border-bottom: none; padding-bottom: 0; }
    </style>
</body>
</html>
