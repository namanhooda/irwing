@extends('layoutsBackend.app')

@section('content')

    {{-- Readability: force high-contrast, black text and muted backgrounds for dashboard elements (copied from dashboard.blade.php) --}}
    <style>
    /* Dashboard readability improvements */
    .container-xxl, .card, .table, .form-select, .btn, .card-title, h4 {
        color: #000 !important;
        font-size: 0.95rem;
        line-height: 1.45;
    }
    .card {
        background: #ffffff !important;
        border: 1px solid #e6e9ee !important;
        box-shadow: 0 1px 3px rgba(16,24,40,0.05);
    }
    .card-header, .card-title {
        background: #f5f7fa;
        color: #000 !important;
        font-weight: 600;
        border-bottom: 1px solid #e6e9ee;
    }
    .table thead th {
        background: #f8fafc !important;
        color: #000 !important;
        border-bottom: 2px solid #e9eef3 !important;
    }
    .table tbody tr td {
        color: #000 !important;
    }
    .table-hover tbody tr:hover {
        background: #fbfdff;
    }
    .form-select {
        background: #fff;
        color: #000 !important;
        border: 1px solid #ced4da;
        /* show a consistent dropdown caret and remove native appearance for cross-browser look */
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 2.25rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='16' height='16' fill='none' stroke='%23000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
    }
    .btn, .btn-outline-secondary {
        color: #000 !important;
        background: #e9eef3;
        border-color: #d0d7df;
    }
    .btn.btn-primary {
        background: #2563eb; /* clearer blue */
        border-color: #1d4ed8;
        color: #fff !important;
    }
    .sticky-top.bg-white { background: #fff !important; }
    .leaflet-container { background: #fff; }

    /* Make all filter dropdowns uniform */
.filter-row .form-select {
    width: 180px;
    min-width: 180px;
}

/* Ensure responsiveness */
@media (max-width: 768px) {
    .filter-row .form-select {
        width: 100%;
        min-width: 100%;
    }

    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }

    #clearFilters {
        width: 100%;
    }
}

    </style>

@php
    $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
@endphp

@if($activeRole == 'admin')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="row g-6 mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="mb-0">Contributions Dashboard</h4>

            <div class="d-flex flex-wrap gap-2 align-items-center filter-row">
    <select id="filterMonth" class="form-select">
        <option value="">All Months</option>
    </select>

    <select id="filterStudyGroup" class="form-select">
        <option value="">All Study Groups</option>
    </select>

    <select id="filterType" class="form-select">
        <option value="">All Types</option>
        <option value="ITU-T">ITU-T</option>
        <option value="ITU-R">ITU-R</option>
        <option value="ITU_D">ITU-D</option>
    </select>

    <select id="filterPriority" class="form-select">
        <option value="">All Priorities</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <select id="filterOfficer" class="form-select">
        <option value="">All Officers</option>
    </select>

    <button id="clearFilters" class="btn btn-outline-secondary ms-auto">Clear</button>
