@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <h5 class="card-header">Edit ORM</h5>
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

<form action="{{ route('ormupdate.update', ['id' => $orm->id]) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title"
                               value="{{ old('title', $orm->title) }}" required>
                    </div>
                    <div class="mb-3">
    <label for="om_type_id" class="form-label">OM Type <span class="text-danger">*</span></label>
    <select name="type" id="type" class="form-select" required>
        <option value="">Select Type</option>
        @foreach($omTypes as $type)
            <option value="{{ $type->id }}" {{ $orm->om_type_id == $type->id ? 'selected' : '' }}>
                {{ $type->name }}
            </option>
        @endforeach
    </select>
</div>


                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" id="date"
                               value="{{ old('date', $orm->date) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File (PDF)</label>
                        <input type="file" name="file" class="form-control" id="file" accept="application/pdf">
                        @if($orm->file)
                            <p class="mt-2">
                                Current file: 
                                <a href="{{ asset($orm->file) }}" target="_blank">View</a>
                            </p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('orm-data.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
