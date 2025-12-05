@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <h5 class="card-header">Edit Promotional Video</h5>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

<form action="{{ route('admin.missions.update', $mission->id) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Country</label>
        <select name="country_id" class="form-control" required>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" 
                    @if($mission->country_id == $country->id) selected @endif>
                    {{ $country->country_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>India Key Offerings</label>
        <textarea name="india_key_offerings" class="form-control">{{ $mission->india_key_offerings }}</textarea>
    </div>

    <div class="mb-3">
        <label>Country Asks</label>
        <textarea name="country_asks" class="form-control">{{ $mission->country_asks }}</textarea>
    </div>

    <button class="btn btn-success">Update</button>
</form>

            </div>
        </div>
    </div>
</div>
@endsection
