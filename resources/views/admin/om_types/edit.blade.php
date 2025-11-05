@extends('layoutsBackend.app')

@section('content')
<div class="container mt-4">
    <h4>Edit OM Type</h4>
    <form action="{{ route('admin.om_types.update', $omType->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $omType->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ $omType->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$omType->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.om_types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
