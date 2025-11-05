@extends('layoutsBackend.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>OM Types</h4>
        <a href="{{ route('admin.om_types.create') }}" class="btn btn-primary">Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($omTypes as $key => $type)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $type->name }}</td>
                    <td>
                        <span class="badge bg-{{ $type->status ? 'success' : 'danger' }}">
                            {{ $type->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.om_types.edit', $type->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.om_types.destroy', $type->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this record?')" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No data found</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $omTypes->links() }}
</div>
@endsection
