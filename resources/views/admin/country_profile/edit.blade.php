@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>Edit Country Profile</h2>

    <form method="POST" action="{{ route('admin.country_profiles.update',$profile->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Country</label>
            <select name="country_id" class="form-control" required>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ $profile->country_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Capital</label>
            <input type="text" name="capital" value="{{ $profile->capital }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Official Language</label>
            <input type="text" name="official_language" value="{{ $profile->official_language }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Currency</label>
            <input type="text" name="currency" value="{{ $profile->currency }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Political Structure</label>
            <textarea name="political_structure" class="form-control">{{ $profile->political_structure }}</textarea>
        </div>

        <div class="mb-3">
            <label>Economic Overview</label>
            <textarea name="economic_overview" class="form-control">{{ $profile->economic_overview }}</textarea>
        </div>

        <div class="mb-3">
            <label>Bilateral Ties</label>
            <textarea name="bilateral_ties" class="form-control">{{ $profile->bilateral_ties }}</textarea>
        </div>

        <div class="mb-3">
            <label>Flag Image</label>
            <input type="file" name="flag_image" class="form-control">

            @if($profile->flag_image)
                <img src="{{ asset($profile->flag_image) }}" width="80" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Profile PDF</label>
            <input type="file" name="profile_document" class="form-control">

            @if($profile->profile_document)
                <p class="mt-2">
                    <a href="{{ asset($profile->profile_document) }}" target="_blank">View PDF</a>
                </p>
            @endif
        </div>

        <button class="btn btn-primary">Update</button>

    </form>

</div>
@endsection
