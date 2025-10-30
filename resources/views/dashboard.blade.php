@extends('layoutsBackend.app')

@section('content')

    {{-- Readability: force high-contrast, black text and muted backgrounds for dashboard elements --}}
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
        /* remove native arrow and add custom SVG caret to the right */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 20 20'%3E%3Cpath d='M6 8l4 4 4-4' stroke='%23000' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round' fill='none'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 0.85rem;
        padding-right: 2.2rem; /* room for the arrow */
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
    </style>
    <style>
    /* make all select boxes same width */
    .filter-row .form-select {
        width: 180px; /* adjust width as you like */
        min-width: 180px;
    }

    /* ensure select boxes stay consistent on smaller screens */
    @media (max-width: 768px) {
        .filter-row .form-select {
            width: 100%;
            min-width: 100%;
        }
    }
</style>

    @php
    $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
    @endphp
    @if($activeRole == 'admin')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="row g-4 mb-2">
        <div class="col-12">
            <h4 class="mb-0">Dashboard</h4>
        </div>
    </div>

    {{-- FILTER ROW --}}
   <div class="d-flex flex-wrap gap-2 mb-3 filter-row">
    <div class="mb-2">
        <select id="officerFilter" class="form-select">
            <option value="">All officers</option>
            @if(isset($officers))
                @foreach($officers as $officer)
                    @if(!empty($officer))
                        <option value="{{ $officer }}">{{ $officer }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
    <div class="mb-2">
        <select id="filterMonth" class="form-select filter-select">
            <option value="">All Months</option>
        </select>
    </div>
    <div class="mb-2">
        <select id="filterMeeting" class="form-select filter-select">
            <option value="">All Purposes</option>
        </select>
    </div>
    <div class="mb-2">
        <select id="filterCountry" class="form-select filter-select">
            <option value="">All Countries</option>
        </select>
    </div>
    <div class="mb-2">
        <select id="filterCadre" class="form-select filter-select">
            <option value="">All Cadres</option>
        </select>
    </div>
    <div class="mb-2">
        <select id="filterGender" class="form-select filter-select">
            <option value="">All Genders</option>
        </select>
    </div>
    <div class="mb-2 ms-auto">
        <button id="clearFilters" class="btn btn-outline-secondary">Clear</button>
    </div>
</div>
    {{-- Charts - Row 1 --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-7 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Month wise visits</h5></div>
                <div class="card-body"><div id="monthWiseVisitsChart"></div></div>
            </div>
        </div>

        <div class="col-lg-5 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Types of meetings</h5></div>
                <div class="card-body"><div id="meetingsTreemapChart"></div></div>
            </div>
        </div>
    </div>

    {{-- Charts - Row 2: Map and ITU Pie --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Country and city wise visits (map)</h5></div>
                {{-- Map height increased slightly for better fit with the taller pie chart --}}
                <div class="card-body"><div id="visitsMap" style="height: 450px;"></div></div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">ITU sectors (only for ITU related visits)</h5></div>
                {{-- Added flex utilities to ensure the pie chart centers vertically --}}
                <div class="card-body d-flex justify-content-center align-items-center"><div id="ituSectorsPieChart"></div></div>
            </div>
        </div>
    </div>

    {{-- Officer Profile Charts - Row 3 --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Levels of officers</h5></div>
                <div class="card-body"><div id="officerLevelsTreemap"></div></div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Age profile</h5></div>
                <div class="card-body"><div id="ageProfileBarChart"></div></div>
            </div>
        </div>
    </div>

    {{-- Officer Profile Charts - Row 4 --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Cadre of officers</h5></div>
                <div class="card-body d-flex justify-content-center align-items-center"><div id="cadrePieChart"></div></div>
            </div>
        </div>

        <div class="col-md-8 col-12">
            <div class="card h-100"> {{-- Added h-100 --}}
                <div class="card-header"><h5 class="card-title mb-0">Gender</h5></div>
                <div class="card-body"><div id="genderBarChart"></div></div>
            </div>
        </div>
    </div>

    {{-- Officer Details Table --}}
<div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="card-title">Officer details</h5></div>
                {{-- Removed 'text-nowrap' in the previous step, which is correct for responsiveness --}}
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover"> {{-- Added table-hover for better UX --}}
                        <thead class="sticky-top bg-white">
                            <tr>
                                {{-- Apply width styles to distribute space more evenly --}}
                                <th style="width: 20%;">Name of the Officer</th>
                                <th style="width: 30%;">Purpose</th>
                                <th style="width: 15%;">Country</th>
                                <th style="width: 25%;">Meeting</th>
                                <th style="width: 10%;">Equivalent Level</th>
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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ---------- Raw data ----------
    let rawData = @json($tourReport ?? []);
    if (!Array.isArray(rawData)) rawData = [];
    let filteredData = rawData.slice();

    // ---------- Utilities ----------
    const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    function normalizeString(v){ return v ? String(v).trim() : ''; }
    function monthFromDate(dstr){ if(!dstr) return null; const d=new Date(dstr); return isNaN(d.getTime()) ? null : monthNames[d.getMonth()]; }
    function countBy(records, keyFn){
        const m = {};
        records.forEach(r => {
            const k = normalizeString(keyFn(r));
            if(!k) return;
            m[k] = (m[k]||0) + 1;
        });
        return m;
    }
    function mapToTreemapData(obj){ return Object.keys(obj).map(k=>({ x: k, y: obj[k] })); }

    // ---------- DOM elements ----------
    const filterMonthEl = document.getElementById('filterMonth');
    const filterMeetingEl = document.getElementById('filterMeeting'); // purpose
    const filterCountryEl = document.getElementById('filterCountry');
    const filterCadreEl = document.getElementById('filterCadre');
    const filterGenderEl = document.getElementById('filterGender');
    const officerFilterEl = document.getElementById('officerFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // Selected filters from chart clicks (these are additional to selects)
    let selectedLevelFilter = null;
    let selectedSectorFilter = null;
    let activeAgeBucket = null;

    // ---------- Populate selects with distinct values ----------
    function populateSelects(){
        const months = new Set();
        const purposes = new Set();
        const countries = new Set();
        const cadres = new Set();
        const genders = new Set();

        rawData.forEach(r=>{
            const m = monthFromDate(r.from_date || r.created_at);
            if(m) months.add(m);
            if(r.purpose) purposes.add(r.purpose);
            if(r.country) countries.add(r.country);
            if(r.cadre) cadres.add(r.cadre);
            if(r.gender) genders.add(r.gender);
        });

        // months sorted by monthNames index
        Array.from(months).sort((a,b)=>monthNames.indexOf(a)-monthNames.indexOf(b)).forEach(m=> filterMonthEl.appendChild(new Option(m, m)));
        Array.from(purposes).sort().forEach(p=> filterMeetingEl.appendChild(new Option(p, p)));
        Array.from(countries).sort().forEach(c=> filterCountryEl.appendChild(new Option(c, c)));
        Array.from(cadres).sort().forEach(ca=> filterCadreEl.appendChild(new Option(ca, ca)));
        Array.from(genders).sort().forEach(g=> filterGenderEl.appendChild(new Option(g, g)));
    }
    populateSelects();

    // ---------- ApexCharts instances (HEIGHTS ADJUSTED) ----------
    const monthChart = new ApexCharts(document.querySelector("#monthWiseVisitsChart"), {
        chart: {
            type: 'bar', height: 380, // INCREASED from 340 to better utilize space
            toolbar: { show: false },
            background: 'transparent',
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.xaxis.categories[idx] || chartContext.w.globals.labels[idx];
                        if(label){
                            // set select and apply
                            filterMonthEl.value = label;
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        series: [{ name: 'Tours', data: [] }],
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
            enabled: false
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
        }
    });
    monthChart.render();

    const meetingsTreemap = new ApexCharts(document.querySelector("#meetingsTreemapChart"), {
        chart: {
            type: 'treemap', height: 380, // INCREASED from 340 to match monthChart
            events: {
                dataPointSelection: function(event, chartContext, config){
                    // treemap stores data in series[0].data
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const dataPoint = chartContext.w.config.series[0].data[idx];
                        const label = dataPoint?.x ?? chartContext.w.globals.labels[idx];
                        if(label){
                            filterMeetingEl.value = label;
                            // clear other chart-click filters to behave like "set this filter"
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        series: [{ data: [] }],
        plotOptions: { 
            treemap: { 
                distributed: true, 
                enableShades: false,
                colorScale: {
                    ranges: [
                        { from: 0, to: 5, color: '#F0F9FF' },
                        { from: 6, to: 15, color: '#BAE6FD' },
                        { from: 16, to: 30, color: '#7DD3FC' },
                        { from: 31, to: 50, color: '#38BDF8' },
                        { from: 51, to: 100, color: '#0EA5E9' }
                    ]
                }
            } 
        },
        colors: ['#0EA5E9', '#38BDF8', '#7DD3FC', '#BAE6FD', '#F0F9FF', '#0284C7', '#0369A1'],
        dataLabels: {
            style: {
                fontSize: '12px',
                fontWeight: 600,
                colors: ['#1E293B']
            }
        }
    });
    meetingsTreemap.render();

    const ituPie = new ApexCharts(document.querySelector("#ituSectorsPieChart"), {
        chart: {
            type: 'donut', height: 400, // INCREASED to fill the height next to the map
            background: 'transparent',
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.labels[idx];
                        if(label){
                            // set selected sector filter (not a select)
                            selectedSectorFilter = label;
                            // clear select-level stuff to avoid confusion
                            filterMeetingEl.value = '';
                            filterMonthEl.value = '';
                            selectedLevelFilter = null;
                            activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        labels: [],
        series: [],
        colors: ['#10B981', '#34D399', '#6EE7B7', '#A7F3D0', '#D1FAE5', '#059669', '#047857'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'radial',
                shadeIntensity: 0.4,
                gradientToColors: ['#059669', '#10b981', '#34d399', '#6ee7b7', '#a7f3d0', '#047857', '#065f46'],
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
    ituPie.render();

    const levelsTreemap = new ApexCharts(document.querySelector("#officerLevelsTreemap"), {
        chart: {
            type: 'treemap', height: 340,
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.series[0].data[idx]?.x || chartContext.w.globals.labels[idx];
                        if(label){
                            selectedLevelFilter = label;
                            // clear other chart-clicks if desired
                            selectedSectorFilter = null;
                            activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        series: [{ data: [] }],
        plotOptions: { 
            treemap: { 
                distributed: true, 
                enableShades: false,
                colorScale: {
                    ranges: [
                        { from: 0, to: 3, color: '#FEF3C7' },
                        { from: 4, to: 8, color: '#FDE68A' },
                        { from: 9, to: 15, color: '#FCD34D' },
                        { from: 16, to: 25, color: '#F59E0B' },
                        { from: 26, to: 100, color: '#D97706' }
                    ]
                }
            } 
        },
        colors: ['#F59E0B', '#FBBF24', '#FCD34D', '#FDE68A', '#FEF3C7', '#D97706', '#B45309'],
        dataLabels: {
            style: {
                fontSize: '12px',
                fontWeight: 600,
                colors: ['#1E293B']
            }
        }
    });
    levelsTreemap.render();

    const ageBar = new ApexCharts(document.querySelector("#ageProfileBarChart"), {
        chart: {
            type: 'bar', height: 340,
            toolbar: { show: false },
            background: 'transparent',
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const bucket = chartContext.w.config.xaxis.categories[idx];
                        if(bucket){
                            activeAgeBucket = bucket;
                            // clear other click filters
                            selectedLevelFilter = null; selectedSectorFilter = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        series: [{ name: 'Age Count', data: [] }],
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
            marker: {
                show: true
            }
        }
    });
    ageBar.render();

    const cadrePie = new ApexCharts(document.querySelector("#cadrePieChart"), {
        chart: {
            type: 'donut', height: 320,
            background: 'transparent',
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const label = chartContext.w.config.labels[idx];
                        if(label){
                            filterCadreEl.value = label;
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        labels: [], 
        series: [],
        colors: ['#EF4444', '#F87171', '#FCA5A5', '#FECACA', '#FEE2E2', '#DC2626', '#B91C1C'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'radial',
                shadeIntensity: 0.4,
                gradientToColors: ['#DC2626', '#EF4444', '#F87171', '#FCA5A5', '#FECACA', '#B91C1C', '#991B1B'],
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
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#000000'
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontWeight: 700,
                            color: '#000000'
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            fontSize: '12px',
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
            fontSize: '11px',
            fontWeight: 600,
            labels: {
                colors: '#4b5563',
                useSeriesColors: false
            },
            markers: {
                width: 10,
                height: 10,
                radius: 5
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
    cadrePie.render();

    const genderBar = new ApexCharts(document.querySelector("#genderBarChart"), {
        chart: {
            type: 'bar', height: 320,
            toolbar: { show: false },
            background: 'transparent',
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(idx !== undefined){
                        const g = chartContext.w.config.xaxis.categories[idx];
                        if(g){
                            filterGenderEl.value = g;
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        },
        series: [{ name: 'Gender Count', data: [] }],
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
        colors: ['#EC4899'],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.25,
                gradientToColors: ['#F472B6'],
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
            marker: {
                show: true
            }
        }
    });
    genderBar.render();

    // ---------- Map (Leaflet) ----------
    const map = L.map('visitsMap').setView([20,0],2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    let _markers = [], _geocodeCache = {};
    function clearMarkers(){ _markers.forEach(m=>map.removeLayer(m)); _markers = []; }
    function addMarker(lat, lon, popupHtml, record){
        try{
            const mk = L.marker([lat,lon]).addTo(map).bindPopup(popupHtml);
            mk.on('mouseover', ()=> mk.openPopup());
            mk.on('mouseout', ()=> mk.closePopup());
            mk.on('click', ()=> {
                // clicking marker filters by country
                if(record && record.country){
                    filterCountryEl.value = record.country;
                    selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                    applyFilters();
                }
            });
            _markers.push(mk);
            return mk;
        }catch(e){ return null; }
    }
    function buildPopupHtml(r, loc){
        const lines = [];
        lines.push(`<div>`);
        lines.push(`<strong>${r.name || (r.user && r.user.name) || r.staff_number || '-'}</strong>`);
        if(r.designation) lines.push(`<div><em>${r.designation}</em></div>`);
        if(r.purpose) lines.push(`<div>Purpose: ${r.purpose}</div>`);
        if(r.meeting_name) lines.push(`<div>Meeting: ${r.meeting_name}</div>`);
        if(r.city || r.country) lines.push(`<div>Location: ${(r.city||'-')}, ${(r.country||'-')}</div>`);
        if(r.from_date || r.to_date) lines.push(`<div>Dates: ${(r.from_date||'-')} — ${(r.to_date||'-')}</div>`);
        if(r.cadre) lines.push(`<div>Cadre: ${r.cadre}</div>`);
        if(r.sector) lines.push(`<div>Sector: ${r.sector}</div>`);
        if(r.gender) lines.push(`<div>Gender: ${r.gender}</div>`);
        if(loc && loc.display_name) lines.push(`<div style="font-size:0.85em;color:#666;">${loc.display_name}</div>`);
        lines.push(`</div>`);
        return lines.join('');
    }
    function geocodeLocation(q){
        if(!q) return Promise.resolve(null);
        if(_geocodeCache[q]) return Promise.resolve(_geocodeCache[q]);
        return fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(q))
            .then(r => r.json()).then(data => {
                if(data && data.length){
                    _geocodeCache[q] = { lat: parseFloat(data[0].lat), lon: parseFloat(data[0].lon), display_name: data[0].display_name };
                    return _geocodeCache[q];
                }
                _geocodeCache[q] = null; return null;
            }).catch(()=> { _geocodeCache[q] = null; return null; });
    }
    function refreshMap(records){
        clearMarkers();
        if(!records || !records.length) return;
        const promises = records.map(r => new Promise(resolve => {
            const lat = r.latitude || r.lat || r.lat_val || r.latitude_val;
            const lon = r.longitude || r.lon || r.lng || r.lng_val || r.longitude_val;
            if(lat && lon){
                addMarker(lat, lon, buildPopupHtml(r, null), r);
                return resolve();
            }
            let q = '';
            if(r.city) q += r.city + ', ';
            if(r.country) q += r.country;
            if(!q) return resolve();
            geocodeLocation(q).then(loc => { if(loc) addMarker(loc.lat, loc.lon, buildPopupHtml(r, loc), r); setTimeout(resolve, 80); })
                .catch(()=> setTimeout(resolve,80));
        }));
        Promise.all(promises).then(()=> {
            if(_markers.length){
                try { map.fitBounds(L.featureGroup(_markers).getBounds().pad(0.25)); } catch(e){}
            }
        });
    }

    // ---------- Data -> update all charts & table ----------
    function updateAll(records){
        // 1) Month chart: unique officers (or tours) per month
        const monthMap = {};
        records.forEach(r => {
            const m = monthFromDate(r.from_date || r.created_at) || 'Unknown';
            const officerId = r.user_id || r.staff_number || r.name || JSON.stringify(r);
            if(!monthMap[m]) monthMap[m] = new Set();
            monthMap[m].add(officerId);
        });
        const monthKeys = Object.keys(monthMap).sort((a,b)=> monthNames.indexOf(a) - monthNames.indexOf(b));
        monthChart.updateOptions({ xaxis: { categories: monthKeys } });
        monthChart.updateSeries([{ data: monthKeys.map(k => monthMap[k].size) }]);

        // 2) Meetings treemap (purpose)
        const meetingCounts = countBy(records, r => r.purpose || '');
        meetingsTreemap.updateOptions({ series: [{ data: mapToTreemapData(meetingCounts) }] });

        // 3) ITU sectors (only for records with sector)
        const ituCounts = countBy(records.filter(r => r.sector), r => r.sector || '');
        ituPie.updateOptions({ labels: Object.keys(ituCounts) });
        ituPie.updateSeries(Object.values(ituCounts));

        // 4) Levels treemap
        const levelCounts = countBy(records, r => r.level || r.equivalent_rank || '');
        levelsTreemap.updateOptions({ series: [{ data: mapToTreemapData(levelCounts) }] });

        // 5) Age buckets
        const buckets = ['≤30','31-40','41-50','51-60','>60'];
        const ageCounts = { '≤30':0,'31-40':0,'41-50':0,'51-60':0,'>60':0 };
        const thisYear = new Date().getFullYear();
        records.forEach(r => {
            if(r.date_of_birth){
                const by = (new Date(r.date_of_birth)).getFullYear();
                if(!isNaN(by)){
                    const age = thisYear - by;
                    if(age <= 30) ageCounts['≤30']++;
                    else if(age <=40) ageCounts['31-40']++;
                    else if(age <=50) ageCounts['41-50']++;
                    else if(age <=60) ageCounts['51-60']++;
                    else ageCounts['>60']++;
                }
            }
        });
        ageBar.updateOptions({ xaxis: { categories: buckets } });
        ageBar.updateSeries([{ data: buckets.map(b => ageCounts[b]) }]);

        // 6) Cadre pie
        const cadreCounts = countBy(records, r => r.cadre || '');
        cadrePie.updateOptions({ labels: Object.keys(cadreCounts) });
        cadrePie.updateSeries(Object.values(cadreCounts));

        // 7) Gender bar
        const genderCounts = countBy(records, r => r.gender || '');
        const genderCats = Object.keys(genderCounts);
        genderBar.updateOptions({ xaxis: { categories: genderCats } });
        genderBar.updateSeries([{ data: genderCats.map(k => genderCounts[k]) }]);

        // 8) Table
        const tbody = document.querySelector('tbody.table-border-bottom-0');
        tbody.innerHTML = '';
        records.forEach(r => {
            const name = (r.name && r.name.trim()) || (r.user && r.user.name && r.user.name.trim()) || r.staff_number || 'Unknown';
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${name}</td>
                            <td>${r.purpose || '-'}</td>
                            <td>${r.country || '-'}</td>
                            <td>${r.meeting_name || '-'}</td>
                            <td>${(r.level || r.equivalent_rank) || '-'}</td>`;
            tbody.appendChild(tr);
        });

        // 9) Map
        refreshMap(records);
    }

    // ---------- Main filter logic ----------
    function applyFilters(){
        const selMonth = normalizeString(filterMonthEl.value);
        const selPurpose = normalizeString(filterMeetingEl.value);
        const selCountry = normalizeString(filterCountryEl.value);
        const selCadre = normalizeString(filterCadreEl.value);
        const selGender = normalizeString(filterGenderEl.value);
        const selOfficer = normalizeString(officerFilterEl.value);
        const lvl = selectedLevelFilter ? normalizeString(selectedLevelFilter) : null;
        const sector = selectedSectorFilter ? normalizeString(selectedSectorFilter) : null;
        const ageBucket = activeAgeBucket || null;

        filteredData = rawData.filter(r => {
            // month
            if(selMonth){
                const m = monthFromDate(r.from_date || r.created_at) || '';
                if(m !== selMonth) return false;
            }
            // purpose / meeting
            if(selPurpose){
                if(normalizeString(r.purpose || '') !== selPurpose) return false;
            }
            // country
            if(selCountry){
                if(normalizeString(r.country || '') !== selCountry) return false;
            }
            // cadre
            if(selCadre){
                if(normalizeString(r.cadre || '') !== selCadre) return false;
            }
            // gender
            if(selGender){
                if(normalizeString(r.gender || '') !== selGender) return false;
            }
            // officer name
            if(selOfficer){
                const name = normalizeString(r.name || (r.user && r.user.name) || '');
                if(name !== selOfficer) return false;
            }
            // level (from levels treemap click)
            if(lvl){
                const lv = normalizeString(r.level || r.equivalent_rank || '');
                if(lv !== lvl) return false;
            }
            // sector (from ITU slice click)
            if(sector){
                const s = normalizeString(r.sector || '');
                if(s !== sector) return false;
            }
            // age bucket (from age bar click)
            if(ageBucket){
                if(!r.date_of_birth) return false;
                const by = (new Date(r.date_of_birth)).getFullYear();
                if(isNaN(by)) return false;
                const age = (new Date()).getFullYear() - by;
                if(ageBucket === '≤30' && age > 30) return false;
                if(ageBucket === '31-40' && (age < 31 || age > 40)) return false;
                if(ageBucket === '41-50' && (age < 41 || age > 50)) return false;
                if(ageBucket === '51-60' && (age < 51 || age > 60)) return false;
                if(ageBucket === '>60' && age <= 60) return false;
            }
            return true;
        });

        updateAll(filteredData);
    }

    // ---------- Hook up selects ----------
    [filterMonthEl, filterMeetingEl, filterCountryEl, filterCadreEl, filterGenderEl, officerFilterEl].forEach(el => {
        el.addEventListener('change', () => {
            // optional UX: when user uses selects, clear chart-click filters
            selectedLevelFilter = null;
            selectedSectorFilter = null;
            activeAgeBucket = null;
            applyFilters();
        });
    });

    // Clear button
    clearFiltersBtn.addEventListener('click', () => {
        filterMonthEl.value = '';
        filterMeetingEl.value = '';
        filterCountryEl.value = '';
        filterCadreEl.value = '';
        filterGenderEl.value = '';
        officerFilterEl.value = '';
        selectedLevelFilter = null;
        selectedSectorFilter = null;
        activeAgeBucket = null;
        applyFilters();
    });

    // ---------- Initial render ----------
    applyFilters(); // this will call updateAll for full data
});
</script>
@endpush