@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <h4 class="card-header">Tour Report Details</h4>

        <div class="card-body">

            <h5 class="mb-3">Basic Information</h5>

            <table class="table table-bordered">
                <tr>
                    <th>Tour ID</th>
                    <td>{{ $tourReport->tour_id }}</td>
                </tr>
                <tr>
                    <th>Meeting Name</th>
                    <td>{{ $tourReport->meeting_name }}</td>
                </tr>
                <tr>
                    <th>Purpose</th>
                    <td>{{ $tourReport->purpose }}</td>
                </tr>
                <tr>
                    <th>From Date</th>
                    <td>{{ $tourReport->from_date }}</td>
                </tr>
                <tr>
                    <th>To Date</th>
                    <td>{{ $tourReport->to_date }}</td>
                </tr>
                <tr>
                    <th>Staff Number</th>
                    <td>{{ $tourReport->staff_number }}</td>
                </tr>
                <tr>
                    <th>Name & Designation</th>
                    <td>{{ $tourReport->name_designation }}</td>
                </tr>
            </table>


            <h5 class="mt-4">Key Contributions</h5>
            <p>{{ $tourReport->key_contributions }}</p>

            <h5 class="mt-4">Follow-up Action Points</h5>
            <p>{{ $tourReport->follow_up_action_points }}</p>

            @if ($tourReport->tour_report_pdf)
            <h5 class="mt-4">Uploaded Report</h5>
            <a href="{{ asset('storage/' . $tourReport->tour_report_pdf) }}" 
               target="_blank" class="btn btn-sm btn-primary">
                View PDF
            </a>
            @endif


            <h4 class="mt-5">Questionnaire & Answers</h4>

            @foreach ($answers as $item)
                <div class="mb-3">
                    <strong>Q: {{ $item->question->name }}</strong>
                    <p>A: {{ $item->answer }}</p>
                    <hr>
                </div>
            @endforeach

        </div>
    </div>

</div>
@endsection
