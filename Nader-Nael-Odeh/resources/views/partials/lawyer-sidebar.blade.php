<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('lawyer.dashboard') }}" class="text-decoration-none">
            <h3 class="mb-0"><i class="fas fa-balance-scale me-2"></i> Lawyer Area</h3>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('lawyer.dashboard') }}" class="nav-item {{ request()->is('lawyer/dashboard') || request()->routeIs('lawyer.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="nav-section-title">Work</div>

        <a href="{{ route('lawyer.questions.index') }}" class="nav-item {{ request()->is('lawyer/questions*') || request()->routeIs('lawyer.questions.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i> Browse Questions
        </a>

        <a href="{{ route('lawyer.answers.index') }}" class="nav-item {{ request()->is('lawyer/answers*') || request()->routeIs('lawyer.answers.*') ? 'active' : '' }}">
            <i class="fas fa-gavel"></i> My Answers
        </a>

        <a href="{{ route('lawyer.articles.index') }}" class="nav-item {{ request()->is('lawyer/articles*') || request()->routeIs('lawyer.articles.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> My Articles
        </a>

        <div class="nav-section-title">Profile</div>

        <a href="{{ route('lawyer.profile.edit') }}" class="nav-item {{ request()->is('lawyer/profile*') || request()->routeIs('lawyer.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-edit"></i> Edit Profile
        </a>

        <div class="nav-section-title">System</div>

        <a href="{{ route('home') }}" class="nav-item">
            <i class="fas fa-home"></i> Back to Home
        </a>
    </nav>
</aside>
