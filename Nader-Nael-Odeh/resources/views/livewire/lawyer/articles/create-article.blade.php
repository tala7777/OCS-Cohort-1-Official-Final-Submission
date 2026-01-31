<div>
  <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><i class="fas fa-pen me-2 text-primary"></i>Write New Article</h5>
                    </div>
                    <div class="card-body">
                        <!-- Article Form -->
                        <!-- BACKEND: POST /lawyer/articles -->
                        <form id="articleForm" wire:submit.prevent>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Article Title</label>
                                <input type="text" class="form-control" name="title" wire:model="title" placeholder="e.g., Understanding Corporate Governance in UAE" required>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Category</label>
                                <select class="form-select" name="category" wire:model="category_id" required>
                                    <option value="">Select a category...</option>
                                   @foreach ($categories as $category)
                                   <option value="{{ $category->id }}">{{ $category->name }}</option>
                                   @endforeach
                                   @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Article Content</label>
                                <textarea class="form-control" name="content" wire:model="content" rows="15" placeholder="Write your article here..." required></textarea>
                                <small class="text-muted">You can use markdown formatting</small>
                                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                           

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" wire:click="publishArticle">
                                    <i class="fas fa-paper-plane me-2"></i>Publish Article
                                </button>
                                <button type="submit" class="btn btn-outline-secondary" wire:click="saveDraft" wire:loading.attr="disabled">
                                    <i class="fas fa-save me-2"></i>Save Draft
                                </button>
                                <a href="{{ route('lawyer.articles.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div></div>
