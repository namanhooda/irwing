@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl mt-4">
    <h4>Add Vacancy</h4>

    <form action="{{ route('admin.vacancies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>File (PDF/Image)</label>
            <input type="file" name="file" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">Select Type</option>
                @foreach($omTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
