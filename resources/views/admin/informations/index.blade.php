@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Information List</h4>
        <a href="{{ route('admin.informations.create') }}" class="btn btn-primary">Add Information</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>File</th>
                <th>URL</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($informations as $info)
            <tr>
                <td>{{ $info->title }}</td>
                <td>
                    @if($info->file)
                        <a href="{{ asset('uploads/informations/' . $info->file) }}" target="_blank">View PDF</a>
                    @else
                        —
                    @endif
                </td>
                <td>
                    @if($info->url)
                        <a href="{{ $info->url }}" target="_blank">{{ $info->url }}</a>
                    @else
                        —
                    @endif
                </td>
                <td>{{ $info->description }}</td>
                <td>
                    <a href="{{ route('admin.informations.edit', $info->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.informations.destroy', $info->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No records found.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $informations->links() }}
</div>
@endsection
