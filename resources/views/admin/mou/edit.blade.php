@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>Edit MoU</h2>

    <form action="{{ route('admin.mou.update', $record->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Country</label>
            <select name="country_id" class="form-control" required>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ $record->country_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>MoU Title</label>
            <input type="text" name="mou_title" value="{{ $record->mou_title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Signed Date</label>
            <input type="date" name="signed_date" value="{{ $record->signed_date }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Upload New MoU Document (Optional)</label>
            <input type="file" name="mou_file" class="form-control">

            @if($record->mou_file)
                <p class="mt-2">Current File:
                    <a href="{{ asset($record->mou_file) }}" target="_blank">View</a>
                </p>
            @endif
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control">{{ $record->remarks }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>

    </form>

</div>
@endsection
