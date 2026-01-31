@extends('layouts.public')

@section('title', 'Legal Q&A - Ask a Question')

@section('content')
    <!-- Main Content -->
    <div class="container page-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card border-secondary shadow-lg">
                    <div class="card-header border-bottom border-secondary bg-transparent text-center py-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3 shadow" style="width: 64px; height: 64px;">
                            <i class="fas fa-question fa-2x"></i>
                        </div>
                        <h2 class="fw-bold mb-1">Ask a Question</h2>
                        <p class="text-muted mb-0">Get verified answers from legal professionals</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="askForm" method="POST" action="{{ route('store-question') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold">Question Title</label>
                                <input type="text" class="form-control form-control-lg" placeholder="E.g., Landlord dispute regarding security deposit" name="title" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Legal Category</label>
                                <select class="form-select form-select-lg" name="category_id" required>
                                    <option value="">Select Category...</option>
                               @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Details</label>   
                                <textarea class="form-control" rows="6" placeholder="Describe your situation in detail. Do not include personal names or sensitive data." name="description" required></textarea>
                            </div>

                          

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Submit Question
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-link text-muted text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel & Return Home
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
    <!-- Scripts handled by layout -->
@endsection
