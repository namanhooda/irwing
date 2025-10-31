@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Edit Engagement</h2>

    <form method="POST" action="{{ route('engagements.update', $engagement->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" 
                   value="{{ old('title', $engagement->title) }}" required>
        </div>


        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control text-editor">{{ old('url', $engagement->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            @if ($engagement->image && file_exists(public_path('storage/' . $engagement->image)))
                <img src="{{ asset('storage/' . $engagement->image) }}" 
                     alt="Engagement Image" 
                     class="img-thumbnail mb-2" 
                     width="150">
            @else
                <p>No image uploaded</p>
            @endif
        </div>

        <div class="mb-3">
            <label>Change Image</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Leave blank to keep the current image.</small>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $engagement->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $engagement->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update Engagement</button>
        <a href="{{ route('engagements.index') }}" class="btn btn-secondary">Back</a>
    </form>
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

