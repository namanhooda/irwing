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

               <form action="{{ route('achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Achievement</label>
            <input type="text" name="achievement" class="form-control" value="{{ $achievement->achievement }}" required>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ $achievement->date }}" required>
        </div>

        <div class="mb-3">
            <label>Details</label>
            <textarea name="details" class="form-control">{{ $achievement->details }}</textarea>
        </div>

        <div class="mb-3">
            <label>Document</label>
            @if($achievement->document)
                <p><a href="{{ asset('storage/'.$achievement->document) }}" target="_blank">View existing file</a></p>
            @endif
            <input type="file" name="document" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('achievements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
            </div>
        </div>
    </div>
</div>
@endsection
