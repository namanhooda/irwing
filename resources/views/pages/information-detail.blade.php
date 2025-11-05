@extends('frontend.partials.app')

@section('content')

<style>
    /* --- Reuse the forum-container styling for consistency --- */
    .info-container {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .info-header {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        padding: 25px 30px;
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin: 0;
    }

    .info-content {
        padding: 30px;
    }

    .breadcrumb-container {
        background: #f8f9fa;
        padding: 15px 30px;
        border-bottom: 1px solid #dee2e6;
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

    /* --- Info Details Styling --- */
    .info-description {
        color: #495057;
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .info-meta {
        margin-top: 25px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        border-left: 5px solid #4a90e2;
    }

    .info-meta a {
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .info-meta a:hover {
        text-decoration: underline;
        color: #357abd;
    }

    .file-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #4a90e2;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .file-link:hover {
        background: #357abd;
        text-decoration: none;
    }

    .file-link i {
        font-size: 1.2rem;
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
    <div class="info-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('informations') }}">Information</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $information->title }}</li>
                </ol>
            </nav>
        </div>

        <!-- Header -->
        <h1 class="info-header">{{ $information->title }}</h1>

        <!-- Content -->
        <div class="info-content">
            @if($information->description)
                <div class="info-description">
                    {!! $information->description !!}
                </div>
            @else
                <p class="no-content">No description available.</p>
            @endif

            <div class="info-meta">
                @if($information->file)
                    <p>
                        <a href="{{ asset('uploads/informations/' . $information->file) }}" target="_blank" class="file-link">
                            <i class="fas fa-file-pdf"></i> View PDF File
                        </a>
                    </p>
                    @else
                    <p>External Link:
                        <a href="{{ $information->url }}" target="_blank">{{ $information->url }}</a>
                    </p>

                @endif

                <p><strong>Published on:</strong> {{ $information->created_at->format('d M, Y') }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
