@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Information List</h4>
        <a href="{{ route('admin.informations.create') }}" class="btn btn-primary">Add Information</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Manual reorder form -->
    <form action="{{ route('admin.informations.updateOrder') }}" method="POST" id="reorderForm">
        @csrf
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 100px;">Order</th>
                    <th>Title</th>
                    <th>File</th>
                    <th>URL</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($informations as $info)
                <tr>
                    <td>
                        <input type="number" name="positions[{{ $info->id }}]" value="{{ $info->position }}" class="form-control" style="width:80px;">
                    </td>
                    <td>{{ $info->title }}</td>
                    <td>
                        @if($info->file)
                            <a href="{{ asset('uploads/informations/' . $info->file) }}" target="_blank">View PDF</a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($info->url)
                            <a href="{{ $info->url }}" target="_blank">{{ $info->url }}</a>
                        @else
                            —
                        @endif
                    </td>
                    <td style="max-width:300px;overflow:hidden;">{!! Str::limit(strip_tags($info->description), 100) !!}</td>
                    <td>
                        <a href="{{ route('admin.informations.edit', $info->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteInformation({{ $info->id }})">Delete</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No records found.</td></tr>
            @endforelse
            </tbody>
        </table>

        <button type="submit" class="btn btn-success mt-2">Save Order</button>
    </form>

    {{ $informations->links() }}
</div>

<!-- Hidden delete form (reused dynamically) -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteInformation(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/informations/${id}`;
        form.submit();
    }
}
</script>
@endsection
