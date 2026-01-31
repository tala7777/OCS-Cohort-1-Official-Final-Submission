<div>
 <div class="card mb-4 shadow-sm">
        <div class="card-header py-3">
            <h5 class="mb-0">Question: <span class="text-primary">{{$question->title}}</span></h5>
        </div>
        <div class="card-body">
            <p class="text-secondary lead fs-6">{{$question->description}}</p>
            <div class="text-muted small border-top pt-3 mt-3">
                <span class="badge bg-info me-2">{{$question->category->name}}</span>
                <i class="fas fa-user me-1"></i> Asked by {{$question->owner->name}} • <i class="fas fa-clock me-1 ms-2"></i> {{$question->created_at->diffForHumans()}}
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h5 class="mb-0"><i class="fas fa-edit me-2 text-primary"></i>Edit Your Answer</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="mb-4">
                    <label class="form-label fw-bold">Your Professional Advice</label>
                    <textarea class="form-control" rows="10" placeholder="Type your answer here..." wire:model="answer"></textarea>
                    <small class="text-muted">Provide detailed, professional legal advice citing relevant laws where possible.</small>
                </div>
                
                <div class="alert bg-transparent text-info border border-info border-start-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Professional Tip:</strong> Update your answer with new information or corrections as needed.
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('lawyer.answers.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-save me-2"></i>Update Answer
                    </button>
                </div>
            </form>
        </div>
    </div></div>
