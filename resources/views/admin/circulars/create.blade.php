@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Add Circular</h2>

    <form action="{{ route('admin.circulars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File (PDF)</label>
                        <input type="file" name="file" class="form-control" id="file" accept="application/pdf" required>
                    </div>

        <div class="mb-3">
            <label class="form-label">URL</label>
            <input type="url" name="url" value="{{ old('url') }}" class="form-control">
        </div>


        <div class="mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select">
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.circulars.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
