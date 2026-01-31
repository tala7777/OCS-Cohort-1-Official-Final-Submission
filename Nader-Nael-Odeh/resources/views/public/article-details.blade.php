<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $article->title }} - LegalQ&A</title>
    @include('partials.head')
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
</head>
<body class="bg-dark text-light">

    @include('partials.public-navbar')

    <div class="container py-5 mt-5">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('blog') }}" class="text-warning text-decoration-none">Insights</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $article->category->name ?? 'Article' }}</li>
                    </ol>
                </nav>

                <h1 class="display-4 fw-bold mb-4">{{ $article->title }}</h1>

                <div class="d-flex align-items-center mb-5">
                    <img src="https://ui-avatars.com/api/?name={{ $article->author->name }}&background=fbbf24&color=000" class="rounded-circle me-3" width="50">
                    <div>
                        <p class="mb-0 fw-bold">Atty. {{ $article->author->name }}</p>
                        <small class="text-muted">{{ $article->created_at->format('M d, Y') }} &bull; {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read</small>
                    </div>
                </div>

                @if($article->image_path)
                <img src="{{ $article->image_path }}" class="img-fluid rounded-4 mb-5 shadow w-100" alt="Featured Image" style="max-height: 600px; object-fit: cover;">
                @endif

                <div class="article-content lead text-muted" style="line-height: 1.8;">
                   {!! $article->content !!}
                </div>

                <hr class="border-secondary my-5">

                <div class="p-4 bg-primary-navy rounded-4 d-md-flex align-items-center">
                    <div class="flex-shrink-0 me-md-4 mb-3 mb-md-0 text-center">
                        <img src="https://ui-avatars.com/api/?name={{ $article->author->name }}&background=fbbf24&color=000" class="rounded-circle border border-warning p-1" width="100">
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">About {{ $article->author->name }}</h5>
                        <p class="small text-muted mb-3">{{ $article->author->lawyerProfile->bio ?? 'Verified Lawyer on LegalQ&A.' }}</p>
                        <a href="{{ route('lawyer-profile', $article->author->id) }}" class="btn btn-sm btn-gold rounded-pill px-4 fw-bold">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