</div>

        </div>
    </div>

    {{-- Charts Row --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Month-wise contributions</h5></div>
                <div class="card-body"><div id="monthWiseContribChart"></div></div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Contribution types</h5></div>
                <div class="card-body d-flex justify-content-center align-items-center"><div id="typePieChart"></div></div>
            </div>
        </div>
    </div>

    {{-- Priority bar --}}
    <div class="row g-4 mb-4">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Priority counts</h5></div>
                <div class="card-body"><div id="priorityBarChart"></div></div>
            </div>
        </div>
    </div>

    {{-- Contributions Table --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title">Contributions</h5></div>
                <div class="table-responsive" style="max-height: 520px; overflow-y: auto;">
                    <table class="table table-hover"> {{-- improved readability with hover --}}
                        <thead class="sticky-top bg-white">
                            <tr>
                                <th style="width:12%;">Study Group</th>
                                <th style="width:14%;">Question</th>
                                <th style="width:12%;">Work Item</th>
                                <th style="width:10%;">Contribution Type</th>
                                <th style="width:20%;">Brief</th>
                                <th style="width:8%;">Date</th>
                                <th style="width:12%;">Officers</th>
                                <th style="width:6%;">Type</th>
                                <th style="width:6%;">Priority</th>
                                <th style="width:8%;">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ---------- Raw data ----------
    let rawData = @json($ITUContribution ?? []);
    if (!Array.isArray(rawData)) rawData = [];
    // normalize each record slightly so field names are predictable
    rawData = rawData.map(r => ({
        id: r.id ?? null,
        study_group: r.study_group ?? '',
        question: r.question ?? '',
        work_item: r.work_item ?? '',
        contribution_type: r.contribution_type ?? '',
        contribution_brief: r.contribution_brief ?? '',
        date_of_contribution: r.date_of_contribution ?? r.created_at ?? '',
        officers: r.officers ?? '',
        type: r.type ?? '',
        priority: (r.priority === null || r.priority === undefined) ? '' : String(r.priority).toLowerCase(),
        status: r.status ?? ''
    }));

    let filteredData = rawData.slice();

    // ---------- Utilities ----------
    const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    function normalizeString(v){ return (v === null || v === undefined) ? '' : String(v).trim(); }
    function monthFromDate(dstr){
        if(!dstr) return null;
        // try ISO-like, or yyyy-mm-dd, or other parseable formats
        const d = new Date(dstr);
        if(isNaN(d.getTime())){
            // try to parse yyyy-mm or yyyy-mm-dd manually
            const m = dstr.match(/(\d{4})[-\/](\d{1,2})/);
            if(m){
                const monthIndex = parseInt(m[2],10) - 1;
                if(monthIndex >=0 && monthIndex < 12) return monthNames[monthIndex];
            }
            return null;
        }
        return monthNames[d.getMonth()];
    }
    function countBy(records, keyFn){
        const m = {};
        records.forEach(r => {
            const k = normalizeString(keyFn(r));
            if(!k) return;
            m[k] = (m[k]||0) + 1;
        });
        return m;
    }
    function ensureSelect(sel, values){
        // remove existing non-empty options (keep first option)
        const firstOpt = sel.options[0];
        sel.innerHTML = '';
        sel.appendChild(firstOpt);
        const unique = Array.from(new Set(values.filter(v=>v && v !== ''))).sort();
        unique.forEach(v => sel.appendChild(new Option(v, v)));
    }

    // ---------- DOM elements ----------
    const filterMonthEl = document.getElementById('filterMonth');
    const filterStudyGroupEl = document.getElementById('filterStudyGroup');
    const filterTypeEl = document.getElementById('filterType');
    const filterPriorityEl = document.getElementById('filterPriority');
    const filterOfficerEl = document.getElementById('filterOfficer');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // ---------- Populate selects with distinct values ----------
    function populateSelects(){
        const months = new Set();
        const studyGroups = new Set();
        const officers = new Set();
        const types = new Set();
        const priorities = new Set();

        rawData.forEach(r=>{
            const m = monthFromDate(r.date_of_contribution);
            if(m) months.add(m);
            if(r.study_group) studyGroups.add(r.study_group);
            if(r.officers){
                // officers field may contain newlines or numbered list: split by newline/semicolon/comma and add individually
                const parts = String(r.officers).split(/\n|;|,/).map(s=>s.trim()).filter(Boolean);
                parts.forEach(p => officers.add(p));
            }
            if(r.type) types.add(r.type);
            if(r.priority) priorities.add(r.priority);
        });

        // fill selects
    // month: always include full month list for discoverability (sorted by calendar order)
    const monthList = monthNames.slice();
        // study groups
        const studyGroupList = Array.from(studyGroups).sort();
        const officerList = Array.from(officers).sort();
        const typeList = Array.from(types).sort();
    const priorityList = Array.from(priorities).map(p => String(p).toLowerCase()).sort();
    // ensure both 'yes' and 'no' exist so users can always filter by them
    const normalizedPriorities = Array.from(new Set([...'yes,no'.split(','), ...priorityList]));

        // inject options
        // helper to populate preserving first "All" option
        function setOptions(selectEl, list, allText){
            selectEl.innerHTML = '';
            selectEl.appendChild(new Option(allText, ''));
            list.forEach(v => selectEl.appendChild(new Option(v, v)));
        }
        setOptions(filterMonthEl, monthList, 'All Months');
        setOptions(filterStudyGroupEl, studyGroupList, 'All Study Groups');
        // filterTypeEl already has some options from blade; let's merge
        // we will ensure default "All" exists then append any types not present
        (function fillType(){
            const existing = Array.from(filterTypeEl.options).map(o=>o.value);
            if(!existing.includes('')) filterTypeEl.insertBefore(new Option('All Types', ''), filterTypeEl.firstChild);
            const toAdd = typeList.filter(t => !existing.includes(t));
            toAdd.forEach(t => filterTypeEl.appendChild(new Option(t, t)));
        })();
    setOptions(filterPriorityEl, normalizedPriorities.length ? normalizedPriorities : ['yes','no'], 'All Priorities');
        setOptions(filterOfficerEl, officerList, 'All Officers');
    }
    populateSelects();

    // ---------- ApexCharts instances ----------
    const monthChart = new ApexCharts(document.querySelector("#monthWiseContribChart"), {
        chart: { 
            type: 'bar', 
            height: 340,
            toolbar: { show: false },
            background: 'transparent'
        },
        series: [{ name: 'Contributions', data: [] }],
        xaxis: { 
            categories: [],
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '11px',
                    fontWeight: 600
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '11px',
                    fontWeight: 600
                }
            }
        },
        colors: ['#10b981'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.25,
                gradientToColors: ['#34d399'],
                inverseColors: false,
                opacityFrom: 0.9,
                opacityTo: 0.7,
                stops: [0, 100]
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '60%',
                borderRadiusApplication: 'end'
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '11px',
                fontWeight: 700,
                colors: ['#000000']
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                color: '#ffffff',
                opacity: 0.8
            }
        },
        grid: {
            show: true,
            borderColor: '#e2e8f0',
            strokeDashArray: 3,
            position: 'back',
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        tooltip: { 
            theme: 'light',
            style: {
                fontSize: '12px',
                fontFamily: 'Inter, sans-serif'
            },
            y: { formatter: function(val){ return val + " contributions"; } },
            marker: {
                show: true
            }
        }
    });
    monthChart.render();

    const typePie = new ApexCharts(document.querySelector("#typePieChart"), {
        chart: { 
            type: 'donut', 
            height: 340,
            background: 'transparent'
        },
        series: [],
        labels: [],
        colors: ['#6366f1', '#8b5cf6', '#ec4899', '#f59e0b', '#ef4444', '#10b981', '#06b6d4', '#84cc16'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'radial',
                shadeIntensity: 0.4,
                gradientToColors: ['#4f46e5', '#7c3aed', '#db2777', '#d97706', '#dc2626', '#059669', '#0891b2', '#65a30d'],
                inverseColors: false,
                opacityFrom: 0.9,
                opacityTo: 0.6,
                stops: [0, 100]
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '50%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '16px',
                            fontWeight: 600,
                            color: '#000000'
                        },
                        value: {
                            show: true,
                            fontSize: '24px',
                            fontWeight: 700,
                            color: '#000000'
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#000000'
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '11px',
                fontWeight: 700,
                colors: ['#000000']
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 2,
                color: '#ffffff',
                opacity: 0.8
            }
        },
        legend: { 
            position: 'bottom',
            fontSize: '12px',
            fontWeight: 600,
            labels: {
                colors: '#4b5563',
                useSeriesColors: false
            },
            markers: {
                width: 12,
                height: 12,
                radius: 6
            }
        },
        tooltip: {
            theme: 'light',
            style: {
                fontSize: '12px',
                fontFamily: 'Inter, sans-serif'
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: ['#ffffff'],
            width: 3
        }
    });
    typePie.render();

    const priorityBar = new ApexCharts(document.querySelector("#priorityBarChart"), {
        chart: { 
            type: 'bar', 
            height: 300,
            toolbar: { show: false },
            background: 'transparent'
        },
        series: [{ name: 'Priority Count', data: [] }],
        xaxis: { 
            categories: [],
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '11px',
                    fontWeight: 600
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '11px',
                    fontWeight: 600
                }
            }
        },
        colors: ['#f59e0b'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.25,
                gradientToColors: ['#fbbf24'],
                inverseColors: false,
                opacityFrom: 0.9,
                opacityTo: 0.7,
                stops: [0, 100]
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '50%',
                borderRadiusApplication: 'end',
                distributed: false
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '11px',
                fontWeight: 700,
                colors: ['#000000']
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                color: '#ffffff',
                opacity: 0.8
            }
        },
        grid: {
            show: true,
            borderColor: '#e2e8f0',
            strokeDashArray: 3,
            position: 'back',
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        tooltip: {
            theme: 'light',
            style: {
                fontSize: '12px',
                fontFamily: 'Inter, sans-serif'
            },
            marker: {
                show: true
            }
        },
        stroke: {
            show: true,
            width: 0
        }
    });
    priorityBar.render();

    // ---------- Data -> update all charts & table ----------
    function updateAll(records){
        // Month chart
        const monthMap = {};
        records.forEach(r => {
            const m = monthFromDate(r.date_of_contribution) || 'Unknown';
            monthMap[m] = (monthMap[m] || 0) + 1;
        });
        const monthKeys = Object.keys(monthMap).sort((a,b)=> {
            const ia = monthNames.indexOf(a), ib = monthNames.indexOf(b);
            if(ia === -1 && ib === -1) return a.localeCompare(b);
            if(ia === -1) return 1;
            if(ib === -1) return -1;
            return ia - ib;
        });
        monthChart.updateOptions({ xaxis: { categories: monthKeys } });
        monthChart.updateSeries([{ data: monthKeys.map(k => monthMap[k]) }]);

        // Type pie
        const typeCounts = countBy(records, r => r.type || 'Unknown');
        const typeLabels = Object.keys(typeCounts);
        const typeValues = typeLabels.map(l => typeCounts[l]);
        typePie.updateOptions({ labels: typeLabels });
        typePie.updateSeries(typeValues);

        // Priority bar
        const priorityCounts = countBy(records, r => (r.priority || 'no').toLowerCase() );
        const prCats = Object.keys(priorityCounts);
        priorityBar.updateOptions({ xaxis: { categories: prCats } });
        priorityBar.updateSeries([{ data: prCats.map(c => priorityCounts[c]) }]);

        // Table
        const tbody = document.querySelector('tbody.table-border-bottom-0');
        tbody.innerHTML = '';
        records.forEach(r => {
            const tr = document.createElement('tr');
            const brief = (r.contribution_brief && r.contribution_brief.length > 180) ? (r.contribution_brief.substring(0,180) + '...') : r.contribution_brief;
            tr.innerHTML = `<td>${escapeHtml(r.study_group)}</td>
                            <td>${escapeHtml(r.question)}</td>
                            <td>${escapeHtml(r.work_item)}</td>
                            <td>${escapeHtml(r.contribution_type)}</td>
                            <td title="${escapeAttribute(r.contribution_brief)}">${escapeHtml(brief || '-')}</td>
                            <td>${escapeHtml(r.date_of_contribution ? formatDate(r.date_of_contribution) : '')}</td>
                            <td>${escapeHtml(r.officers)}</td>
                            <td>${escapeHtml(r.type)}</td>
                            <td>${escapeHtml(r.priority)}</td>
                            <td>${escapeHtml(r.status)}</td>`;
            tbody.appendChild(tr);
        });
    }

    // ---------- Helpers ----------
    function formatDate(dstr){
        if(!dstr) return '';
        const d = new Date(dstr);
        if(isNaN(d.getTime())){
            // try more friendly fallback: show original string
            return dstr;
        }
        return d.toLocaleDateString();
    }
    function escapeHtml(s){
        if(s === null || s === undefined) return '';
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }
    function escapeAttribute(s){
        if(s === null || s === undefined) return '';
        return String(s).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    // ---------- Main filter logic ----------
    function applyFilters(){
        const selMonth = normalizeString(filterMonthEl.value);
        const selStudyGroup = normalizeString(filterStudyGroupEl.value);
        const selType = normalizeString(filterTypeEl.value);
        const selPriority = normalizeString(filterPriorityEl.value);
        const selOfficer = normalizeString(filterOfficerEl.value);

        filteredData = rawData.filter(r => {
            if(selMonth){
                const m = monthFromDate(r.date_of_contribution) || '';
                if(m !== selMonth) return false;
            }
            if(selStudyGroup){
                if(normalizeString(r.study_group) !== selStudyGroup) return false;
            }
            if(selType){
                if(normalizeString(r.type) !== selType) return false;
            }
            if(selPriority){
                if(normalizeString(r.priority) !== selPriority) return false;
            }
            if(selOfficer){
                // officer filtering: check if any of the comma/newline-separated parts match exactly
                const parts = String(r.officers || '').split(/\n|;|,/).map(p=>p.trim()).filter(Boolean);
                const found = parts.some(p => normalizeString(p) === selOfficer);
                if(!found) return false;
            }
            return true;
        });

        updateAll(filteredData);
    }

    // ---------- Hook up selects ----------
    [filterMonthEl, filterStudyGroupEl, filterTypeEl, filterPriorityEl, filterOfficerEl].forEach(el => {
        el.addEventListener('change', () => applyFilters());
    });

    clearFiltersBtn.addEventListener('click', () => {
        filterMonthEl.value = '';
        filterStudyGroupEl.value = '';
        filterTypeEl.value = '';
        filterPriorityEl.value = '';
        filterOfficerEl.value = '';
        applyFilters();
    });

    // ---------- Click interactions from charts ----------
    // Month chart: click to set month filter
    monthChart.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.xaxis.categories[idx];
                        if(label){
                            filterMonthEl.value = label;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    // typePie: clicking slice will set type filter
    typePie.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.labels[idx];
                        if(label){
                            filterTypeEl.value = label;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    // priorityBar: clicking bar sets priority filter
    priorityBar.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.xaxis.categories[idx];
                        if(label){
                            filterPriorityEl.value = label;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    // ---------- Initial render ----------
    applyFilters(); // will render all charts & table

});
</script>
@endpush
