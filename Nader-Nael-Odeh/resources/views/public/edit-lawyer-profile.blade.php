@extends('layouts.app')

@section('title', 'Edit Lawyer Profile - LegalQ&A')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
@endsection

@section('content')
    <div class="container py-5" style="margin-top: 60px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
             <h2 class="mb-0 fw-bold">Edit Profile & Content</h2>
             <a href="{{ route('lawyer-profile') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Back to Profile</a>
        </div>

        <div class="row g-4">
            <!-- SECTION 1: EDIT PROFILE -->
            <div class="col-12">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header border-secondary p-4 bg-transparent">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2 text-primary"></i>Profile Details</h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <!-- BACKEND: POST /api/lawyer/profile/update -->
                        <form id="editProfileForm" method="POST" action="{{ route('lawyer-profile') }}" enctype="multipart/form-data" onsubmit="return handleProfileSubmit(event);">
                            @csrf
                            @method('PUT')
                            
                            <!-- Profile Picture Section -->
                            <div class="mb-5">
                                <label class="form-label fw-bold d-block mb-3">Profile Picture</label>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="position-relative">
                                        <img id="profilePreview" src="https://ui-avatars.com/api/?name=Marcus+Aurelius&background=0d6efd&color=fff&size=120" 
                                             class="rounded-circle border border-3 border-primary shadow" 
                                             width="120" height="120" alt="Profile Picture">
                                        <button type="button" 
                                                class="btn btn-sm btn-primary rounded-circle position-absolute d-flex align-items-center justify-content-center" 
                                                onclick="document.getElementById('profilePicInput').click()" 
                                                style="width: 40px; height: 40px; bottom: 0; right: 0; padding: 0;">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" id="profilePicInput" name="profile_picture" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewProfilePic(event)">
                                        <input type="hidden" id="removeProfilePic" name="remove_profile_picture" value="0">
                                        <button type="button" class="btn btn-outline-primary btn-sm mb-2" onclick="document.getElementById('profilePicInput').click()">
                                            <i class="fas fa-upload me-2"></i>Upload New Picture
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm mb-2 ms-2" onclick="removeProfilePic()">
                                            <i class="fas fa-trash me-2"></i>Remove
                                        </button>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recommended: Square image, at least 400x400px. Max 5MB. (JPG, PNG, WebP)
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name="full_name" value="Atty. Marcus Aurelius" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Specialization</label>
                                    <select class="form-select" name="specialization" required>
                                        <option value="Criminal Law" selected>Criminal Law</option>
                                        <option value="Corporate Law">Corporate Law</option>
                                        <option value="Family Law">Family Law</option>
                                        <option value="Real Estate">Real Estate</option>
                                        <option value="IP Law">IP Law</option>
                                        <option value="Labor Law">Labor Law</option>
                                        <option value="Tax Law">Tax Law</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Professional Bio</label>
                                <textarea class="form-control" name="bio" rows="4" required>Marcus Aurelius is a distinguished legal professional with over 15 years of experience in criminal defense and human rights litigation.</textarea>
                                <small class="text-muted">Maximum 500 characters</small>
                            </div>

                            <h6 class="text-white border-bottom border-secondary pb-2 mb-3 mt-2">Contact Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" name="email" value="marcus@law.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="+966 55 123 4567" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">WhatsApp</label>
                                    <input type="text" class="form-control" name="whatsapp" placeholder="+966...">
                                    <small class="text-muted">Optional - for client contact</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">LinkedIn</label>
                                    <input type="url" class="form-control" name="linkedin" value="https://linkedin.com/in/marcus">
                                    <small class="text-muted">Optional - professional profile</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-3">
                                <a href="{{ route('lawyer-profile') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: MY ANSWERS -->
            <div class="col-12">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header border-secondary p-4 bg-transparent">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-comments me-2 text-success"></i>My Answers</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <!-- Answer 1 -->
                            <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('question-details') }}?id=101" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">What are the penalties for cybercrime defamation?</a>
                                     <span class="badge bg-secondary text-info">Criminal Law</span>
                                </div>
                                <small class="text-muted d-block mb-2">Answered on 2026-01-12</small>
                                <p class="text-secondary small mb-3">Under the Anti-Cyber Crime Law, defamation via electronic means involves penalties including imprisonment for up to one year...</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editAnswer('ANS-001')"><i class="fas fa-edit me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Answer', 'ANS-001')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                            <!-- Answer 2 -->
                            <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('question-details') }}?id=102" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">Custody rights for expatriate mothers?</a>
                                     <span class="badge bg-secondary text-warning">Family Law</span>
                                </div>
                                <small class="text-muted d-block mb-2">Answered on 2026-01-10</small>
                                <p class="text-secondary small mb-3">The Personal Status Law 2022 prioritizes the child's best interest. Generally, custody remains with the mother...</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editAnswer('ANS-002')"><i class="fas fa-edit me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Answer', 'ANS-002')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                             <!-- Answer 3 -->
                             <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('question-details') }}?id=103" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">Starting a business without a local sponsor?</a>
                                     <span class="badge bg-secondary text-primary">Corporate Law</span>
                                </div>
                                <small class="text-muted d-block mb-2">Answered on 2026-01-08</small>
                                <p class="text-secondary small mb-3">New regulations allow 100% foreign ownership in many sectors. You likely do not need a sponsor for...</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editAnswer('ANS-003')"><i class="fas fa-edit me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Answer', 'ANS-003')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                            <!-- Answer 4 -->
                            <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('question-details') }}?id=104" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">Termination notice period requirements?</a>
                                     <span class="badge bg-secondary text-danger">Labor Law</span>
                                </div>
                                <small class="text-muted d-block mb-2">Answered on 2026-01-05</small>
                                <p class="text-secondary small mb-3">Assuming an indefinite contract, the notice period must be at least 60 days. For fixed contracts...</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editAnswer('ANS-004')"><i class="fas fa-edit me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Answer', 'ANS-004')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: MY ARTICLES -->
            <div class="col-12">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header border-secondary p-4 bg-transparent">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-newspaper me-2 text-info"></i>My Articles</h4>
                    </div>
                     <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <!-- Article 1 -->
                            <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('article-details') }}?id=201" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">Understanding the New Commercial Courts Law</a>
                                     <span class="badge bg-primary">Corporate</span>
                                </div>
                                <small class="text-muted d-block mb-2">Published on 2026-01-12</small>
                                <p class="text-secondary small mb-3">A deep dive into how the new regulations streamline commercial litigation...</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('edit-article') }}?id=201" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit Article</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Article', 'ART-201')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                             <!-- Article 2 -->
                             <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('article-details') }}?id=202" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">Property Ownership Rules for Non-Saudis</a>
                                     <span class="badge bg-success">Real Estate</span>
                                </div>
                                <small class="text-muted d-block mb-2">Published on 2026-01-08</small>
                                <p class="text-secondary small mb-3">An updated guide on REGA regulations concerning foreign ownership...</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('edit-article') }}?id=202" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit Article</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Article', 'ART-202')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                            <!-- Article 3 -->
                            <div class="list-group-item bg-transparent border-secondary p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                     <a href="{{ route('article-details') }}?id=203" class="fw-bold text-white text-decoration-none hover-primary h5 mb-0">IP Rights for Tech Startups</a>
                                     <span class="badge bg-secondary text-info">IP Law</span>
                                </div>
                                <small class="text-muted d-block mb-2">Published on 2025-12-28</small>
                                <p class="text-secondary small mb-3">Why early trademark registration is crucial for your startup's valuation...</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('edit-article') }}?id=203" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit Article</a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('Article', 'ART-203')"><i class="fas fa-trash me-1"></i>Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Answer Modal -->
    <div class="modal fade" id="editAnswerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Edit Answer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAnswerForm" onsubmit="event.preventDefault(); saveAnswerEdit();">
                         <div class="mb-3">
                             <label class="form-label text-muted small">Answer Text</label>
                             <textarea class="form-control" rows="5" id="answerEditText">Under the Anti-Cyber Crime Law, defamation via electronic means involves penalties including imprisonment for up to one year...</textarea>
                         </div>
                         <div class="d-flex justify-content-end">
                             <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Delete Confirmation Modal -->
     <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-danger">Delete Item?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this <span id="deleteItemType">item</span>? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
      <div id="actionToast" class="toast bg-primary text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" id="toastMessage">
            Demo action performed.
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/ui.js') }}"></script>
    <script>
        const answerModal = new bootstrap.Modal(document.getElementById('editAnswerModal'));
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const toastEl = document.getElementById('actionToast');
        const toast = new bootstrap.Toast(toastEl);

        function showToastMessage(msg) {
            document.getElementById('toastMessage').innerText = "Demo only: " + msg;
            toast.show();
        }

        // Profile Picture Functions
        function previewProfilePic(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    showToastMessage("Image size must be less than 5MB");
                    event.target.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showToastMessage("Please select a valid image file");
                    event.target.value = '';
                    return;
                }

                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                    showToastMessage("Profile picture updated! Click 'Save Changes' to apply.");
                };
                reader.readAsDataURL(file);
            }
        }

        function removeProfilePic() {
            // Reset to default avatar based on name
            const fullName = document.getElementById('fullName').value || 'User';
            const defaultAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(fullName)}&background=0d6efd&color=fff&size=120`;
            document.getElementById('profilePreview').src = defaultAvatar;
            document.getElementById('profilePicInput').value = '';
            // Set hidden field to indicate removal
            document.getElementById('removeProfilePic').value = '1';
            showToastMessage("Profile picture removed. Click 'Save Changes' to apply.");
        }

        // Update avatar when name changes
        document.getElementById('fullName')?.addEventListener('blur', function() {
            const currentSrc = document.getElementById('profilePreview').src;
            // Only update if using default avatar (contains ui-avatars.com)
            if (currentSrc.includes('ui-avatars.com')) {
                const fullName = this.value || 'User';
                document.getElementById('profilePreview').src = 
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(fullName)}&background=0d6efd&color=fff&size=120`;
            }
        });

        // Reset remove flag when new file is selected
        document.getElementById('profilePicInput')?.addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('removeProfilePic').value = '0';
            }
        });

        // Handle Profile Form Submission
        function handleProfileSubmit(event) {
            event.preventDefault();
            
            // DEMO MODE: Show success message
            // BACKEND: Remove this block and let form submit naturally
            showToastMessage("Profile saved successfully!");
            
            // In production, uncomment this to submit the form:
            // event.target.submit();
            
            // Or use AJAX for better UX:
            /*
            const formData = new FormData(event.target);
            fetch(event.target.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToastMessage("Profile updated successfully!");
                    // Optionally redirect
                    // window.location.href = "{{ route('lawyer-profile') }}";
                } else {
                    showToastMessage("Error: " + (data.message || "Failed to update profile"));
                }
            })
            .catch(error => {
                showToastMessage("Error: " + error.message);
            });
            */
            
            return false; // Prevent default submission in demo mode
        }

        // Answer Edit
        function editAnswer(id) {
            // In real app, fetch answer detail. Here just open modal.
            answerModal.show();
        }
        function saveAnswerEdit() {
            answerModal.hide();
            showToastMessage("Answer update saved locally.");
        }

        // Deletion
        let itemTypeToDelete = '';
        function deleteItem(type, id) {
            itemTypeToDelete = type;
            document.getElementById('deleteItemType').innerText = type;
            deleteModal.show();
        }
        function confirmDelete() {
            deleteModal.hide();
            showToastMessage(`${itemTypeToDelete} deleted successfully.`);
        }
    </script>
@endsection
