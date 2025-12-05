@extends('layoutsBackend.app')

@section('content')
<div class="container">

    <h2>Country Profiles</h2>

    <a href="{{ route('admin.country_profiles.create') }}" class="btn btn-primary mb-3">
        Add Country Profile
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Country</th>
                <th>Capital</th>
                <th>Language</th>
                <th>Currency</th>
                <th>Flag</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profiles as $profile)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $profile->country->name }}</td>
                <td>{{ $profile->capital }}</td>
                <td>{{ $profile->official_language }}</td>
                <td>{{ $profile->currency }}</td>

                <td>
                    @if($profile->flag_image)
                        <img src="{{ asset($profile->flag_image) }}" width="50">
                    @else
                        <span class="text-muted">No flag</span>
                    @endif
                </td>

                <td>
                    @if($profile->profile_document)
                        <a href="{{ asset($profile->profile_document) }}" target="_blank" class="btn btn-sm btn-info">
                            View PDF
                        </a>
                    @else
                        <span class="text-muted">No file</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.country_profiles.edit',$profile->id) }}" 
                       class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('admin.country_profiles.destroy',$profile->id) }}" 
                          method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this profile?')" 
                                class="btn btn-danger btn-sm">
                                Delete
                        </button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
