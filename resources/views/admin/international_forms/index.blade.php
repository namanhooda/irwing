@extends('layoutsBackend.app')
@section('content')



<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>International Forms</span>
            <a href="{{ route('international_forms.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add Data</span>
            </a>

        </h5>
        <div class="card-datatable table-responsive">
            <div class="table-responsive">
                <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($forms as $form)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $form->title }}</td>
                <td>
                    @if($form->url)
                        <a href="{{ $form->url }}" target="_blank">Open</a>
                    @endif
                </td>
                <td>
                    <a href="{{ route('international_forms.edit',$form->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('international_forms.destroy',$form->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
            </div>
        </div>
        <!-- Offcanvas to add new user -->

    </div>
</div>
@endsection
