@extends('layoutsBackend.app')

@section('content')
<div class="card">
    <div class="card-header"><h4>Add ITU Focal Point</h4></div>

    <div class="card-body">
        <form action="{{ route('admin.itu_focal_points.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Country</label>
                <select name="country_id" class="form-select">
                    <option value="">Select Country</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control">
            </div>

            <div class="mb-3">
                <label>Focal Points</label>
                <input type="text" name="focal_points" class="form-control">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
