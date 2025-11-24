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
<div class="p-3 border-bottom bg-light">
    <form method="GET" action="{{ route('sanctionMemos.index') }}">
        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Meeting Name</label>
                <input type="text" name="meeting_name" class="form-control"
                       value="{{ request('meeting_name') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Staff Number</label>
                <input type="text" name="staff_number" class="form-control"
                       value="{{ request('staff_number') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control"
                       value="{{ request('country') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control"
                       value="{{ request('from_date') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control"
                       value="{{ request('to_date') }}">
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-primary w-100">Search</button>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <a href="{{ route('sanctionMemos.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>
</div>

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
@php $row = 1; @endphp

@forelse($reports as $meetingName => $group)
    
    {{-- Optional: Meeting Name Header Row --}}
    <tr style="background:#f0f0f0; font-weight:bold;">
        <td colspan="18">{{ $meetingName }}</td>
        <td colspan="18">Dwonload Sanction Memo</td>
    </tr>

    @foreach($group as $report)
        <tr>
            <td>{{ $row++ }}</td>
            <td>{{ $report->tour_id }}</td>
            <td>{{ $report->staff_number }}</td>
            <td>{{ $report->meeting_name }}</td>
            <td>{{ $report->purpose }}</td>
            <td>{{ $report->service }}</td>
            <td>{{ $report->name }}</td>
            <td>{{ $report->date_of_birth }}</td>
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
    @endforeach

@empty
    <tr>
        <td colspan="18" class="text-center">No Tour Reports Found</td>
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
