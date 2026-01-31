<footer class="footer">
    <div class="container">
        <div class="row g-5">
            <!-- Brand & Bio -->
            <div class="col-lg-4 col-md-6">
                <a class="d-flex align-items-center mb-4 text-decoration-none" href="{{ route('home') }}">
                    <div class="bg-soft-warning p-2 rounded-3 me-3">
                        <i class="fas fa-balance-scale fa-lg text-warning"></i>
                    </div>
                    <span class="fs-3 fw-bold text-white letter-spacing-1">Legal<span class="text-warning">Q&A</span></span>
                </a>
                <p class="text-secondary mb-4 pb-2" style="line-height: 1.8;">
                    Empowering citizens through accessible legal expertise. We connect you with verified professionals to navigate complex legal matters with confidence and clarity.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-icon-btn" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon-btn" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-title">Platform</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                    <li class="mb-3"><a href="{{ route('index') }}" class="footer-link">Legal Questions</a></li>
                    <li class="mb-3"><a href="{{ route('lawyers') }}" class="footer-link">Verified Lawyers</a></li>
                    <li class="mb-3"><a href="{{ route('blog') }}" class="footer-link">Legal Insights</a></li>
                </ul>
            </div>

            <!-- Professional Section -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="footer-title">Professional</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="{{ route('lawyer-request') }}" class="footer-link">Lawyer Registration</a></li>
                    <li class="mb-3"><a href="{{ route('login') }}" class="footer-link">Expert Portal</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Partner Program</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">API Access</a></li>
                </ul>
            </div>

            <!-- Newsletter Area -->
            <div class="col-lg-4 col-md-6">
                <div class="newsletter-box">
                    <h6 class="text-white fw-bold mb-3">Newsletter Subscription</h6>
                    <p class="text-secondary small mb-4">Get curated legal updates and expert tips delivered to your inbox weekly.</p>
                    <form action="#" class="mb-0">
                        <div class="position-relative">
                            <input type="email" class="form-control rounded-pill border-0 py-3 ps-4 pe-5" 
                                   placeholder="Email address" 
                                   style="background: rgba(255,255,255,0.05); color: #fff; font-size: 0.9rem;">
                            <button class="btn btn-warning rounded-circle position-absolute top-50 end-0 translate-middle-y me-1" 
                                    style="width: 38px; height: 38px; padding: 0;">
                                <i class="fas fa-paper-plane fa-sm"></i>
                            </button>
                        </div>
                    </form>
                    <div class="mt-4 pt-2 d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2 text-warning small">
                            <i class="fas fa-shield-alt"></i>
                            <span class="text-secondary">GDPR Compliant</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-warning small">
                            <i class="fas fa-lock"></i>
                            <span class="text-secondary">SSL Secure</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright Area -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="text-muted small mb-0">
                        &copy; {{ date('Y') }} <span class="text-white fw-semibold">LegalQ&A</span>. All rights reserved. 
                        Designed with <i class="fas fa-heart text-danger mx-1"></i> for legal clarity.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end align-items-center gap-3">
                        <a href="#" class="text-muted text-decoration-none small footer-link p-0">Privacy Policy</a>
                        <span class="text-secondary opacity-25">|</span>
                        <a href="#" class="text-muted text-decoration-none small footer-link p-0">Terms of Service</a>
                        <span class="text-secondary opacity-25">|</span>
                        <a href="#" class="text-muted text-decoration-none small footer-link p-0">Site Map</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
