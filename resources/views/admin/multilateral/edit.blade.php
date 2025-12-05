@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Edit Multilateral Engagement</h2>

    <form action="{{ route('admin.multilateral-engagement.update', $record->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Country</label>
            <select name="country_id" class="form-control" required>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ $record->country_id == $c->id ? 'selected' : '' }}>
                        {{ $c->country_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Engagement</label>
            <textarea name="engagement" class="form-control" required>{{ $record->engagement }}</textarea>
        </div>

        <div class="mb-3">
            <label>Key Offerings</label>
            <textarea name="key_offerings" class="form-control">{{ $record->key_offerings }}</textarea>
        </div>

        <div class="mb-3">
            <label>Key Asks</label>
            <textarea name="key_asks" class="form-control">{{ $record->key_asks }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>

    </form>
</div>
@endsection
