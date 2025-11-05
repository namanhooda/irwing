@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Front Pages</h5>
            <a href="{{ route('admin.front_pages.create') }}" class="btn btn-primary">Add New</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>File</th>
                        <th>Page Url</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($frontPages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->url }}</td>
                            <td>
                                @if($page->file)
                                    <a href="{{ asset('storage/'.$page->file) }}" target="_blank">View PDF</a>
                                @endif
                            </td>
                            <td>
    <div class="d-flex align-items-center gap-2">
        <input type="text" 
               id="page-url-{{ $page->id }}" 
               value="{{ url('custom-pages/'.$page->id) }}" 
               readonly 
               class="form-control form-control-sm"
               style="width: 220px;">

        <button type="button" 
                class="btn btn-sm btn-outline-primary" 
                onclick="copyUrl({{ $page->id }}, this)">
            Copy
        </button>
    </div>
</td>


                            <td>
                                <span class="badge bg-{{ $page->status ? 'success' : 'danger' }}">
                                    {{ $page->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.front_pages.edit', $page->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.front_pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this page?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function copyUrl(id, btn) {
    const input = document.getElementById(`page-url-${id}`);

    // Use Clipboard API directly — modern & reliable
    navigator.clipboard.writeText(input.value)
        .then(() => {
            // Feedback: show "Copied!"
            const originalText = btn.innerText;
            btn.innerText = 'Copied!';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');

            setTimeout(() => {
                btn.innerText = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
            }, 1500);
        })
        .catch(err => {
            console.error('Clipboard copy failed:', err);
            // Fallback for older browsers
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            alert('URL copied manually!');
        });
}
</script>


@endsection
