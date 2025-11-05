@extends('layoutsBackend.app')

@section('content')
<div class="container mt-4">
    <h4>Add OM Type</h4>
    <form action="{{ route('admin.om_types.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('admin.om_types.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
