@extends('layoutsBackend.app')

@section('content')
<div class="card">
    <div class="card-header"><h4>Edit ITU Focal Point</h4></div>

    <div class="card-body">
        <form action="{{ route('admin.itu_focal_points.update', $item->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Country</label>
                <select name="country_id" class="form-select">
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}" {{ $item->country_id == $c->id ? 'selected':'' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="{{ $item->city }}">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ $item->address }}">
            </div>

            <div class="mb-3">
                <label>Focal Points</label>
                <input type="text" name="focal_points" class="form-control" value="{{ $item->focal_points }}">
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
