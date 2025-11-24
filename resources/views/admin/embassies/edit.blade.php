@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Edit Embassy</h2>

    <form action="{{ route('admin.embassies.update', $embassy->id) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.embassies.form')
        <button class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
