@extends('frontend.partials.app')

@section('content')

<style>
    /* --- Shared Styling from Information Page --- */
    .info-container {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .info-header {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        padding: 20px;
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        margin: 0;
        border-radius: 15px 15px 0 0;
    }

    .info-content {
        padding: 25px;
    }

    .breadcrumb-container {
        background: #f8f9fa;
        padding: 15px 30px;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 30px;
    }

    .breadcrumb {
        margin: 0;
        background: transparent;
        font-size: 0.9rem;
    }

    .breadcrumb-item a {
        color: #4a90e2;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    .info-description {
        color: #495057;
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 15px;
        text-align: justify;
    }

    .file-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #4a90e2;
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s ease;
        font-size: 0.95rem;
    }

    .file-link:hover {
        background: #357abd;
        text-decoration: none;
    }

    .file-link i {
        font-size: 1.1rem;
    }

    .no-content {
        color: #6c757d;
        font-style: italic;
        text-align: center;
        margin-top: 20px;
    }
</style>

<div class="mb-3 mb-lg-5"></div>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Front Pages</li>
            </ol>
        </nav>
    </div>

    <!-- Front Pages List -->
            <div class="info-container">
                <h2 class="info-header">{{ $frontPages->title }}</h2>
                <div class="info-content">
                    @if($frontPages->description)
                        <div class="info-description">
                            {!! $frontPages->description !!}
                        </div>
                    @else
                        <p class="no-content">No description available.</p>
                    @endif

                    @if($frontPages->file)
                        <a href="{{ asset('storage/' . $frontPages->file) }}" target="_blank" class="file-link">
                            <i class="fas fa-file-pdf"></i> View PDF File
                        </a>
                    @elseif($frontPages->url)
                        <a href="{{ $frontPages->url }}" target="_blank" class="file-link">
                            <i class="fas fa-link"></i> Visit Link
                        </a>
                    @endif

                    <div class="mt-3 text-muted small">
                        <strong>Published on:</strong> {{ $frontPages->created_at->format('d M, Y') }}
                    </div>
                </div>
            </div>
</div>

@endsection
