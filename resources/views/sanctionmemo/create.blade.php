@extends('layoutsBackend.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Tour Report Submission</h5>
            <div class="card-body">
                <form action="{{ route('tour-reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
    <label>Tour ID</label>
    <select name="tour_id" id="meeting_id" class="form-select" required>
        <option value="" disabled {{ request('meeting_id') ? '' : 'selected' }}>Select Meeting</option>
        @foreach($qrps as $qrp)
            <option value="{{ $qrp->id }}" {{ request('meeting_id') == $qrp->id ? 'selected' : '' }}>
                {{ $qrp->meeting_name }}
            </option>
        @endforeach
    </select>
</div>


            <div class="col-md-6 mb-3">
                <label>Staff Number</label>
                <input type="text" class="form-control" value="{{ $autoData['staff_number'] }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Meeting Name</label>
                <input type="text" id="meeting_name" class="form-control" value="{{ $autoData['meeting_name'] ?? '' }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Purpose</label>
                <input type="text" id="purpose" class="form-control" value="{{ $autoData['purpose'] ?? '' }}" readonly>
            </div>


            <div class="col-md-6 mb-3">
                <label>Name & Designation</label>
                <input type="text" class="form-control" value="{{ $autoData['name_designation'] }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Mobile No.</label>
                <input type="text" class="form-control" value="{{ $autoData['mobile_no'] }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="text" class="form-control" value="{{ $autoData['email'] }}" readonly>
            </div>
<div class="col-md-6 mb-3">
    <label>Country</label>
    <input type="text" id="country" class="form-control" value="{{ $autoData['country'] ?? '' }}" readonly>
</div>

<div class="col-md-6 mb-3">
    <label>City</label>
    <input type="text" id="city" class="form-control" value="{{ $autoData['city'] ?? '' }}" readonly>
</div>

            
<div class="col-md-6 mb-3">
    <label>From</label>
    <input type="date" id="from_date" class="form-control" value="{{ $autoData['from_date'] ?? '' }}" readonly>
</div>

<div class="col-md-6 mb-3">
    <label>To</label>
    <input type="date" id="to_date" class="form-control" value="{{ $autoData['to_date'] ?? '' }}" readonly>
</div>

            <div class="col-md-12 mb-3">
                <label>Key Contributions</label>
                <textarea name="key_contributions" class="form-control" rows="3" required></textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label>Follow-up Action Points</label>
                <textarea name="follow_up_action_points" class="form-control" rows="3" required></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Upload Tour Report (PDF)</label>
                <input type="file" name="tour_report_pdf" class="form-control" accept="application/pdf">
            </div>

            <div class="col-md-12 mb-3">
                <label>Presentation</label>
                <textarea name="presentation" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit Report</button>
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
