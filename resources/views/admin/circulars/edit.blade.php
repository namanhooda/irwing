@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Edit Circular</h2>

    <form action="{{ route('admin.circulars.update', $circular->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" value="{{ old('title', $circular->title) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $circular->description) }}</textarea>
        </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File (PDF)</label>
                        <input type="file" name="file" class="form-control" id="file" accept="application/pdf">
                        @if($circular->file)
                            <p class="mt-2">
                                Current file: 
                                <a href="{{ asset($circular->file) }}" target="_blank">View</a>
                            </p>
                        @endif
                    </div>

        <div class="mb-3">
            <label class="form-label">URL</label>
            <input type="url" name="url" value="{{ old('url', $circular->url) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select">
                <option value="Active" {{ $circular->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $circular->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.circulars.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
