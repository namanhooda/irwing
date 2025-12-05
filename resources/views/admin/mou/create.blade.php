@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>Add New MoU</h2>

    <form action="{{ route('admin.mou.store') }}" method="POST" enctype="multipart/form-data">
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
            <label>MoU Title</label>
            <input type="text" name="mou_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Signed Date</label>
            <input type="date" name="signed_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Upload MoU Document (PDF/DOC/DOCX)</label>
            <input type="file" name="mou_file" class="form-control">
        </div>

        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Save</button>

    </form>

</div>
@endsection
