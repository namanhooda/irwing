@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>Multilateral Engagements</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.multilateral-engagement.create') }}" class="btn btn-primary">Add New</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Country</th>
                <th>Engagement</th>
                <th>Key Offerings</th>
                <th>Key Asks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->country->country_name }}</td>
                <td>{{ $item->engagement }}</td>
                <td>{{ $item->key_offerings }}</td>
                <td>{{ $item->key_asks }}</td>

                <td>
                    <a href="{{ route('admin.multilateral-engagement.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('admin.multilateral-engagement.destroy', $item->id) }}" 
                          method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">
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
