@extends('layoutsBackend.app')

@section('content')

<div class="container mt-4">
<h3>Bilateral Engagements</h3>
        <a href="{{ route('admin.bilateral-engagement.export') }}" class="btn btn-success">Download Excel</a>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Country</th>
            <th>Title</th>
            <th>Status</th>
            <th>Meeting Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($engagements as $e)
        <tr>
            <td>{{ $e->country->name }}</td>
            <td>{{ $e->engagement_title }}</td>
            <td>{{ $e->status }}</td>
            <td>{{ $e->meeting_date }}</td>

           
        </tr>
        @endforeach
    </tbody>
</table>


{{ $engagements->links() }}
</div>
@endsection
