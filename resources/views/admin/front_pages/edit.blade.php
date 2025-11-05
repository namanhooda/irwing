@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header"><h5>Edit Page</h5></div>
        <div class="card-body">
            <form action="{{ route('admin.front_pages.update', $front_page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $front_page->title }}" required>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control text-editor" rows="4">{{ $front_page->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label>URL</label>
                    <input type="url" name="url" class="form-control" value="{{ $front_page->url }}">
                </div>

                <div class="mb-3">
                    <label>Upload PDF (optional)</label>
                    <input type="file" name="file" accept="application/pdf" class="form-control">
                    @if($front_page->file)
                        <small>Current: <a href="{{ asset('storage/'.$front_page->file) }}" target="_blank">View PDF</a></small>
                    @endif
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $front_page->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$front_page->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.front_pages.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    $('.text-editor').summernote({
        height: 300,
        placeholder: 'Write description here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']]
        ]
    });
});
</script>
@endpush