@extends('layoutsBackend.app')
@section('content')



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Achievements</span>
            <a href="{{ route('admin.missions.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">+ Add </span>
            </a>

        </h5>
        <div class="card-datatable table-responsive">
            <div class="table-responsive">
                <a href="{{ route('admin.missions.export') }}" class="btn btn-success mb-3">
    Download Excel
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Country</th>
            <th>India Offerings</th>
            <th>Country Asks</th>
            <th>Status</th>
            <th>Last Meeting</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($missions as $m)
        <tr>
            <td>{{ $m->country->name }}</td>
            <td>{{ $m->india_key_offerings }}</td>
            <td>{{ $m->country_asks }}</td>
            <td>{{ $m->engagement_status ?? 'N/A'}}</td>
            <td>{{ $m->last_meeting_date  ?? 'N/A'}}</td>

            <td>
                <a href="{{ route('admin.missions.edit', $m->id) }}" class="btn btn-sm btn-primary">Edit</a>

                <form action="{{ route('admin.missions.delete', $m->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $missions->links() }}

            </div>
        </div>
        <!-- Offcanvas to add new user -->

    </div>
</div>
@endsection
