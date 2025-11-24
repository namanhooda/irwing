@extends('layoutsBackend.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>ITU Focal Points</h4>
        <a href="{{ route('admin.itu_focal_points.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Focal Points</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $row)
                <tr>
                    <td>{{ $row->country->name ?? '-' }}</td>
                    <td>{{ $row->city }}</td>
                    <td>{{ $row->address }}</td>
                    <td>{{ $row->focal_points }}</td>

                    <td>
                        <a href="{{ route('admin.itu_focal_points.edit', $row->id) }}" class="btn btn-sm btn-info">Edit</a>

                        <form action="{{ route('admin.itu_focal_points.destroy', $row->id) }}"
                              method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $data->links() }}
    </div>
</div>
@endsection
