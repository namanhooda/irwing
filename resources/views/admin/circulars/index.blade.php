@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Circulars</h2>
    <a href="{{ route('admin.circulars.create') }}" class="btn btn-primary mb-3">Add New Circular</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Separate form for order update -->
    <form action="{{ route('admin.circulars.updateOrder') }}" method="POST" id="orderForm">
        @csrf

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width:90px;">Order</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($circulars as $circular)
                    <tr>
                        <td>
                            <input type="number" name="positions[{{ $circular->id }}]" value="{{ $circular->position }}" class="form-control" style="width:80px;">
                        </td>
                        <td>{{ $circular->title }}</td>
                        <td>{{ Str::limit(strip_tags($circular->description), 50) }}</td>
                        <td>
                            @if($circular->url)
                                <a href="{{ $circular->url }}" target="_blank">{{ $circular->url }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ ucfirst($circular->status) }}</td>
                        <td>
                            <a href="{{ route('admin.circulars.edit', $circular->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <!-- Delete handled via JS (no nested form) -->
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteCircular({{ $circular->id }})">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No circulars found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <button type="submit" class="btn btn-success mt-2">Save Order</button>
    </form>

    {{ $circulars->links() }}
</div>

<!-- Hidden delete form -->
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteCircular(id) {
    if (confirm('Are you sure you want to delete this circular?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/circulars/${id}`;
        form.submit();
    }
}
</script>
@endsection
