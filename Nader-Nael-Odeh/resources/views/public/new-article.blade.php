@extends('layouts.app')

@section('title', 'Write Article - Legal Q&A')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
@endsection

@section('content')
    <div class="container py-5" style="margin-top: 60px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0"><i class="fas fa-pen me-2"></i>Write New Article</h3>
                    </div>
                    <div class="card-body">
                        <!-- Lawyer-only check -->
                        <div id="accessDenied" style="display: none;">
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Access Denied:</strong> Only approved lawyers can write articles.
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                        </div>

                        <div id="pendingWarning" style="display: none;">
                            <div class="alert alert-warning">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Pending Approval:</strong> Your lawyer verification is pending. You cannot post articles yet.
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                        </div>

                        <!-- Article Form (only for approved lawyers) -->
                        <!-- BACKEND: POST /api/articles -->
                        <form id="articleForm" style="display: none;">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Article Title</label>
                                <input type="text" class="form-control" name="title" placeholder="e.g., Understanding Corporate Governance in UAE" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Category</label>
                                <select class="form-select" name="category" required>
                                    <option value="">Select a category...</option>
                                    <option value="Corporate Law">Corporate Law</option>
                                    <option value="Family Law">Family Law</option>
                                    <option value="Criminal Law">Criminal Law</option>
                                    <option value="IP Law">IP Law</option>
                                    <option value="Real Estate">Real Estate</option>
                                    <option value="Employment Law">Employment Law</option>
                                    <option value="Tax Law">Tax Law</option>
                                    <option value="Immigration">Immigration</option>
                                    <option value="Consumer Rights">Consumer Rights</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Article Content</label>
                                <textarea class="form-control" name="content" rows="15" placeholder="Write your article here..." required></textarea>
                                <small class="text-muted">You can use markdown formatting</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Tags (optional)</label>
                                <input type="text" class="form-control" name="tags" placeholder="e.g., business, startup, LLC">
                                <small class="text-muted">Separate tags with commas</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Publish Article
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                                    <i class="fas fa-save me-2"></i>Save Draft
                                </button>
                                <a href="{{ route('my-articles') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/shared.js') }}"></script>
    <script>
        // Use shared Toast if available
        const showToast = (msg, type='success') => {
            if (typeof Toast !== 'undefined') {
                if(type === 'success') Toast.success(msg);
                else Toast.info(msg);
            }
            else alert(msg);
        };

        // Check if user has access
        function checkAccess() {
            // Wait for ui.js to possibly set the role, or default to what's in session/window
            const role = window.currentDemoRole || sessionStorage.getItem('demoRole') || 'guest';
            console.log('New Article Role Check:', role);

            const form = document.getElementById('articleForm');
            const pending = document.getElementById('pendingWarning');
            const denied = document.getElementById('accessDenied');

            // Hide all first
            form.style.display = 'none';
            if(pending) pending.style.display = 'none';
            if(denied) denied.style.display = 'none';

            if (role === 'lawyer-approved') {
                form.style.display = 'block';
            } else if (role === 'lawyer-pending') {
                if(pending) pending.style.display = 'block';
            } else {
                if(denied) denied.style.display = 'block';
            }
        }

        // Run on load
        document.addEventListener('DOMContentLoaded', () => {
             checkAccess();

             // Listen for changes from the navbar selector
             const selector = document.getElementById('roleSelector');
             if (selector) {
                 selector.addEventListener('change', () => {
                     setTimeout(checkAccess, 50);
                 });
             }
        });

        // Handle form submission
        document.getElementById('articleForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            showToast('Demo Mode: Article will be published via PHP backend later.');
            setTimeout(() => {
                window.location.href = "{{ route('my-articles') }}";
            }, 1500);
        });

        // Save draft
        function saveDraft() {
            showToast('Demo Mode: Draft will be saved via PHP backend later.', 'info');
        }
    </script>
@endsection
