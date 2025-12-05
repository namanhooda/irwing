@extends('layoutsBackend.app')

@section('content')

<div class="container mt-4">
<h3>Edit Bilateral Engagement</h3>

<form action="{{ route('admin.bilateral-engagement.update', $engagement->id) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Country</label>
        <select name="country_id" class="form-control" required>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" 
                    @if($country->id == $engagement->country_id) selected @endif
                >
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Engagement Title</label>
        <input type="text" name="engagement_title" class="form-control" value="{{ $engagement->engagement_title }}" required>
    </div>

    <div class="mb-3">
        <label>Engagement Details</label>
        <textarea name="engagement_details" class="form-control">{{ $engagement->engagement_details }}</textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Ongoing" @if($engagement->status=='Ongoing') selected @endif>Ongoing</option>
            <option value="Completed" @if($engagement->status=='Completed') selected @endif>Completed</option>
            <option value="Pending" @if($engagement->status=='Pending') selected @endif>Pending</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Meeting Date</label>
        <input type="date" name="meeting_date" class="form-control" value="{{ $engagement->meeting_date }}">
    </div>

    <button class="btn btn-success">Update</button>
</form>

</div>
@endsection
