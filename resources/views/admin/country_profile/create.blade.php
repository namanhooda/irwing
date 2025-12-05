@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>Add Country Profile</h2>

    <form method="POST" action="{{ route('admin.country_profiles.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Country</label>
            <select name="country_id" class="form-control" required>
                <option value="">Select Country</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Capital</label>
            <input type="text" name="capital" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Official Language</label>
            <input type="text" name="official_language" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Currency</label>
            <input type="text" name="currency" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Political Structure</label>
            <textarea name="political_structure" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Economic Overview</label>
            <textarea name="economic_overview" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Bilateral Ties</label>
            <textarea name="bilateral_ties" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Flag Image</label>
            <input type="file" name="flag_image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Profile PDF</label>
            <input type="file" name="profile_document" class="form-control">
        </div>

        <button class="btn btn-primary">Save</button>

    </form>

</div>
@endsection
