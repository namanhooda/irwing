@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl mt-4">
    <h4>Edit Vacancy</h4>

    <form action="{{ route('admin.vacancies.update', $vacancy->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $vacancy->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>File</label><br>
            @if($vacancy->file)
                <a href="{{ asset('storage/'.$vacancy->file) }}" target="_blank">View Current File</a><br><br>
            @endif
            <input type="file" name="file" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" value="{{ $vacancy->date }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Type</label>
    <select name="type" id="type" class="form-select" required>
        <option value="">Select Type</option>
        @foreach($omTypes as $type)
            <option value="{{ $type->id }}" {{ $vacancy->om_type_id == $type->id ? 'selected' : '' }}>
                {{ $type->name }}
            </option>
        @endforeach
    </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ $vacancy->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$vacancy->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
