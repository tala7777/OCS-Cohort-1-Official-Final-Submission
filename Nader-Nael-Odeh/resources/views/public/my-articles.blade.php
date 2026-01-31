@extends('layouts.app')

@section('title', 'My Articles - Legal Q&A')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
@endsection

@section('content')
    <div class="container py-5" style="margin-top: 60px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-file-alt me-2"></i>My Articles</h2>
            <a href="{{ route('new-article') }}" class="btn btn-primary" id="newArticleBtn" style="display: none;">
                <i class="fas fa-plus me-2"></i>Write New Article
            </a>
        </div>

        <!-- Access Denied -->
        <div id="accessDenied" style="display: none;">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Access Denied:</strong> Only lawyers can access this page.
            </div>
            <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
        </div>

        <!-- Articles List (only for lawyers) -->
        <!-- BACKEND: GET /api/articles?author={current_user_id} -->
        <div id="articlesContainer" style="display: none;">
            <div class="row g-4">
                <!-- Sample Article 1 -->
                <div class="col-12">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2">Understanding Corporate Governance in UAE</h5>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="fas fa-tag me-1"></i>Corporate Law</span>
                                        <span><i class="fas fa-calendar me-1"></i>2026-01-13</span>
                                        <span><i class="fas fa-eye me-1"></i>245 views</span>
                                    </div>
                                </div>
                                <span class="badge badge-success">Published</span>
                            </div>
                            <p class="text-secondary mb-3">
                                A comprehensive guide to corporate governance principles and best practices in the United Arab Emirates...
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('article-details') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <button class="btn btn-sm btn-outline-warning" onclick="editArticle('ART-001')">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteArticle('ART-001')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Article 2 -->
                <div class="col-12">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2">Starting a Business in UAE Free Zones</h5>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="fas fa-tag me-1"></i>Corporate Law</span>
                                        <span><i class="fas fa-calendar me-1"></i>2026-01-08</span>
                                        <span><i class="fas fa-eye me-1"></i>189 views</span>
                                    </div>
                                </div>
                                <span class="badge badge-success">Published</span>
                            </div>
                            <p class="text-secondary mb-3">
                                Everything you need to know about establishing your business in one of UAE's many free zones...
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('article-details') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <button class="btn btn-sm btn-outline-warning" onclick="editArticle('ART-002')">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteArticle('ART-002')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Draft -->
                <div class="col-12">
                    <div class="card card-hover" style="opacity: 0.8;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-2">Mergers and Acquisitions in the UAE</h5>
                                    <div class="d-flex gap-3 text-muted small">
                                        <span><i class="fas fa-tag me-1"></i>Corporate Law</span>
                                        <span><i class="fas fa-calendar me-1"></i>2026-01-05</span>
                                    </div>
                                </div>
                                <span class="badge badge-secondary">Draft</span>
                            </div>
                            <p class="text-secondary mb-3">
                                An in-depth analysis of M&A regulations and procedures...
                            </p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary" onclick="continueDraft('ART-003')">
                                    <i class="fas fa-pen me-1"></i>Continue Writing
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteArticle('ART-003')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" style="display: none;">
                <div class="text-center py-5">
                    <i class="fas fa-file-alt" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h4 class="mt-3 text-secondary">No Articles Yet</h4>
                    <p class="text-muted">Start sharing your legal expertise by writing your first article.</p>
                    <a href="{{ route('new-article') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Write Your First Article
                    </a>
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
            console.log('My Articles Role Check:', role);

            const container = document.getElementById('articlesContainer');
            const newBtn = document.getElementById('newArticleBtn');
            const denied = document.getElementById('accessDenied');

            // Hide all first
            if(container) container.style.display = 'none';
            if(newBtn) newBtn.style.display = 'none';
            if(denied) denied.style.display = 'none';

            if (role === 'lawyer-approved' || role === 'lawyer-pending') {
                if(container) container.style.display = 'block';
                if (role === 'lawyer-approved') {
                   if(newBtn) newBtn.style.display = 'block';
                }
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

        // Edit article
        function editArticle(articleId) {
            showToast('Demo Mode: Edit functionality will be connected to PHP backend later.', 'info');
        }

        // Delete article
        function deleteArticle(articleId) {
            if (confirm('Are you sure you want to delete this article?')) {
                showToast('Demo Mode: Article deletion will be connected to PHP backend later.');
            }
        }

        // Continue draft
        function continueDraft(articleId) {
            window.location.href = "{{ route('new-article') }}?draft=" + articleId;
        }
    </script>
@endsection
