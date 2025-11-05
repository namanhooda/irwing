@extends('layoutsBackend.app')
@section('content')



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Personal Performa Details</span>
            <a href="{{ route('personal-performa.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New Details</span>
            </a>
            

        </h5>
        <form method="GET" action="{{ route('personal-performa-generation.index') }}" class="mb-3" style="padding-left: 30px;">
    <div class="row">
        <div class="col-md-4">
            <input type="text" 
                   name="event_location" 
                   value="{{ request('event_location') }}" 
                   class="form-control" 
                   placeholder="Search by Event Location">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('personal-performa.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>
        @can("submission.personal_performa.view")
        <div class="card-datatable table-responsive">
             <div class="table-responsive">
                <table class="table table-bordered">
                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Staff No</th>
                            <th>Event Name</th>
                            <th>Event Location</th>
                            <th>Event From</th>
                            <th>Event To</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($performas as $performa)
                        <tr>
                            <td>{{ $performa->id }}</td>
                            <td>{{ $performa->staff_no }}</td>
                            <td>{{ $performa->event_name }}</td>
                            <td>{{ $performa->event_location }}</td>
                            <td>{{ $performa->event_date_from }}</td>
                            <td>{{ $performa->event_date_to }}</td>
                            <td>{{ $performa->mobile }}</td>
                            <td>{{ $performa->email }}</td>
                        <td>
                            @if(is_null($performa->status) || $performa->status === 'Pending')
                            <span class="badge bg-info">Pending</span>
                            @elseif($performa->status === 'Approved')
                            <span class="badge bg-success">Approved</span>
                            @elseif($performa->status === 'Rejected')
                            <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                            <td>
    <a href="{{ route('personal-performa-generation.show', $performa) }}" class="btn btn-info btn-sm">
        View
    </a>
    <a href="{{ route('personal-performa.download', $performa->id) }}" class="btn btn-success btn-sm">
        Download PDF
    </a>

    @if(is_null($performa->status) || $performa->status === 'Pending')
        <button class="btn btn-success btn-sm" 
                onclick="updateStatus('{{ $performa->id }}', 'Approved')">
            Approve
        </button>

        <button class="btn btn-danger btn-sm" 
                onclick="updateStatus('{{ $performa->id }}', 'Rejected')">
            Reject
        </button>
    @endif
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
        <!-- Offcanvas to add new user -->

    </div>
</div><script>
function updateStatus(id, status) {
    if(!confirm('Are you sure you want to ' + status + ' this performa?')) return;

    fetch(`/personal-performa/update-status/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Performa status updated to ' + status);
            location.reload();
        } else {
            alert('Failed to update status.');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
