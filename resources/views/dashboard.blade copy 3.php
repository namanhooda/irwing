@extends('layoutsBackend.app')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Readability & layout styles (kept from your original, lightly trimmed) --}}
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        .container-xxl, .card, .table, .form-select, .btn, .card-title, h4 {
            color: #000 !important;
            font-size: 0.95rem;
            line-height: 1.45;
        }
        .card { background: #fff !important; border: 1px solid #e6e9ee !important; box-shadow: 0 1px 3px rgba(16,24,40,0.05); }
        .card-header, .card-title { background: #f5f7fa; color: #000 !important; font-weight: 600; border-bottom: 1px solid #e6e9ee; }
        .table thead th { background: #f8fafc !important; color: #000 !important; border-bottom: 2px solid #e9eef3 !important; }
        .form-select { background: #fff; color: #000 !important; border: 1px solid #ced4da; padding-right: 2.2rem; }
        .btn, .btn-outline-secondary { color: #000 !important; background: #e9eef3; border-color: #d0d7df; }
        .btn.btn-primary { background: #2563eb; border-color: #1d4ed8; color: #fff !important; }
        .sticky-top.bg-white { background: #fff !important; }
        .filter-row .form-select { width: 180px; min-width: 180px; }
        @media (max-width: 768px) {
            .filter-row .form-select { width: 100%; min-width: 100%; }
        }
    </style>

    @php
        $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
    @endphp

    @if($activeRole == 'admin' || $activeRole == 'Officer' || $activeRole == 'Higher Authority')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row g-4 mb-2">
        <div class="col-12">
            <h4 class="mb-0">Dashboard</h4>
        </div>
    </div>

    {{-- FILTER ROW --}}
    <div class="d-flex flex-wrap gap-2 mb-3 filter-row align-items-end">
       <!-- Officer dropdown - Replace previous officer block with this -->
        
    @if($activeRole == 'admin' || $activeRole == 'Higher Authority')
<div class="mb-2" id="officerFilterWrapper" style="position:relative; min-width:170px;">
    <label class="form-label small mb-1">Officer</label>

    <!-- Hidden original select (keeps same id for existing code) -->
    <select id="officerFilter" style="display:none;">
        <option value="">All officers</option>
        @if(isset($officers))
            @foreach($officers as $officer)
                @if(!empty($officer))
                    <option value="{{ $officer }}">{{ $officer }}</option>
                @endif
            @endforeach
        @endif
    </select>

    <!-- Visible custom dropdown (looks like select) -->
    <div class="custom-select" tabindex="0"
         style="border:1px solid #ced4da;border-radius:.375rem;padding:.45rem .6rem;display:flex;align-items:center;justify-content:space-between;cursor:pointer;background:#fff;">
        <span id="officerSelectedText" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">All officers</span>
        <svg width="16" height="16" viewBox="0 0 24 24" style="opacity:.7">
            <path d="M7 10l5 5 5-5z" fill="currentColor"/>
        </svg>
    </div>

    <!-- Dropdown panel -->
    <div id="officerPanel" aria-hidden="true"
         style="position:absolute;z-index:2200;left:0;right:0;margin-top:.35rem;border:1px solid #e6e9ee;border-radius:.375rem;background:#fff;box-shadow:0 8px 20px rgba(2,6,23,.08);max-height:280px;overflow:hidden;display:none;">
        <!-- internal search box inside the dropdown (appears like part of select) -->
        <div style="padding:.4rem;">
            <input id="officerInlineSearch" type="text" placeholder="Search officer..." autocomplete="off"
                   style="width:100%;padding:.45rem .5rem;border:1px solid #e6e9ee;border-radius:.35rem;"/>
        </div>
        <div id="officerList" role="listbox" tabindex="-1" style="max-height:210px;overflow:auto;padding:.25rem;">
            <!-- options will be rendered here -->
        </div>
    </div>
</div>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const realSelect = document.getElementById('officerFilter'); // hidden real select (kept for existing code)
    const wrapper = document.getElementById('officerFilterWrapper');
    const visible = wrapper.querySelector('.custom-select');
    const panel = document.getElementById('officerPanel');
    const search = document.getElementById('officerInlineSearch');
    const listContainer = document.getElementById('officerList');
    const selectedText = document.getElementById('officerSelectedText');
    const clearBtn = document.getElementById('clearFilters'); // existing clear button

    if(!realSelect) return;

    // Build array of options from the real select
    const optionsArr = [];
    for(let i=0;i<realSelect.options.length;i++){
        const o = realSelect.options[i];
        optionsArr.push({ value: o.value, text: o.text });
    }

    // Keep placeholder (value === '') on top, others sorted alphabetically by text
    function sortedOptions(arr){
        const copy = arr.slice();
        // find placeholder
        const phIndex = copy.findIndex(x => String(x.value).trim() === '');
        let placeholder = null;
        if(phIndex > -1) placeholder = copy.splice(phIndex,1)[0];
        copy.sort((a,b)=>{
            const A=a.text.toLowerCase(), B=b.text.toLowerCase();
            if(A < B) return -1;
            if(A > B) return 1;
            return 0;
        });
        if(placeholder) copy.unshift(placeholder);
        return copy;
    }

    const sorted = sortedOptions(optionsArr);

    // Render the list into panel
    function renderList(list){
        listContainer.innerHTML = '';
        if(!list.length){
            const empty = document.createElement('div');
            empty.textContent = 'No matches';
            empty.style.padding = '.5rem';
            empty.style.color = '#6b7280';
            listContainer.appendChild(empty);
            return;
        }
        list.forEach((it, idx) => {
            const row = document.createElement('div');
            row.setAttribute('role','option');
            row.setAttribute('data-value', it.value);
            row.className = 'officer-row';
            row.style.padding = '.45rem .6rem';
            row.style.cursor = 'pointer';
            row.style.borderRadius = '.25rem';
            row.style.whiteSpace = 'nowrap';
            row.style.overflow = 'hidden';
            row.style.textOverflow = 'ellipsis';
            row.textContent = it.text;
            row.addEventListener('mouseenter', ()=> row.style.background = '#f8fafc');
            row.addEventListener('mouseleave', ()=> row.style.background = 'transparent');
            row.addEventListener('click', () => {
                selectValue(it.value, it.text);
                hidePanel();
            });
            listContainer.appendChild(row);
        });
    }

    // Initialize
    renderList(sorted);

    // Current highlighted index for keyboard nav
    let highlightedIndex = -1;
    function clearHighlight(){
        highlightedIndex = -1;
        const rows = listContainer.querySelectorAll('.officer-row');
        rows.forEach(r => r.style.background = 'transparent');
    }
    function highlightAt(i){
        const rows = listContainer.querySelectorAll('.officer-row');
        if(!rows.length) return;
        // clamp
        if(i < 0) i = 0;
        if(i >= rows.length) i = rows.length - 1;
        clearHighlight();
        highlightedIndex = i;
        rows[i].style.background = '#eef2ff'; // light highlight
        // scroll into view
        rows[i].scrollIntoView({ block: 'nearest' });
    }

    // Select value: set hidden select and update visible text and dispatch change
    function selectValue(val, text){
        // set real select value (if option exists)
        const exists = Array.from(realSelect.options).some(o => o.value === val);
        if(!exists){
            // if value is not present, try fallback by text
            const match = Array.from(realSelect.options).find(o => o.text === text);
            if(match) realSelect.value = match.value;
            else realSelect.value = '';
        } else {
            realSelect.value = val;
        }
        // update visible
        selectedText.textContent = text || 'All officers';
        // dispatch change on real select so existing listeners run
        const ev = new Event('change', { bubbles: true });
        realSelect.dispatchEvent(ev);
    }

    // Show / hide panel
    function showPanel(){
        panel.style.display = 'block';
        panel.setAttribute('aria-hidden','false');
        search.focus();
        // select existing value text into view
        const cur = realSelect.value;
        // filter to show current selection near top
        if(cur){
            search.value = '';
            filterList(''); // reset filter
            // find index and scroll
            const rows = Array.from(listContainer.querySelectorAll('.officer-row'));
            const idx = rows.findIndex(r => r.getAttribute('data-value') === cur);
            if(idx >= 0) highlightAt(idx);
        } else {
            search.value = '';
            filterList('');
        }
    }
    function hidePanel(){
        panel.style.display = 'none';
        panel.setAttribute('aria-hidden','true');
        clearHighlight();
        visible.focus();
    }

    // Toggle panel on visible click
    visible.addEventListener('click', function(e){
        if(panel.style.display === 'block') hidePanel(); else showPanel();
    });

    // Close if click outside
    document.addEventListener('click', function(e){
        if(!wrapper.contains(e.target)) hidePanel();
    });

    // Keyboard support on visible
    visible.addEventListener('keydown', function(e){
        if(e.key === 'ArrowDown'){ e.preventDefault(); showPanel(); highlightAt(0); }
        if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); showPanel(); }
    });

    // Filter function (contains match, case-insensitive)
    function filterList(q){
        q = (q || '').trim().toLowerCase();
        if(q === ''){
            renderList(sorted);
            return;
        }
        const filtered = sorted.filter(it => it.text.toLowerCase().indexOf(q) !== -1);
        renderList(filtered);
    }

    // Hook search input
    let searchTimeout = null;
    search.addEventListener('input', function(e){
        const q = e.target.value || '';
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(()=> {
            filterList(q);
            highlightedIndex = -1;
        }, 80);
    });

    // Keyboard navigation inside panel
    panel.addEventListener('keydown', function(e){
        const rows = listContainer.querySelectorAll('.officer-row');
        if(e.key === 'ArrowDown'){
            e.preventDefault();
            if(highlightedIndex < rows.length - 1) highlightAt(highlightedIndex + 1);
        } else if(e.key === 'ArrowUp'){
            e.preventDefault();
            if(highlightedIndex > 0) highlightAt(highlightedIndex - 1);
        } else if(e.key === 'Enter'){
            e.preventDefault();
            if(highlightedIndex >= 0 && rows[highlightedIndex]){
                const val = rows[highlightedIndex].getAttribute('data-value');
                const txt = rows[highlightedIndex].textContent;
                selectValue(val, txt);
                hidePanel();
            }
        } else if(e.key === 'Escape'){
            e.preventDefault();
            hidePanel();
        }
    });

    // When the original hidden select changes externally, sync visible text
    realSelect.addEventListener('change', function(){
        const selOpt = realSelect.options[realSelect.selectedIndex];
        selectedText.textContent = selOpt ? selOpt.text : 'All officers';
    });

    // Initialize visible text from current select value
    (function initSelectedText(){
        const selOpt = realSelect.options[realSelect.selectedIndex];
        selectedText.textContent = selOpt ? selOpt.text : 'All officers';
    })();

    // Clear button behavior: reset the visible control and hidden select
    if(clearBtn){
        clearBtn.addEventListener('click', function(){
            // reset hidden select to placeholder
            const placeholder = Array.from(realSelect.options).find(o => String(o.value).trim() === '');
            if(placeholder) {
                realSelect.value = placeholder.value;
                realSelect.dispatchEvent(new Event('change', { bubbles:true }));
                selectedText.textContent = placeholder.text || 'All officers';
            } else {
                realSelect.value = '';
                realSelect.dispatchEvent(new Event('change', { bubbles:true }));
                selectedText.textContent = 'All officers';
            }
            // close & reset panel
            search.value = '';
            renderList(sorted);
            hidePanel();
        });
    }
});
</script>


    @if($activeRole == 'admin' || $activeRole == 'Higher Authority')
        <div class="mb-2">
            <label class="form-label small mb-1">From</label>
            <input type="date" id="startDate" class="form-control" />
        </div>

        <div class="mb-2">
            <label class="form-label small mb-1">To</label>
            <input type="date" id="endDate" class="form-control" />
        </div>

        <div class="mb-2">
            <label class="form-label small mb-1">Purpose</label>
            <select id="filterMeeting" class="form-select filter-select">
                <option value="">All Purposes</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label small mb-1">Country</label>
            <select id="filterCountry" class="form-select filter-select">
                <option value="">All Countries</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label small mb-1">Cadre</label>
            <select id="filterCadre" class="form-select filter-select">
                <option value="">All Cadres</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label small mb-1">Gender</label>
            <select id="filterGender" class="form-select filter-select">
                <option value="">All Genders</option>
            </select>
        </div>

        <div class="mb-2 ms-auto">
            <button id="clearFilters" class="btn btn-outline-secondary">Clear</button>
        </div>
        @endif
    </div>

    {{-- Charts / Layout (same structure as yours) --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-7 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Month wise visits</h5></div>
                <div class="card-body">
                    <div id="monthWiseVisitsChart"></div>
                    <div class="text-muted mt-2 mb-3" style="font-size: 0.9rem; text-align: right;">Date range applied</div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Types of meetings</h5></div>
                <div class="card-body"><div id="meetingsTreemapChart"></div></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Country and city wise visits (map)</h5></div>
                <div class="card-body"><div id="visitsMap" style="height: 450px;"></div></div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">ITU sectors (only for ITU related visits)</h5></div>
                <div class="card-body d-flex justify-content-center align-items-center"><div id="ituSectorsPieChart"></div></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Levels of officers</h5></div>
                <div class="card-body"><div id="officerLevelsTreemap"></div></div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Age profile</h5></div>
                <div class="card-body"><div id="ageProfileBarChart"></div></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4 col-12">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Cadre of officers</h5></div>
                <div class="card-body d-flex justify-content-center align-items-center"><div id="cadrePieChart"></div></div>
            </div>
        </div>

        <div class="col-md-8 col-12">
            <div class="card h-100">
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
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover">
                        <thead class="sticky-top bg-white">
                            <tr>
                                <th style="width: 6%;">S.No.</th>
                                <th style="width: 28%;">Meeting name</th>
                                <th style="width: 16%;">Country</th>
                                <th style="width: 20%;">Dates</th>
                                <th style="width: 30%;">Name of the Officer</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div> {{-- container end --}}
    @endif



    @if($activeRole == 'nodal')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4 mb-2"><div class="col-12"><h3 class="mb-0">Nodal Dashboard</h3></div></div>
        
        <div class="row g-4">

            <!-- Total Submitted -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center shadow-sm p-3">
                    <h5>Total Submitted Qrps</h5>
                    <h2 class="mt-2 fw-bold">{{ $totalQrps }}</h2>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center shadow-sm p-3">
                    <h5>Pending Qrps</h5>
                    <h2 class="mt-2 fw-bold text-warning">{{ $pendingQrps }}</h2>
                </div>
            </div>

            <!-- Approved -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center shadow-sm p-3">
                    <h5>Approved Qrps</h5>
                    <h2 class="mt-2 fw-bold text-success">{{ $approvedQrps }}</h2>
                </div>
            </div>

            <!-- Rejected -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center shadow-sm p-3">
                    <h5>Rejected Qrps</h5>
                    <h2 class="mt-2 fw-bold text-danger">{{ $rejectedQrps }}</h2>
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
    if(!Array.isArray(rawData)) rawData = [];
    let filteredData = rawData.slice();

    // ---------- Utility helpers ----------
    const monthNamesFull = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    function normalizeString(v){ return v ? String(v).trim() : ''; }

    // Robust parseDate: try Date.parse first; fallback to YYYY-MM-DD parsing
    function parseDate(d){
        if(!d && d !== 0) return null;
        // Already a Date
        if(d instanceof Date) return isNaN(d.getTime()) ? null : d;
        // Try automatic parse
        const try1 = new Date(d);
        if(!isNaN(try1.getTime())) return try1;
        // Try common ISO 'YYYY-MM-DD' or 'YYYY/MM/DD'
        const s = String(d).trim();
        const m = s.match(/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})/);
        if(m){
            const y = parseInt(m[1],10), mo = parseInt(m[2],10)-1, day = parseInt(m[3],10);
            const dd = new Date(y, mo, day);
            return isNaN(dd.getTime()) ? null : dd;
        }
        return null;
    }

    // Overlap logic (Option C): record overlaps selection range
    function overlapsRange(record, selStart, selEnd){
        // If both dates missing, exclude
        const rFrom = parseDate(record.from_date);
        const rTo = parseDate(record.to_date) || rFrom;
        if(!rFrom && !rTo) return false;

        // If user did not set start or end, treat missing as unbounded
        // Convert selStart/selEnd to Date or null
        const start = selStart ? selStart : null;
        const end = selEnd ? selEnd : null;

        // If both start and end are null -> include all
        if(!start && !end) return true;

        // Overlap condition: rFrom <= end AND rTo >= start
        if(start && end){
            return (rFrom <= end) && (rTo >= start);
        } else if(start && !end){
            // range is start..infty -> include if rTo >= start
            return rTo >= start;
        } else if(!start && end){
            // range is -infty..end -> include if rFrom <= end
            return rFrom <= end;
        }
        return false;
    }

    // count by helper
    function countBy(records, keyFn){
        const m = {};
        records.forEach(r => {
            const k = normalizeString(keyFn(r));
            if(!k) return;
            m[k] = (m[k] || 0) + 1;
        });
        return m;
    }
    function mapToTreemapData(obj){ return Object.keys(obj).map(k => ({ x: k, y: obj[k] })); }

    // ---------- DOM elements ----------
    const startDateEl = document.getElementById('startDate');
    const endDateEl = document.getElementById('endDate');
    const filterMeetingEl = document.getElementById('filterMeeting');
    const filterCountryEl = document.getElementById('filterCountry');
    const filterCadreEl = document.getElementById('filterCadre');
    const filterGenderEl = document.getElementById('filterGender');
    const officerFilterEl = document.getElementById('officerFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');

    // chart click state
    let selectedLevelFilter = null;
    let selectedSectorFilter = null;
    let activeAgeBucket = null;

    // ---------- populate selects (purpose, country, cadre, gender) ----------
    function populateSelects(){
        const purposes = new Set();
        const countries = new Set();
        const cadres = new Set();
        const genders = new Set();

        rawData.forEach(r => {
            if(r.purpose) purposes.add(r.purpose);
            if(r.country) countries.add(r.country);
            if(r.cadre) cadres.add(r.cadre);
            if(r.gender) genders.add(r.gender);
        });

        Array.from(purposes).sort().forEach(p => filterMeetingEl.appendChild(new Option(p, p)));
        Array.from(countries).sort().forEach(c => filterCountryEl.appendChild(new Option(c, c)));
        Array.from(cadres).sort().forEach(ca => filterCadreEl.appendChild(new Option(ca, ca)));
        Array.from(genders).sort().forEach(g => filterGenderEl.appendChild(new Option(g, g)));
    }
    populateSelects();

    // Initialize Select2 on selects (make them searchable)
    $(document).ready(function(){
        $('.form-select').select2({ placeholder: 'Select an option', allowClear: true, width: 'resolve' });
        // Ensure date inputs are not turned into select2
        $('#startDate').removeClass('form-select');
        $('#endDate').removeClass('form-select');
    });

    // ---------- ApexCharts setup (use similar options to your prior code) ----------
    const monthChart = new ApexCharts(document.querySelector("#monthWiseVisitsChart"), {
        chart: { type: 'bar', height: 380, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Tours', data: [] }],
        xaxis: { categories: [], labels: { style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 } } },
        colors: ['#10b981'],
        plotOptions: { bar: { borderRadius: 8, columnWidth: '60%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#e2e8f0' },
        tooltip: { theme: 'light' }
    });
    monthChart.render();

    const meetingsTreemap = new ApexCharts(document.querySelector("#meetingsTreemapChart"), {
        chart: { type: 'treemap', height: 380 },
        series: [{ data: [] }],
        plotOptions: { treemap: { distributed: true, enableShades: false } },
        dataLabels: { style: { fontSize: '12px', fontWeight: 600, colors: ['#1E293B'] } }
    });
    meetingsTreemap.render();

    const ituPie = new ApexCharts(document.querySelector("#ituSectorsPieChart"), {
        chart: { type: 'donut', height: 400 },
        labels: [],
        series: [],
        plotOptions: { pie: { donut: { size: '50%' } } },
        legend: { position: 'bottom' },
        dataLabels: { enabled: true }
    });
    ituPie.render();

    const levelsTreemap = new ApexCharts(document.querySelector("#officerLevelsTreemap"), {
        chart: { type: 'treemap', height: 340 },
        series: [{ data: [] }],
        plotOptions: { treemap: { distributed: true } },
        dataLabels: { style: { fontSize: '12px', fontWeight: 600 } }
    });
    levelsTreemap.render();

    const ageBar = new ApexCharts(document.querySelector("#ageProfileBarChart"), {
        chart: { type: 'bar', height: 340, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Age Count', data: [] }],
        xaxis: { categories: [] },
        colors: ['#f59e0b'],
        plotOptions: { bar: { borderRadius: 8, columnWidth: '60%' } },
        dataLabels: { enabled: true }
    });
    ageBar.render();

    const cadrePie = new ApexCharts(document.querySelector("#cadrePieChart"), {
        chart: { type: 'donut', height: 320 },
        labels: [],
        series: [],
        dataLabels: { enabled: true },
        legend: { position: 'bottom' }
    });
    cadrePie.render();

    const genderBar = new ApexCharts(document.querySelector("#genderBarChart"), {
        chart: { type: 'bar', height: 320, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Gender Count', data: [] }],
        xaxis: { categories: [] },
        colors: ['#EC4899'],
        plotOptions: { bar: { borderRadius: 8, columnWidth: '50%' } },
        dataLabels: { enabled: true }
    });
    genderBar.render();

    // ---------- Leaflet map ----------
    const map = L.map('visitsMap').setView([20,0],2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    let _markers = [], _geocodeCache = {};
    function clearMarkers(){ _markers.forEach(m => map.removeLayer(m)); _markers = []; }
    function addMarker(lat, lon, popupHtml, record){
        try{
            const mk = L.marker([lat,lon]).addTo(map).bindPopup(popupHtml);
            mk.on('mouseover', ()=> mk.openPopup());
            mk.on('mouseout', ()=> mk.closePopup());
            mk.on('click', ()=> {
                if(record && record.country){
                    $('#filterCountry').val(record.country).trigger('change');
                    selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                    applyFilters();
                }
            });
            _markers.push(mk);
        }catch(e){}
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

    // ---------- Update functions for all charts ----------
    function updateMonthChart(){
        // group by month-year strings and count unique tours (or records)
        const counts = {};
        filteredData.forEach(r => {
            const d = parseDate(r.from_date);
            if(!d) return;
            const key = monthNamesFull[d.getMonth()] + ' ' + d.getFullYear();
            counts[key] = (counts[key] || 0) + 1;
        });
        const keys = Object.keys(counts).sort((a,b)=>{
            // custom sort: parse month-year to date
            const pa = a.split(' '), pb = b.split(' ');
            const da = new Date(parseInt(pa[1],10), monthNamesFull.indexOf(pa[0]), 1);
            const db = new Date(parseInt(pb[1],10), monthNamesFull.indexOf(pb[0]), 1);
            return da - db;
        });
        const vals = keys.map(k => counts[k]);
        monthChart.updateOptions({ xaxis: { categories: keys } }, false, true);
        monthChart.updateSeries([{ data: vals }]);
    }

    function updateMeetingsTreemap(){
        const meetingCounts = countBy(filteredData, r => r.purpose || r.meeting_name || '');
        meetingsTreemap.updateOptions({ series: [{ data: mapToTreemapData(meetingCounts) }] }, false, true);
    }

    function updateITUChart(){
        const ituCounts = countBy(filteredData.filter(r => r.sector), r => r.sector || '');
        ituPie.updateOptions({ labels: Object.keys(ituCounts) || [] });
        ituPie.updateSeries(Object.values(ituCounts) || []);
    }

    function updateOfficerLevels(){
        const levelCounts = countBy(filteredData, r => r.level || r.equivalent_rank || '');
        levelsTreemap.updateOptions({ series: [{ data: mapToTreemapData(levelCounts) }] });
    }

    function updateAgeProfile(){
        const buckets = ['≤30','31-40','41-50','51-60','>60'];
        const ageCounts = { '≤30':0,'31-40':0,'41-50':0,'51-60':0,'>60':0 };
        const thisYear = (new Date()).getFullYear();
        filteredData.forEach(r => {
            if(!r.date_of_birth) return;
            const by = parseDate(r.date_of_birth);
            if(!by) return;
            const age = thisYear - by.getFullYear();
            if(age <= 30) ageCounts['≤30']++;
            else if(age <=40) ageCounts['31-40']++;
            else if(age <=50) ageCounts['41-50']++;
            else if(age <=60) ageCounts['51-60']++;
            else ageCounts['>60']++;
        });
        const bucketsArr = ['≤30','31-40','41-50','51-60','>60'];
        ageBar.updateOptions({ xaxis: { categories: bucketsArr } }, false, true);
        ageBar.updateSeries([{ data: bucketsArr.map(b => ageCounts[b]) }]);
    }

    function updateCadrePie(){
        const cadreCounts = countBy(filteredData, r => r.cadre || '');
        cadrePie.updateOptions({ labels: Object.keys(cadreCounts) || [] });
        cadrePie.updateSeries(Object.values(cadreCounts) || []);
    }

    function updateGenderBar(){
        const genderCounts = countBy(filteredData, r => r.gender || '');
        const genderCats = Object.keys(genderCounts);
        genderBar.updateOptions({ xaxis: { categories: genderCats } });
        genderBar.updateSeries([{ data: genderCats.map(k => genderCounts[k]) }]);
    }

    function updateTable(){
        const tbody = document.querySelector('tbody.table-border-bottom-0');
        tbody.innerHTML = '';
        filteredData.forEach((r, idx) => {
            const name = (r.name && r.name.trim()) || (r.user && r.user.name && r.user.name.trim()) || r.staff_number || 'Unknown';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${idx + 1}</td>
                <td>${r.meeting_name || '-'}</td>
                <td>${r.country || '-'}</td>
                <td>${r.from_date && r.to_date ? `${r.from_date} - ${r.to_date}` : (r.from_date || r.to_date || '-')}</td>
                <td>${name}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function refreshAll(){
        updateMonthChart();
        updateMeetingsTreemap();
        updateITUChart();
        updateOfficerLevels();
        updateAgeProfile();
        updateCadrePie();
        updateGenderBar();
        refreshMap(filteredData);
        updateTable();
    }

    // ---------- Main filter logic (overlap logic Option C) ----------
    function applyFilters(){
        const selPurpose = normalizeString(filterMeetingEl.value);
        const selCountry = normalizeString(filterCountryEl.value);
        const selCadre = normalizeString(filterCadreEl.value);
        const selGender = normalizeString(filterGenderEl.value);
        const selOfficer = normalizeString(officerFilterEl.value);
        const lvl = selectedLevelFilter ? normalizeString(selectedLevelFilter) : null;
        const sector = selectedSectorFilter ? normalizeString(selectedSectorFilter) : null;
        const ageBucket = activeAgeBucket || null;

        // parse selected start and end dates (HTML date inputs produce YYYY-MM-DD)
        const sd = startDateEl.value ? parseDate(startDateEl.value) : null;
        const ed = endDateEl.value ? parseDate(endDateEl.value) : null;
        // For inclusive behavior, set ed time to end of day if present
        const endInclusive = ed ? new Date(ed.getFullYear(), ed.getMonth(), ed.getDate(), 23, 59, 59, 999) : null;

        filteredData = rawData.filter(r => {
            if(selPurpose){
                if(normalizeString(r.purpose || r.meeting_name || '') !== selPurpose) return false;
            }
            if(selCountry){
                if(normalizeString(r.country || '') !== selCountry) return false;
            }
            if(selCadre){
                if(normalizeString(r.cadre || '') !== selCadre) return false;
            }
            if(selGender){
                if(normalizeString(r.gender || '') !== selGender) return false;
            }
            if(selOfficer){
                const name = normalizeString(r.name || (r.user && r.user.name) || '');
                if(name !== selOfficer) return false;
            }
            if(lvl){
                const lv = normalizeString(r.level || r.equivalent_rank || '');
                if(lv !== lvl) return false;
            }
            if(sector){
                const s = normalizeString(r.sector || '');
                if(s !== sector) return false;
            }
            // age bucket (from age bar click)
            if(ageBucket){
                if(!r.date_of_birth) return false;
                const by = parseDate(r.date_of_birth);
                if(!by) return false;
                const age = (new Date()).getFullYear() - by.getFullYear();
                if(ageBucket === '≤30' && age > 30) return false;
                if(ageBucket === '31-40' && (age < 31 || age > 40)) return false;
                if(ageBucket === '41-50' && (age < 41 || age > 50)) return false;
                if(ageBucket === '51-60' && (age < 51 || age > 60)) return false;
                if(ageBucket === '>60' && age <= 60) return false;
            }

            // Overlap date logic: record.from_date <= selected_end AND record.to_date >= selected_start
            // If no start and no end => always include
            const OK = overlapsRange(r, sd, endInclusive);
            if(!OK) return false;

            return true;
        });

        refreshAll();
    }

    // ---------- Hook up select change events ----------
    [filterMeetingEl, filterCountryEl, filterCadreEl, filterGenderEl, officerFilterEl].forEach(el => {
        el.addEventListener('change', () => {
            selectedLevelFilter = null;
            selectedSectorFilter = null;
            activeAgeBucket = null;
            applyFilters();
        });
    });

    // date inputs
    startDateEl.addEventListener('change', () => { selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null; applyFilters(); });
    endDateEl.addEventListener('change', () => { selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null; applyFilters(); });

    // Clear button resets selects and date inputs
    clearFiltersBtn.addEventListener('click', () => {
        $('#officerFilter').val(null).trigger('change');
        $('#filterMeeting').val(null).trigger('change');
        $('#filterCountry').val(null).trigger('change');
        $('#filterCadre').val(null).trigger('change');
        $('#filterGender').val(null).trigger('change');

        startDateEl.value = '';
        endDateEl.value = '';

        selectedLevelFilter = null;
        selectedSectorFilter = null;
        activeAgeBucket = null;

        filteredData = rawData.slice();
        refreshAll();
    });

    // ---------- Chart click handlers that set filters ----------
    // monthChart click: sets startDate & endDate to month range OR filters by month label
    monthChart.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const label = chartContext.w.config.xaxis.categories[idx];
                        if(label){
                            // label is like "January 2025" -> set from 1st to last day of that month
                            const parts = label.split(' ');
                            const mon = monthNamesFull.indexOf(parts[0]);
                            const yr = parseInt(parts[1],10);
                            if(!isNaN(mon) && !isNaN(yr)){
                                const s = new Date(yr, mon, 1);
                                const e = new Date(yr, mon + 1, 0);
                                // format to yyyy-mm-dd
                                const pad = n => n < 10 ? '0'+n : n;
                                startDateEl.value = `${s.getFullYear()}-${pad(s.getMonth()+1)}-${pad(s.getDate())}`;
                                endDateEl.value = `${e.getFullYear()}-${pad(e.getMonth()+1)}-${pad(e.getDate())}`;
                                // trigger apply
                                applyFilters();
                            }
                        }
                    }
                }
            }
        }
    });

    meetingsTreemap.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const dataPoint = chartContext.w.config.series[0].data[idx];
                        const label = dataPoint?.x || chartContext.w.globals.labels[idx];
                        if(label){
                            $('#filterMeeting').val(label).trigger('change');
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    ituPie.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const label = chartContext.w.config.labels[idx];
                        if(label){
                            selectedSectorFilter = label;
                            // clear selects that would conflict
                            $('#filterMeeting').val(null).trigger('change');
                            $('#startDate').val('');
                            $('#endDate').val('');
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    levelsTreemap.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const label = chartContext.w.config.series[0].data[idx]?.x || chartContext.w.globals.labels[idx];
                        if(label){
                            selectedLevelFilter = label;
                            selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    ageBar.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const bucket = chartContext.w.config.xaxis.categories[idx];
                        if(bucket){
                            activeAgeBucket = bucket;
                            selectedLevelFilter = null; selectedSectorFilter = null;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    cadrePie.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const label = chartContext.w.config.labels[idx];
                        if(label){
                            $('#filterCadre').val(label).trigger('change');
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    genderBar.updateOptions({
        chart: {
            events: {
                dataPointSelection: function(event, chartContext, config){
                    const idx = config.dataPointIndex;
                    if(typeof idx !== 'undefined'){
                        const g = chartContext.w.config.xaxis.categories[idx];
                        if(g){
                            $('#filterGender').val(g).trigger('change');
                            selectedLevelFilter = null; selectedSectorFilter = null; activeAgeBucket = null;
                            applyFilters();
                        }
                    }
                }
            }
        }
    });

    // ---------- Initial render ----------
    // default filteredData is rawData; run the first render
    refreshAll();

}); // DOMContentLoaded
</script>
@endpush
