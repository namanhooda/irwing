@extends('layoutsBackend.app')
@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
       
        @roleCan('submission.personal_performa.view')
        <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-4">Personal Performa Details</h4>

<div class="card-body">

                <table class="table table-bordered">
                    <tr><th>Title</th><td>{{ $personalPerforma->title }}</td></tr>
                    <tr><th>Service</th><td>{{ $personalPerforma->service }} 
                        @if($personalPerforma->service == 'other') ({{ $personalPerforma->service_other }}) @endif
                    </td></tr>
                    <tr><th>Staff No.</th><td>{{ $personalPerforma->staff_no }}</td></tr>
                    <tr><th>Name of Officer</th><td>{{ $personalPerforma->user->name ?? '-' }}</td></tr>
                    <tr><th>Designation</th><td>{{ $personalPerforma->designation }}</td></tr>
                    <tr><th>Posting</th><td>{{ $personalPerforma->posting }}</td></tr>
                    <tr><th>Date of Birth</th><td>{{ $personalPerforma->dob }}</td></tr>
                    <tr><th>Annual Property Return</th><td>{{ $personalPerforma->property_return_date }}</td></tr>
                    <tr><th>Pay Level</th><td>{{ $personalPerforma->pay_level }}</td></tr>
                    <tr><th>Mobile</th><td>{{ $personalPerforma->mobile }}</td></tr>
                    <tr><th>Email</th><td>{{ $personalPerforma->email }}</td></tr>
                    <tr><th>Aadhaar</th><td>{{ $personalPerforma->aadhaar }}</td></tr>
                    <tr><th>PAN</th><td>{{ $personalPerforma->pan }}</td></tr>
                    <tr>
                        <th>Tour Report</th>
                        <td>
                            @if($personalPerforma->tour_report)
                                <a href="{{ asset('storage/'.$personalPerforma->tour_report) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr><th>Superannuation</th><td>{{ $personalPerforma->superannuation }}</td></tr>
                    <tr><th>Event Brief</th><td>{{ $personalPerforma->event_brief }}</td></tr>
                    <tr><th>Justification</th><td>{{ $personalPerforma->justification }}</td></tr>
                    <tr>
                        <th>Justification File</th>
                        <td>
                            @if($personalPerforma->justification_file)
                                <a href="{{ asset('storage/'.$personalPerforma->justification_file) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr><th>Expected Outcomes</th><td>{{ $personalPerforma->expected_outcomes }}</td></tr>
                    <tr><th>Is ITU Meeting</th><td>{{ $personalPerforma->is_itu }}</td></tr>
                </table>

                @if($personalPerforma->is_itu == "Yes")
                <h5 class="mt-4">ITU Meeting Details</h5>
                <table class="table table-bordered">
                    <tr><th>Current ITU Roles</th><td>{{ $personalPerforma->itu_current_roles }}</td></tr>
                    <tr><th>Rapporteur Questions</th><td>{{ $personalPerforma->itu_questions_rapporteur }}</td></tr>
                    <tr><th>Associate Rapporteur Questions</th><td>{{ $personalPerforma->itu_questions_associate }}</td></tr>
                    <tr><th>Editor Items</th><td>{{ $personalPerforma->itu_editor_items }}</td></tr>
                    <tr><th>Previous ITU Roles</th><td>{{ $personalPerforma->itu_previous_roles }}</td></tr>
                    <tr><th>Work Items since 2022</th><td>{{ $personalPerforma->itu_work_items }}</td></tr>
                    <tr><th>Proposed</th><td>{{ $personalPerforma->itu_proposed }}</td></tr>
                    <tr><th>Consented</th><td>{{ $personalPerforma->itu_consented }}</td></tr>
                    <tr><th>In Progress</th><td>{{ $personalPerforma->itu_in_progress }}</td></tr>
                    <tr><th>Recommendations Published</th><td>{{ $personalPerforma->itu_recommendations }}</td></tr>
                    <tr><th>Reports Published</th><td>{{ $personalPerforma->itu_reports }}</td></tr>
                    <tr><th>Online Meetings</th><td>{{ $personalPerforma->itu_online_meetings }}</td></tr>
                    <tr><th>Physical Meetings</th><td>{{ $personalPerforma->itu_physical_meetings }}</td></tr>
                </table>
                @endif

                <h5 class="mt-4">Foreign Visits</h5>
                @php $visits = json_decode($personalPerforma->visits, true); @endphp
                @if(!empty($visits))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Meeting</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Country</th>
                                <th>City</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visits as $visit)
                                <tr>
                                    <td>{{ $visit['meeting'] ?? '-' }}</td>
                                    <td>{{ $visit['from'] ?? '-' }}</td>
                                    <td>{{ $visit['to'] ?? '-' }}</td>
                                    <td>{{ $visit['country'] ?? '-' }}</td>
                                    <td>{{ $visit['city'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No foreign visits recorded.</p>
                @endif

                <a href="{{ route('personal-performa.index') }}" class="btn btn-secondary mt-3">Back</a>
            </div>

    <a href="{{ route('qrp.download', $personalPerforma->id) }}" class="btn btn-success">Download Excel</a>
</div>
        @endroleCan
        <!-- Offcanvas to add new user -->

    </div>
</div>
@endsection
