@extends('layoutsBackend.app')
@section('content')



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            @can("generation.qrp.view")

            QRP's

            @endcan
            @roleCan('generation.qrp.create')
           <a href="{{ route('qrp.downloadExcel', request()->query()) }}" class="btn btn-success">
    Download Excel
</a>


            <a href="{{ route('qrp.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New Details</span>
            </a>
            @endroleCan

        </h5>
        @roleCan('generation.qrp.view')
        <div class="card-datatable table-responsive">
            <!-- Filter Form -->
            <form action="{{ route('qrp-generation.index') }}" method="GET" class="row mb-2"
                style="padding-left: 20px;">
                <div class="col-md-3">
                    <label for="quarter" class="form-label">Select Quarter</label>
                    <select name="quarter" id="quarter" class="form-select">
                        <option value="">-- All Quarters --</option>
                        <option value="Quater 1 (Jan-Mar)" {{ request('quarter') == 'Q1' ? 'selected' : '' }}>Quater 1
                            (Oct-Dec)</option>
                        <option value="Quater 2 (Apr-Jun)" {{ request('quarter') == 'Q2' ? 'selected' : '' }}>Quater 2
                            (Apr-Jun)</option>
                        <option value="Quater 3 (Jul-Sep)" {{ request('quarter') == 'Q3' ? 'selected' : '' }}>Quater 3
                            (Jul-Sep)</option>
                        <option value="Quater 4 (Oct-Dec)" {{ request('quarter') == 'Q4' ? 'selected' : '' }}>Quater 4
                            (Oct-Dec)</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="itu" class="form-label">ITU List</label>
                    <select name="itu" id="itu" class="form-select">
                        <option value="">-- All ITU --</option>
                        @foreach($agencies as $agencydata)
                        <option value="{{ $agencydata->id }}" {{ request('itu') == $agencydata->id ? 'selected' : '' }}>
                            {{ $agencydata->name }}
                        </option>
                        @endforeach
                        <!-- add your ITU categories -->
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="nodal" class="form-label">Select Nodal</label>
                    <select name="nodal_id" id="nodal" class="form-select">
                        <option value="">-- Select Nodal --</option>
                        @foreach($nodalUsers as $user)
                        <option value="{{ $user->id }}" {{ request('nodal_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="nodal" class="form-label">Select Status</label>
                    <select name="status" id="nodal" class="form-select">
                        <option value="">-- Select Status --</option>
                        <option value="Pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>
                            Approved
                        </option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>&nbsp;
                    <a href="{{ route('qrp-generation.index') }}" type="submit" class="btn btn-secondary">Reset</a>
                </div>
            </form>
            @if($qrps->count() > 0)
            <form action="{{ route('qrp-generation.bulk-update-status') }}" method="POST" style="padding-left: 20px;">
                @csrf

                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>ID</th>
                            <th>Meeting Name</th>
                            <th>Duration</th>
                            <th>Country</th>
                            <th>Agency</th>
                            <th>Officers</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qrps as $qrp)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_ids[]" value="{{ $qrp->id }}">
                            </td>
                            <td>{{ $qrp->id }}</td>
                            <td>{{ $qrp->meeting_name }}</td>
                            <td>{{ $qrp->meeting_from }} - {{ $qrp->meeting_to }}</td>
                            @php
                            $countries = App\Models\Country::pluck('name', 'id');
                            $countriii = json_decode($qrp->country, true) ?? [];
                            $countryIds = collect($countriii)->pluck('country')->filter()->toArray();
                            $CountryNames = [];
                            foreach ($countryIds as $cid) {
                            if (isset($countries[$cid])) {
                            $CountryNames[] = $countries[$cid];
                            }
                            }
                            $countryStr = implode(', ', $CountryNames);
                            @endphp
                            <td>{{ $countryStr ?? 'N/A' }}</td>
                            <td>{{ $qrp->agencyy->name ?? 'N/A' }}</td>
                            <td>
                                @foreach($qrp->officers as $officers)
                                *{{ $officers->officer_name ?? 'N/A' }}<br>
                                @endforeach
                            </td>
                            <td>
                                @if(is_null($qrp->status) || $qrp->status === 'Pending')
                                <span class="badge bg-info">Pending</span>
                                @elseif($qrp->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                                @elseif($qrp->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('qrp-generation.show', $qrp) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('qrp.edit', $qrp) }}" class="btn btn-warning btn-sm">Edit</a>
                                <!-- <form action="{{ route('qrp.destroy', $qrp) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Bulk status update section -->
                <div class="d-flex mt-3">
                    <select name="status" class="form-select w-auto me-2">
                        <option value="">-- Select Status --</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
            @else
            <div class="alert alert-info" style="    margin-left: 20px;margin-right: 20px;">
                No Pending QRPs found.
            </div>
            @endif
        </div>
        @endroleCan
        <!-- Offcanvas to add new user -->

    </div>
</div>

<script>
    // select all checkbox functionality
    document.getElementById('select-all').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        for (let cb of checkboxes) {
            cb.checked = this.checked;
        }
    });

</script>
@endsection
