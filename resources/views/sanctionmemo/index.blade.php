@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Sanction Memos</span>
            @php
                $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
            @endphp
            @if($activeRole !== 'admin')
                <a href="{{ route('tour-reports.create') }}" class="add-new btn btn-primary">
                    <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                    <span class="d-none d-sm-inline-block">Add New Details</span>
                </a>
            @endif
        </h5>

        <div class="card-datatable table-responsive" style="overflow-x:auto;">
            <form action="{{ route('qrps.bulkSubmit') }}" method="POST" id="bulkForm">
                @csrf
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tour ID</th>
                            <th>Staff Number</th>
                            <th>Meeting Name</th>
                            <th>Purpose</th>
                            <th>Service</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Designation</th>
                            <th>Grade</th>
                            <th>Level</th>
                            <th>Mobile No</th>
                            <th>Email</th>
                            <th>Equivalent Rank</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>From Date</th>
                            <th>To Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($reports as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $report->tour_id }}</td>
                                <td>{{ $report->staff_number }}</td>
                                <td>{{ $report->meeting_name }}</td>
                                <td>{{ $report->purpose }}</td>
                                <td>{{ $report->service }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->date_of_birth }}</td>
                                <td>{{ $report->gender }}</td>
                                <td>{{ $report->designation }}</td>
                                <td>{{ $report->grade }}</td>
                                <td>{{ $report->level }}</td>
                                <td>{{ $report->mobile_no }}</td>
                                <td>{{ $report->email }}</td>
                                <td>{{ $report->equivalent_rank }}</td>
                                <td>{{ $report->country }}</td>
                                <td>{{ $report->city }}</td>
                                <td>{{ $report->from_date ? \Carbon\Carbon::parse($report->from_date)->format('d-m-Y') : '' }}</td>
                                <td>{{ $report->to_date ? \Carbon\Carbon::parse($report->to_date)->format('d-m-Y') : '' }}</td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="40" class="text-center">No Tour Reports Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('select-all').addEventListener('change', function (e) {
    let checkboxes = document.querySelectorAll('input[name="qrp_ids[]"]');
    checkboxes.forEach(cb => cb.checked = e.target.checked);
});
</script>
@endsection
