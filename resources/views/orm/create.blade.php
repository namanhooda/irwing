@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <h5 class="card-header">Create OM</h5>
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

                <form action="{{ route('orm-data.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select Type</option>
                            <option value="SOP/Guideline" {{ old('type') == 'SOP/Guideline' ? 'selected' : '' }}>SOP/Guideline</option>
                            <option value="Information" {{ old('type') == 'Information' ? 'selected' : '' }}>Information</option>
                            <option value="InterDepartmental" {{ old('type') == 'InterDepartmental' ? 'selected' : '' }}>InterDepartmental</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" id="date" value="{{ old('date') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File (PDF)</label>
                        <input type="file" name="file" class="form-control" id="file" accept="application/pdf" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('orm-data.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
