@extends('layoutsBackend.app')

@section('content')
<div class="container">
    <h2>Add Embassy</h2>

    <form action="{{ route('admin.embassies.store') }}" method="POST">
        @csrf
        @include('admin.embassies.form')
        <button class="btn btn-primary mt-3">Save</button>
    </form>
</div>
@endsection
