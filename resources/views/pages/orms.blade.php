@extends('frontend.partials.app')

@section('content')

<style>
    /* Modern page styling - keeping original background */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    .container-xxl {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Modern Card Design */
    .card {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08), 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 0;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12), 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    
    .card-body {
        padding: 0 !important;
    }
    
    .card-header {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 1.4rem;
        border: none;
        padding: 25px 30px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }
    
    .card-header:hover::before {
        left: 100%;
    }

    /* Enhanced Search Container */
    .search-container {
        padding: 25px 30px 15px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    
    .search-wrapper {
        position: relative;
        max-width: 350px;
        margin-left: auto;
    }
    
    .search-input {
        width: 100%;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        padding: 12px 20px 12px 50px;
        font-size: 14px;
        font-weight: 500;
        background: #ffffff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    
    .search-input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1), 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }
    
    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 16px;
        pointer-events: none;
    }

    /* Modern Table Styling */
    .table-responsive {
        border-radius: 0 0 20px 20px;
        overflow: hidden;
    }
    
    .table {
        margin: 0;
        border: none;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 18px 20px;
        border: none;
        text-align: left;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
        background: #ffffff;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        transform: scale(1.001);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    
    .table tbody tr:nth-child(even) {
        background: #fafbfc;
    }
    
    .table tbody tr:nth-child(even):hover {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }

    /* Enhanced Links */
    .table a {
        color: #4f46e5;
        font-weight: 600;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
        position: relative;
        display: inline-block;
    }
    
    .table a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        transition: width 0.3s ease;
    }
    
    .table a:hover {
        color: #7c3aed;
        transform: translateY(-1px);
    }
    
    .table a:hover::after {
        width: 100%;
    }

    /* Serial Number Styling */
    .serial-number {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 8px;
        display: inline-block;
        min-width: 30px;
        text-align: center;
    }

    /* Type Badge */
    .type-badge {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: #ffffff;
        font-weight: 600;
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    /* Date Styling */
    .date-cell {
        font-weight: 600;
        color: #64748b;
        font-size: 13px;
    }

    /* Modern Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 25px 30px;
        gap: 8px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-top: 1px solid #e2e8f0;
    }
    
    .pagination-container button {
        border: 2px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        padding: 10px 16px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        min-width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination-container button:hover:not(:disabled) {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        border-color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    
    .pagination-container button.active {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #ffffff;
        border-color: #4f46e5;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    
    .pagination-container button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        transform: none;
    }

    /* Results Info */
    .results-info {
        padding: 15px 30px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    /* Loading Animation */
    .loading {
        display: none;
        text-align: center;
        padding: 40px;
        color: #64748b;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e2e8f0;
        border-top: 4px solid #4f46e5;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-header {
            font-size: 1.2rem;
            padding: 20px;
        }
        
        .search-container {
            padding: 20px;
        }
        
        .search-wrapper {
            max-width: 100%;
        }
        
        .table thead th,
        .table tbody td {
            padding: 12px 15px;
            font-size: 13px;
        }
        
        .pagination-container {
            flex-wrap: wrap;
            gap: 6px;
        }
        
        .pagination-container button {
            min-width: 40px;
            height: 40px;
            padding: 8px 12px;
            font-size: 13px;
        }
    }

    /* No Results State */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }
    
    .no-results-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }
    
    .no-results h3 {
        color: #374151;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .no-results p {
        font-size: 14px;
        margin: 0;
    }
    .table a:hover {
        text-decoration: underline;
    }

    /* Search box */
    .search-container {
        text-align: right;
        padding: 10px 15px;
    }
    .search-input {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 6px 10px;
        width: 250px;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: flex-end;
        padding: 10px 15px;
        gap: 5px;
    }
    .pagination-container button {
        border: 1px solid #dee2e6;
        background: #f8f9fa;
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
    }
    .pagination-container button.active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
</style>

<div class="mb-3 mb-lg-5"></div>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h4 class="card-header d-flex justify-content-between align-items-center" style="    background: #4a90e2;
">
            IR Wing Office Memoranda (OMs)
        </h4>

        <!-- Search box -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Search by Name...">
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="ormsTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Type</th>
                            <th>Order / Circular Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach($orms as $index => $orm)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>Ir wing Portal
                            </td>
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

            <!-- Pagination -->
            <div class="pagination-container" id="pagination"></div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    const rowsPerPage = 10;
    const tableBody = document.getElementById("tableBody");
    const allRows = Array.from(tableBody.querySelectorAll("tr"));
    const paginationContainer = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");

    let currentPage = 1;
    let filteredRows = [...allRows];

    function displayRows(page) {
        tableBody.innerHTML = "";
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const rowsToShow = filteredRows.slice(start, end);
        rowsToShow.forEach(row => tableBody.appendChild(row));
        renderPagination();
    }

    function renderPagination() {
        paginationContainer.innerHTML = "";
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (totalPages <= 1) return;

        // Previous button
        const prevBtn = document.createElement("button");
        prevBtn.textContent = "Prev";
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                displayRows(currentPage);
            }
        });
        paginationContainer.appendChild(prevBtn);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.classList.toggle("active", i === currentPage);
            btn.addEventListener("click", () => {
                currentPage = i;
                displayRows(currentPage);
            });
            paginationContainer.appendChild(btn);
        }

        // Next button
        const nextBtn = document.createElement("button");
        nextBtn.textContent = "Next";
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener("click", () => {
            if (currentPage < totalPages) {
                currentPage++;
                displayRows(currentPage);
            }
        });
        paginationContainer.appendChild(nextBtn);
    }

    searchInput.addEventListener("keyup", function() {
        const term = this.value.toLowerCase();
        filteredRows = allRows.filter(row => {
            const nameCell = row.querySelector("td:nth-child(2)");
            return nameCell && nameCell.textContent.toLowerCase().includes(term);
        });
        currentPage = 1;
        displayRows(currentPage);
    });

    // Initial display
    displayRows(currentPage);
});
</script>
