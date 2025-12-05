@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>MoU Signed With Foreign Countries</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.mou.create') }}" class="btn btn-primary">Add MoU</a>
        <a href="{{ route('admin.mou.export') }}" class="btn btn-success">Download Excel</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Country</th>
                <th>MoU Title</th>
                <th>Signed Date</th>
                <th>Document</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->country->name }}</td>
                <td>{{ $item->mou_title }}</td>
                <td>{{ $item->signed_date }}</td>

                <td>
                    @if ($item->mou_file)
                        <a href="{{ asset($item->mou_file) }}" target="_blank" class="btn btn-sm btn-info">View</a>
                    @else
                        <span class="text-muted">No File</span>
                    @endif
                </td>

                <td>{{ $item->remarks }}</td>

                <td>
                    <a href="{{ route('admin.mou.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('admin.mou.destroy', $item->id) }}" 
                          method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this MoU?')" class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
