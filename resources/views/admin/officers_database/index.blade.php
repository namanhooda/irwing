@extends('layoutsBackend.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Officers Database</span>
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">
        </h5>

        <div class="card-datatable table-responsive">

            <table class="table table-bordered" id="officersTable">
                <thead>
                    <tr>
                        <th data-sort="name">Officer Name ▲▼</th>
                        <th data-sort="staff_number">Staff Number ▲▼</th>
                        <th data-sort="gender">Gender ▲▼</th>
                        <th data-sort="date_of_birth">Date of Birth ▲▼</th>
                        <th data-sort="total_tours">Total Tours ▲▼</th>
                        <th data-sort="total_tours">Action</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @foreach($officers as $officer)
                    <tr>
                        <td>{{ $officer->name }}</td>
                        <td>{{ $officer->staff_number }}</td>
                        <td>{{ $officer->gender }}</td>
                        <td>{{ $officer->date_of_birth }}</td>
                        <td>{{ $officer->total_tours }}</td>
                        <td><a href="{{ url('officer-database/'.$officer->staff_number) }}">View Details</a></td>
                    </tr>
                    @endforeach
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
                sortDirection *=  -1;
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
