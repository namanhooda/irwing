@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl">
    <h4>Edit Information</h4>

    <form action="{{ route('admin.informations.update', $information->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $information->title }}" required>
        </div>

        <div class="mb-3">
            <label>File (PDF)</label>
            @if($information->file)
                <p><a href="{{ asset('uploads/informations/' . $information->file) }}" target="_blank">View Current File</a></p>
            @endif
            <input type="file" name="file" accept="application/pdf" class="form-control">
        </div>

        <div class="mb-3">
            <label>URL</label>
            <input type="url" name="url" class="form-control" value="{{ $information->url }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $information->description }}</textarea>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.informations.index') }}" class="btn btn-secondary">Back</a>
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
