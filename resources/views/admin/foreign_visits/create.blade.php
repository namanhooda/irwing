@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Officer-wise Participation Report</h3>

    <form method="GET" action="">
        <div class="row mb-3">

            <div class="col-md-4">
                <select name="officer" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Select Officer --</option>
                    @foreach($officers as $name)
                        <option value="{{ $name }}" {{ $name == $officer ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($officer)
            <div class="col-md-3">
                <a href="{{ route('officer-wise.export', ['officer' => $officer]) }}"
                   class="btn btn-success">
                    Download Excel
                </a>
            </div>
            @endif
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Year</th>
                <th>Meeting Name</th>
                <th>Purpose</th>
                <th>Title</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Country</th>
                <th>City</th>
                <th>From</th>
                <th>To</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->year }}</td>
                <td>{{ $row->meeting_name }}</td>
                <td>{{ $row->purpose }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->date_of_birth }}</td>
                <td>{{ $row->gender }}</td>
                <td>{{ $row->country }}</td>
                <td>{{ $row->city }}</td>
                <td>{{ $row->from_date }}</td>
                <td>{{ $row->to_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
