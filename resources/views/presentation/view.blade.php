@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Tour Report Submission</h5>
            <div class="card-body">
                <form action="{{ route('tour-reports.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="file">Upload CSV file</label>
    <input type="file" name="file" id="file" accept=".csv" required>
    <button type="submit">Upload</button>
</form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('agency').addEventListener('change', function () {
        document.getElementById('itu_sub').style.display = this.value === 'ITU' ? 'block' : 'none';
    });
    document.getElementById('similar_meeting').addEventListener('change', function () {
        document.getElementById('prev_report').style.display = this.value === 'Yes' ? 'block' : 'none';
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const meetingSelect = document.getElementById('meeting_id');
        const meetingNameInput = document.getElementById('meeting_name');
        const fromDateInput = document.getElementById('from_date');
        const toDateInput = document.getElementById('to_date');
        const countryInput = document.getElementById('country');
        const cityInput = document.getElementById('city');
        const purposeInput = document.getElementById('purpose'); // ✅ new

        meetingSelect.addEventListener('change', function () {
            const meetingId = this.value;

            if (!meetingId) return;

            fetch(`/get-meeting-dates/${meetingId}`)
                .then(response => response.json())
                .then(data => {
                    meetingNameInput.value = data.meeting_name || '';
                    fromDateInput.value = data.from_date || '';
                    toDateInput.value = data.to_date || '';
                    countryInput.value = data.country || '';
                    cityInput.value = data.city || '';
                    purposeInput.value = data.purpose || ''; // ✅ new
                })
                .catch(error => {
                    console.error('Error fetching meeting data:', error);
                    meetingNameInput.value = '';
                    fromDateInput.value = '';
                    toDateInput.value = '';
                    countryInput.value = '';
                    cityInput.value = '';
                    purposeInput.value = ''; // ✅ clear on error
                });
        });
    });

</script>


@endsection
