<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - LegalQ&A</title>
    @include('partials.head')

    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
</head>
<body class="bg-dark text-white">

    @include('partials.public-navbar')

    <!-- MAIN CONTENT -->
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header border-secondary p-4 d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0 fw-bold"><i class="fas fa-pen-nib me-2 text-primary"></i>Edit Article</h2>
                        <span class="badge bg-warning text-dark">Draft Mode</span>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="editArticleForm" onsubmit="event.preventDefault(); saveArticle();">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Article Title</label>
                                <input type="text" class="form-control form-control-lg" name="title" value="Understanding the New Commercial Courts Law" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Category</label>
                                <select class="form-select" name="category" required>
                                    <option value="">Select Category...</option>
                                    <option value="Corporate Law" selected>Corporate Law</option>
                                    <option value="Real Estate">Real Estate</option>
                                    <option value="Intellectual Property">Intellectual Property</option>
                                    <option value="Criminal Law">Criminal Law</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Content</label>
                                <textarea class="form-control" rows="12" required>The new Commercial Courts Law in Saudi Arabia represents a significant shift towards efficiency and modernization in the legal landscape.

Key provisions include:
1. Digital case management
2. Strict timelines for proceedings
3. Private sector involvement in enforcement

[Sample content truncated for editing...]</textarea>
                                <small class="text-muted">Markdown formatting supported.</small>
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Tags</label>
                                <input type="text" class="form-control" name="tags" value="Corporate, Saudi Law, Commercial Court, Business">
                                <small class="text-muted">Comma separated tags.</small>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-end gap-3 pt-3 border-top border-secondary">
                                <button type="button" class="btn btn-outline-light" onclick="window.history.back()">Cancel</button>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="saveToast" class="toast bg-success text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <i class="fas fa-check-circle me-2"></i> Demo: Article updated locally!
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/ui.js') }}"></script>
    <script>
        function saveArticle() {
            const toastEl = document.getElementById('saveToast');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();

            // Redirect back after delay
            setTimeout(() => {
                window.location.href = 'edit-lawyer-profile.html?id=1';
            }, 1500);
        }
    </script>
</body>
</html>

