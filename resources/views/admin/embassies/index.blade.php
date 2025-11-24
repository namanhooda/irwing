@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Embassies / Indian Missions</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.embassies.create') }}" class="btn btn-primary">Add New Embassy</a>

        <form method="GET" action="{{ route('admin.embassies.index') }}">
            <input type="text" name="search" id="searchInput"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search country, mission, email...">
        </form>
    </div>

    <table class="table table-bordered" id="embassyTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Country ↑↓</th>
                <th onclick="sortTable(1)">Mission Name ↑↓</th>
                <th onclick="sortTable(2)">Contact Person ↑↓</th>
                <th onclick="sortTable(3)">Email ↑↓</th>
                <th onclick="sortTable(4)">Phone ↑↓</th>
                <th width="150">Actions</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            @foreach($embassies as $e)
            <tr>
                <td>{{ $e->countryData->name }}</td>
                <td>{{ $e->mission_name }}</td>
                <td>{{ $e->contact_person }}</td>
                <td>{{ $e->email }}</td>
                <td>{{ $e->phone }}</td>

                <td>
                    <a href="{{ route('admin.embassies.edit', $e->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.embassies.destroy', $e->id) }}" method="POST"
                          style="display:inline-block">
                        @csrf @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this record?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <div class="mt-3">
        {{ $embassies->links() }}
    </div>

</div>
@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < rows.length; i++) {
            let rowText = rows[i].innerText.toLowerCase();
            rows[i].style.display = rowText.includes(filter) ? "" : "none";
        }
    });

    // Table sorting
    window.sortTable = function (colIndex) {
        let table = document.getElementById("embassyTable");
        let switching = true;
        let dir = "asc";
        let switchcount = 0;

        while (switching) {
            switching = false;
            let rows = table.rows;

            for (let i = 1; i < (rows.length - 1); i++) {
                let shouldSwitch = false;

                let x = rows[i].getElementsByTagName("TD")[colIndex];
                let y = rows[i + 1].getElementsByTagName("TD")[colIndex];

                if (dir === "asc") {
                    if (x.innerText.toLowerCase() > y.innerText.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerText.toLowerCase() < y.innerText.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

});
</script>
@endpush
