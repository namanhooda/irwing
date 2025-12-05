@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <h5 class="card-header">Add Achievement</h5>
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
                <form action="{{ route('admin.missions.store') }}" method="POST">
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
        <label>India Key Offerings</label>
        <textarea name="india_key_offerings" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Country Asks</label>
        <textarea name="country_asks" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Save</button>
</form>


            </div>
        </div>
    </div>
</div>
@endsection
