@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Presentation</h2>
    <form action="{{ route('presentations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="tour_id" class="form-label">Tour ID</label>
            <input type="text" class="form-control" id="tour_id" name="tour_id" value="{{ old('tour_id') }}">
        </div>
        <div class="mb-3">
            <label for="staff_number" class="form-label">Staff Number</label>
            <input type="text" class="form-control" id="staff_number" name="staff_number" value="{{ old('staff_number') }}">
        </div>
        <div class="mb-3">
            <label for="brief" class="form-label">Brief</label>
            <input type="text" class="form-control" id="brief" name="brief" value="{{ old('brief') }}">
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">File</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
