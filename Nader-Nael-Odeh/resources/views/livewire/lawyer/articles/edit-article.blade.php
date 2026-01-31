<div>
<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-pen-nib me-2 text-primary"></i>Edit Article</h5>
                        <span class="badge bg-warning text-dark">Draft Mode</span>
                    </div>
                    <div class="card-body p-4">
                        <form id="editArticleForm" onsubmit="event.preventDefault(); saveArticle();">
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Article Title</label>
                                <input type="text" class="form-control form-control-lg" name="title" wire:model="title" required>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Category</label>
                                <select class="form-select" name="category" wire:model="categoryId" required>
                                    <option value="{{ $categoryId }}">{{ $categoryName }}</option>
                                  @foreach ($categories as $category)
                                  @if($category->id != $categoryId)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endif
                                  @endforeach
                                </select>
                                @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Content</label>
                                <textarea class="form-control" rows="12" required wire:model="content"></textarea>
                                <small class="text-muted">Markdown formatting supported.</small>
                                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                          

                            <!-- Actions -->
                            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                <a href="{{ route('lawyer.articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success px-4 fw-bold" wire:click="publishArticle">
                                    <i class="fas fa-paper-plane me-2"></i>Publish Article
                                </button>
                                <button type="submit" class="btn btn-outline-secondary px-4 fw-bold" wire:click="saveDraft">
                                    <i class="fas fa-save me-2"></i>Save Draft
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div></div>
