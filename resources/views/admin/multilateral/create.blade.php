@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Add Multilateral Engagement</h2>

    <form action="{{ route('admin.multilateral-engagement.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Country</label>
            <select name="country_id" class="form-control" required>
                <option value="">Select Country</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->country_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Engagement</label>
            <textarea name="engagement" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Key Offerings</label>
            <textarea name="key_offerings" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Key Asks</label>
            <textarea name="key_asks" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Save</button>

    </form>
</div>
@endsection
