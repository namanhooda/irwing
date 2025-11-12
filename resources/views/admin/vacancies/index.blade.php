@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Vacancies</h4>
        <a href="{{ route('admin.vacancies.create') }}" class="btn btn-primary">Add Vacancy</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>File</th>
                <th>Date</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vacancies as $vacancy)
                <tr>
                    <td>{{ $vacancy->title }}</td>
                    <td>
                        @if($vacancy->file)
                            <a href="{{ asset('storage/'.$vacancy->file) }}" target="_blank">View File</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $vacancy->date }}</td>
                    <td>{{ $vacancy->omType->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $vacancy->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $vacancy->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.vacancies.edit', $vacancy->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.vacancies.destroy', $vacancy->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this vacancy?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
