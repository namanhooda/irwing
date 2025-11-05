@extends('frontend.partials.app')

@section('content')

<style>
    /* --- (same styles as before, unchanged for brevity) --- */
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
    .container-xxl { animation: fadeInUp 0.6s ease-out; }
    @keyframes fadeInUp { from {opacity: 0; transform: translateY(30px);} to {opacity: 1; transform: translateY(0);} }
    .card { background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%); border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; padding: 0; }
    .card:hover { transform: translateY(-2px); box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12); }
    .card-body { padding: 0 !important; }
    .card-header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff !important; font-weight: 700; font-size: 1.4rem; border: none; padding: 25px 30px; position: relative; overflow: hidden; }
    .search-container { text-align: right; padding: 10px 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
    .search-input { border: 1px solid #ced4da; border-radius: 6px; padding: 8px 12px; width: 260px; font-size: 14px; transition: 0.3s ease; }
    .search-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); outline: none; }
    .table-responsive { border-radius: 0 0 20px 20px; overflow: hidden; }
    .table thead th { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: #fff; font-weight: 700; font-size: 13px; text-transform: uppercase; padding: 18px 20px; border: none; cursor: pointer; user-select: none; position: relative; }
    .table thead th.sortable::after { content: '⇅'; font-size: 11px; margin-left: 8px; opacity: 0.6; }
    .table thead th.sorted-asc::after { content: '▲'; }
    .table thead th.sorted-desc::after { content: '▼'; }
    .table tbody td { padding: 14px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #374151; }
    .table tbody tr:hover { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); }
    .pagination-container { display: flex; justify-content: flex-end; padding: 10px 15px; gap: 5px; background: #f8fafc; border-top: 1px solid #e2e8f0; }
    .pagination-container button { border: 1px solid #dee2e6; background: #f8f9fa; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 13px; transition: all 0.2s ease; }
    .pagination-container button.active, .pagination-container button:hover:not(:disabled) { background: #4f46e5; color: #fff; border-color: #4f46e5; }
</style>

<div class="mb-3 mb-lg-5"></div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h4 class="card-header d-flex justify-content-between align-items-center" style="background: #4a90e2;">
            IR Wing Office Memoranda (OMs)
        </h4>

        <!-- Search box -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Search by Name or Type...">
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="ormsTable">
                    <thead>
                        <tr>
                            <th class="sortable">S.No</th>
                            <th class="sortable">Type</th>
                            <th class="sortable">Order / Circular Name</th>
                            <th class="sortable">Date</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach($orms as $index => $orm)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $orm->omType->name ?? '-' }}</td>
                            <td>
                                <a href="{{ asset($orm->file) }}" target="_blank">
                                    {{ $orm->title }}
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($orm->date)->format('F d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-container" id="pagination"></div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    const rowsPerPage = 10;
    const table = document.getElementById("ormsTable");
    const tableBody = document.getElementById("tableBody");
    const allRows = Array.from(tableBody.querySelectorAll("tr"));
    const paginationContainer = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");
    const headers = table.querySelectorAll("thead th.sortable");

    let currentPage = 1;
    let filteredRows = [...allRows];
    let sortColumn = null;
    let sortDirection = 'asc';

    function displayRows(page) {
        tableBody.innerHTML = "";
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(row => tableBody.appendChild(row));
        renderPagination();
    }

    function renderPagination() {
        paginationContainer.innerHTML = "";
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (totalPages <= 1) return;

        const prevBtn = createPageButton("Prev", currentPage === 1, () => {
            if (currentPage > 1) { currentPage--; displayRows(currentPage); }
        });
        paginationContainer.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            const btn = createPageButton(i, false, () => {
                currentPage = i;
                displayRows(currentPage);
            });
            if (i === currentPage) btn.classList.add("active");
            paginationContainer.appendChild(btn);
        }

        const nextBtn = createPageButton("Next", currentPage === totalPages, () => {
            if (currentPage < totalPages) { currentPage++; displayRows(currentPage); }
        });
        paginationContainer.appendChild(nextBtn);
    }

    function createPageButton(label, disabled, onClick) {
        const btn = document.createElement("button");
        btn.textContent = label;
        btn.disabled = disabled;
        btn.addEventListener("click", onClick);
        return btn;
    }

    // ✅ SEARCH
    searchInput.addEventListener("keyup", function() {
        const term = this.value.toLowerCase();
        filteredRows = allRows.filter(row => {
            const typeCell = row.children[1]?.textContent.toLowerCase();
            const nameCell = row.children[2]?.textContent.toLowerCase();
            return typeCell.includes(term) || nameCell.includes(term);
        });
        currentPage = 1;
        displayRows(currentPage);
    });

    // ✅ SORTING
    headers.forEach((header, index) => {
        header.addEventListener("click", function() {
            const isSameColumn = sortColumn === index;
            sortDirection = isSameColumn && sortDirection === 'asc' ? 'desc' : 'asc';
            sortColumn = index;

            headers.forEach(h => h.classList.remove("sorted-asc", "sorted-desc"));
            this.classList.add(sortDirection === 'asc' ? "sorted-asc" : "sorted-desc");

            filteredRows.sort((a, b) => {
                const aText = a.children[index].innerText.trim().toLowerCase();
                const bText = b.children[index].innerText.trim().toLowerCase();
                
                if (!isNaN(Date.parse(aText)) && !isNaN(Date.parse(bText))) {
                    // Date sorting
                    return sortDirection === 'asc' 
                        ? new Date(aText) - new Date(bText)
                        : new Date(bText) - new Date(aText);
                } else if (!isNaN(aText) && !isNaN(bText)) {
                    // Numeric sorting (for S.No)
                    return sortDirection === 'asc'
                        ? aText - bText
                        : bText - aText;
                } else {
                    // Text sorting
                    return sortDirection === 'asc'
                        ? aText.localeCompare(bText)
                        : bText.localeCompare(aText);
                }
            });

            currentPage = 1;
            displayRows(currentPage);
        });
    });

    displayRows(currentPage);
});
</script>
