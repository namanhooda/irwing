@extends('layoutsBackend.app')

@section('content')

<div class="container mt-4">

<h3>Add Bilateral Engagement</h3>

<form action="{{ route('admin.bilateral-engagement.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Country</label>
        <select name="country_id" class="form-control" required>
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Engagement Title</label>
        <input type="text" name="engagement_title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Engagement Details</label>
        <textarea name="engagement_details" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Ongoing">Ongoing</option>
            <option value="Completed">Completed</option>
            <option value="Pending">Pending</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Meeting Date</label>
        <input type="date" name="meeting_date" class="form-control">
    </div>

    <button class="btn btn-primary">Save</button>
</form>

</div>
@endsection
