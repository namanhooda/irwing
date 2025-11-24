@extends('layoutsBackend.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Officers Database - {{$checkprofile->staff_no}}</span>
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">
        </h5>

{{-- OFFICER DETAILS --}}
<div class="px-4 pb-4">
    <div class="row g-3">

        <div class="col-md-4">
            <div class="p-3 border rounded bg-light">
                <strong>Name:</strong> {{ $checkprofile->officer_name ?? 'N/A' }}<br>
                <strong>Email:</strong> {{ $checkprofile->email_id ?? 'N/A' }}<br>
                <strong>Mobile:</strong> {{ $checkprofile->mobile_no ?? 'N/A' }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-3 border rounded bg-light">
                <strong>Cadre:</strong> {{ $checkprofile->cadre ?? 'N/A' }}<br>
                <strong>Designation:</strong> {{ $checkprofile->designation ?? 'N/A' }}<br>
                <strong>Rank:</strong> {{ $checkprofile->rank ?? 'N/A' }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-3 border rounded bg-light">
                <strong>Level:</strong> {{ $checkprofile->level_in_pay_matrix ?? 'N/A' }}<br>
                <strong>Staff No:</strong> {{ $checkprofile->staff_no ?? 'N/A' }}<br>
                <strong>Total Tours:</strong> {{ $reports->count() }}
            </div>
        </div>

    </div>
</div>

        <div class="card-datatable table-responsive">

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

                    @forelse($reports as $report)

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
                        <td>{{ $report->from_date ? \Carbon\Carbon::parse($report->from_date)->format('d-m-Y') : '' }}
                        </td>
                        <td>{{ $report->to_date ? \Carbon\Carbon::parse($report->to_date)->format('d-m-Y') : '' }}</td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="18" class="text-center">No Tour Reports Found</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between p-3">
            <button id="prevPage" class="btn btn-secondary">Previous</button>
            <span id="pageInfo"></span>
            <button id="nextPage" class="btn btn-secondary">Next</button>
        </div>
    </div>
</div>

{{-- JS CODE --}}
<script>
    let table = document.getElementById("officersTable");
    let tbody = document.getElementById("tableBody");
    let searchInput = document.getElementById("searchInput");

    // Collect all rows in an array
    let allRows = Array.from(tbody.querySelectorAll("tr"));

    // Pagination settings
    let currentPage = 1;
    let rowsPerPage = 10;

    function renderTable() {
        let filteredRows = filterRows();
        let sortedRows = sortRows(filteredRows);

        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;

        let paginatedRows = sortedRows.slice(start, end);

        tbody.innerHTML = "";
        paginatedRows.forEach(row => tbody.appendChild(row));

        document.getElementById("pageInfo").innerText =
            `Page ${currentPage} of ${Math.ceil(sortedRows.length / rowsPerPage)}`;
    }

    // ------------------------ SEARCH --------------------------
    function filterRows() {
        let search = searchInput.value.toLowerCase();

        return allRows.filter(row =>
            row.innerText.toLowerCase().includes(search)
        );
    }

    searchInput.addEventListener("keyup", function () {
        currentPage = 1;
        renderTable();
    });

    // ------------------------ SORTING --------------------------
    let sortColumn = null;
    let sortDirection = 1; // 1 = asc, -1 = desc

    document.querySelectorAll("#officersTable thead th").forEach(header => {
        header.addEventListener("click", function () {
            let columnIndex = Array.from(header.parentNode.children).indexOf(header);

            if (sortColumn === columnIndex) {
                sortDirection *= -1;
            } else {
                sortColumn = columnIndex;
                sortDirection = 1;
            }

            renderTable();
        });
    });

    function sortRows(rows) {
        if (sortColumn === null) return rows;

        return rows.sort((a, b) => {
            let valA = a.children[sortColumn].innerText.trim().toLowerCase();
            let valB = b.children[sortColumn].innerText.trim().toLowerCase();

            if (!isNaN(valA) && !isNaN(valB)) {
                return (Number(valA) - Number(valB)) * sortDirection;
            }
            return valA.localeCompare(valB) * sortDirection;
        });
    }

    // ------------------------ PAGINATION ------------------------
    document.getElementById("prevPage").addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    document.getElementById("nextPage").addEventListener("click", () => {
        let rows = filterRows();
        if (currentPage < Math.ceil(rows.length / rowsPerPage)) {
            currentPage++;
            renderTable();
        }
    });

    // Initial load
    renderTable();

</script>

@endsection
