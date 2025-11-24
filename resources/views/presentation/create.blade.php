@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Create Presentation</h2>
    <form action="{{ route('presentations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
            <div class="col-md-6 mb-3">
                <label>Tour ID</label>
                <select name="tour_id" id="meeting_id" class="form-select" required>
                    <option value="" disabled {{ request('meeting_id') ? '' : 'selected' }}>Select Meeting</option>
                    @foreach($qrps as $qrp)
                        <option value="{{ $qrp->id }}" {{ request('meeting_id') == $qrp->id ? 'selected' : '' }}>
                            {{ $qrp->meeting_name }}
                        </option>
                    @endforeach
                </select>
            </div>

        <div class="mb-3">
            <label for="staff_number" class="form-label">Staff Number</label>
            <input type="text" class="form-control" id="staff_number" name="staff_number" value="{{ $profile->staff_no }}">
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
