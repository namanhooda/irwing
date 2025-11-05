@extends('layoutsBackend.app')
@section('content')



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>OM's</span>
            <a href="{{ route('orm-data.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New Details</span>
            </a>

        </h5>
        <div class="card-datatable table-responsive">
             <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Pdf</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orm as $performa)
                        <tr>
                            <td>{{ $performa->id }}</td>
                            <td>{{ $performa->omType->name ?? '-' }}</td>
                            <td>{{ $performa->title }}</td>
                            <td><a href="{{ asset($performa->file) }}" target="_blank">Download File</a></td>
                            <td>{{ $performa->date }}</td>
                            
           <td class="text-center">
    <div class="d-flex justify-content-center align-items-center gap-2">
        <a href="{{ route('orm-data.edit', $performa) }}" class="btn btn-warning btn-sm">Edit</a>

        <form action="{{ route('orm-data.destroy', $performa) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Offcanvas to add new user -->

    </div>
</div>
@endsection
