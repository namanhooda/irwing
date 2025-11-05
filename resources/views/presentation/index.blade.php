@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Presentations</h2>
    <a href="{{ route('presentation.create') }}" class="btn btn-success mb-3">Add New</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tour ID</th>
                <th>User</th>
                <th>Staff Number</th>
                <th>Brief</th>
                <th>File</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presentations as $presentation)
                <tr>
                    <td>{{ $presentation->id }}</td>
                    <td>{{ $presentation->tour_id }}</td>
                    <td>{{ $presentation->user->name }}</td>
                    <td>{{ $presentation->staff_number }}</td>
                    <td>{{ $presentation->brief }}</td>
                    <td>
                        @if($presentation->file)
                            <a href="{{ asset('storage/'.$presentation->file) }}" target="_blank">View File</a>
                        @endif
                    </td>
                    <td>{{ $presentation->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
