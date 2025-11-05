@extends('layoutsBackend.app')
@section('content')



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            @can("generation.qrp.view")

            <a href="{{ route('qrp.downloadExcel', ['id' => $agencies->id]) }}" class="btn btn-success">
                Download Excel
            </a>

            @endcan
            @roleCan('generation.qrp.create')
            <a href="{{ route('qrp.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New Details</span>
            </a>
            @endroleCan

        </h5>
        @roleCan('generation.qrp.view')
        <div class="card-datatable table-responsive">
            <table class=" table border-top">
                <thead>
                    <tr>
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
                        <td>{{ $qrp->id }}</td>
                        <td>{{ $qrp->meeting_name }}</td>
                        <td>{{ $qrp->meeting_from }} - {{ $qrp->meeting_to }}</td>
                        @php
                        $countries = App\Models\Country::pluck('name', 'id');

                        $countriii = json_decode($qrp->country, true) ?? [];

                        // Filter out empty/null entries first
                        $countryIds = collect($countriii)
                        ->pluck('country')
                        ->filter() // removes null/empty
                        ->toArray();

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
                            <form action="{{ route('qrp.destroy', $qrp) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        @endroleCan
        <!-- Offcanvas to add new user -->

    </div>
</div>
@endsection
