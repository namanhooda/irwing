@extends('layoutsBackend.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Tour Reports</span>

            @php
            $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
            
            @endphp
            @if($activeRole == 'admin')
            @else
            <a href="{{ route('tour-reports.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New Details</span>
            </a>
            @endif
        </h5>

        <div class="card-datatable table-responsive">
            <form action="{{ route('qrps.bulkSubmit') }}" method="POST" id="bulkForm">
                @csrf
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>#</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Meeting Name</th>
                            <th>Purpose</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Tour Report</th>
                            <th>Presentation</th>
                            <th>Key Contributions</th>
                            <th>Follow-up Actions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $index => $qrp)
                            <tr>
                                <td><input type="checkbox" name="qrp_ids[]" value="{{ $qrp->id }}"></td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($qrp->meeting_from)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($qrp->meeting_to)->format('d-m-Y') }}</td>
                                <td>{{ $qrp->meeting_name }}</td>
                                <td>{{ $qrp->purpose ?? 'N/A' }}</td>
                                <td>{{ $qrp->country ?? 'N/A' }}</td>
                                <td>{{ $qrp->city ?? 'N/A' }}</td>
                                <td>
                                    @if($qrp->tour_report_pdf)
                                        <a href="{{ asset('storage/tour_reports/' . $qrp->tour_report_pdf) }}" target="_blank">View PDF</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($qrp->presentation)
                                        <a href="{{ asset('storage/presentations/' . $qrp->presentation) }}" target="_blank">View</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $qrp->key_contributions ?? 'N/A' }}</td>
                                <td>{{ $qrp->followup_actions ?? 'N/A' }}</td>
                                <td>
                                        <a href="{{ route('tour-reports.show', $qrp->id) }}" class="btn btn-warning btn-sm">View Details</a>
                                        
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center">No Tour Reports Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Select All Script -->
<script>
    document.getElementById('select-all').addEventListener('change', function (e) {
        let checkboxes = document.querySelectorAll('input[name="qrp_ids[]"]');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    });

    document.getElementById('add-more').addEventListener('click', function () {
        window.location.href = "{{ route('tour-reports.create') }}";
    });
</script>

@endsection
