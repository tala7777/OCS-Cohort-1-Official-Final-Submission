@extends('layouts.lawyer')

@section('title', 'Edit Lawyer Profile - LegalQ&A')
@section('page-title', 'Edit Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
@endsection

@section('content')
    <div class="container py-5" style="margin-top: 60px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
             <h2 class="mb-0 fw-bold">Edit Profile & Content</h2>
             <a href="{{ route('lawyer.dashboard') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
        </div>

        <div class="row g-4">
            <!-- SECTION 1: EDIT PROFILE -->
            <div class="col-12">
                <div class="card border-secondary shadow-sm">
                    <div class="card-body p-0">
                         <livewire:lawyer.edit-profile />
               
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
                    // window.location.href = "{{ route('lawyer.dashboard') }}";
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
