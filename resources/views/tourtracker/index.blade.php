@extends('layoutsBackend.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            @can("generation.qrp.view")
            Tour Tracker
            @endcan
        </h5>

        @roleCan('generation.qrp.view')
        <div class="card-datatable table-responsive">
            <!-- Filter Form -->
            <form action="{{ route('qrp-generation.index') }}" method="GET" class="row mb-3" style="padding-left: 20px;">
                <div class="col-md-3">
                    <label for="quarter" class="form-label">Select Quarter</label>
                    <select name="quarter" id="quarter" class="form-select">
                        <option value="">-- All Quarters --</option>
                        <option value="Quater 1 (Jan-Mar)" {{ request('quarter') == 'Q1' ? 'selected' : '' }}>Quater 1 (Jan-Mar)</option>
                        <option value="Quater 2 (Apr-Jun)" {{ request('quarter') == 'Q2' ? 'selected' : '' }}>Quater 2 (Apr-Jun)</option>
                        <option value="Quater 3 (Jul-Sep)" {{ request('quarter') == 'Q3' ? 'selected' : '' }}>Quater 3 (Jul-Sep)</option>
                        <option value="Quater 4 (Oct-Dec)" {{ request('quarter') == 'Q4' ? 'selected' : '' }}>Quater 4 (Oct-Dec)</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="itu" class="form-label">ITU List</label>
                    <select name="itu" id="itu" class="form-select">
                        <option value="">-- All ITU --</option>
                        @foreach($agencies as $agencydata)
                        <option value="{{ $agencydata->id }}" {{ request('itu') == $agencydata->id ? 'selected' : '' }}>
                            {{ $agencydata->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
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

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>&nbsp;
                    <a href="{{ route('qrp-generation.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            @if($qrps->count() > 0)
            <form action="{{ route('qrp-generation.bulk-update-status') }}" method="POST" style="padding-left: 20px;">
                @csrf

                <div class="card-datatable" style="overflow-x:auto; white-space:nowrap;">
                    <table class="table border-top table-striped table-bordered" style="min-width: 1500px;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tour Id</th>
                                <th>Meeting Name</th>
                                <th>Meeting Duration</th>
                                <th>Country</th>
                                <th>Delegation proposed</th>
                                <th>Administrative Approval</th>
                                <th>Financial Approval</th>
                                <th>Political Clearance</th>
                                <th>SCoS Approval</th>
                                <th>Vigilance Approval</th>
                                <th>PMO Approval</th>
                                <th>FCRA Clearance</th>
                                <th>Sanction Vetting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qrps as $qrp)
                            <tr>
                                <td>{{ $qrp->id }}</td>
                                <td>{{ $qrp->meeting_id }}</td>
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
                                    $options = ['Not Applied', 'Applied', 'Approved', 'Rejected'];
                                @endphp

                                <td>{{ $countryStr ?? 'N/A' }}</td>
                                <td>N/A</td>

                                @foreach(['adminidtrative_appr', 'financial_appr', 'poltical_clear', 'scos_appr', 'vigl_clear', 'pmo_appr', 'fcra_clear', 'sanction_vetting'] as $field)
    <td>
        <select name="{{ $field }}[{{ $qrp->id }}]" class="form-select status-dropdown">
            @foreach($options as $opt)
                <option value="{{ $opt }}" {{ $qrp->$field == $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
    </td>
@endforeach

{{-- ✅ Check if all approvals are "Approved" --}}
@php
    $fields = ['adminidtrative_appr', 'financial_appr', 'poltical_clear', 'scos_appr', 'vigl_clear', 'pmo_appr', 'fcra_clear', 'sanction_vetting'];
    $allApproved = collect($fields)->every(fn($f) => $qrp->$f === 'Approved');
@endphp

<td>
    @if($allApproved)
        <a href="{{ route('sanction-memo.generate', $qrp->id) }}" class="btn btn-primary btn-sm">
            Generate Sanction Memo
        </a>
    @endif
</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
            @else
            <div class="alert alert-info mx-3">No Pending QRPs found.</div>
            @endif
        </div>
        @endroleCan
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.status-dropdown');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const qrpId = this.name.match(/\[(\d+)\]/)[1];
            const field = this.name.split('[')[0];
            const value = this.value;

            // Disable dropdown while updating
            this.disabled = true;

            fetch("{{ route('qrp-generation.update-field') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    id: qrpId,
                    field: field,
                    value: value
                })
            })
            .then(response => response.json())
            .then(data => {
                this.disabled = false;
                if (data.success) {
                    if (window.toastr) {
                        toastr.success(`${field.replace('_', ' ')} updated successfully`);
                    } else {
                        alert(`${field.replace('_', ' ')} updated successfully`);
                    }
                } else {
                    toastr?.error('Update failed') ?? alert('Update failed');
                }
            })
            .catch(error => {
                this.disabled = false;
                toastr?.error('An error occurred') ?? alert('An error occurred');
                console.error(error);
            });
        });
    });
});
</script>

@endsection
