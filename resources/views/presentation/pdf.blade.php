<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QRP Form PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">QRP Form Details</h2>
    <table>
        <tr><th>Agency</th><td>{{ $form->agency }} {{ $form->agency_other }}</td></tr>
        <tr><th>ITU Type</th><td>{{ $form->itu_type }}</td></tr>
        <tr><th>Meeting Name</th><td>{{ $form->meeting_name }}</td></tr>
        <tr><th>Duration</th><td>{{ $form->meeting_from }} to {{ $form->meeting_to }}</td></tr>
        <tr><th>Country</th><td>{{ $form->country }}</td></tr>
        <tr><th>City</th><td>{{ $form->city }}</td></tr>
        <tr><th>Mode</th><td>{{ $form->mode }}</td></tr>
        <tr><th>Officer</th><td>{{ $form->officer_name }} ({{ $form->designation }})</td></tr>
        <tr><th>Unit / Division</th><td>{{ $form->unit }} / {{ $form->division }}</td></tr>
        <tr><th>Email</th><td>{{ $form->email }}</td></tr>
        <tr><th>Contact</th><td>{{ $form->contact }}</td></tr>
        <tr><th>Justification</th><td>{{ $form->justification }}</td></tr>
        <tr><th>Expected Outcome</th><td>{{ $form->expected_outcome }}</td></tr>
    </table>
</body>
</html>
