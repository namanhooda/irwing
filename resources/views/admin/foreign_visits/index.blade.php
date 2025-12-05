@extends('layoutsBackend.app')

@section('content')

<div class="container mt-4">

    <h3>Year-wise Foreign Visits Report</h3>

    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <select name="year" class="form-select" onchange="this.form.submit()">
                <option value="">Select Year</option>
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <a href="{{ route('foreign.visits.export', ['year' => $year]) }}"
               class="btn btn-success">Download Excel</a>
        </div>
    </form>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Meeting Name</th>
                        <th>Purpose</th>
                        <th>Title</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>From Date</th>
                        <th>To Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr>
                        <td>{{ $row->meeting_name }}</td>
                        <td>{{ $row->purpose }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->date_of_birth }}</td>
                        <td>{{ ucfirst($row->gender) }}</td>
                        <td>{{ $row->country }}</td>
                        <td>{{ $row->city }}</td>
                        <td>{{ $row->from_date }}</td>
                        <td>{{ $row->to_date }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No records found for {{ $year }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
