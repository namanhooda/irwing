<!DOCTYPE html>
<html>
<head>
    <title>Downloading...</title>
</head>
<body>

    <!-- Hidden link for download -->
    <a id="downloadLink" href="{{ $fileUrl }}" download hidden></a>

    <script>
        // Trigger the download
        document.getElementById('downloadLink').click();

        // Redirect after 2 seconds
        setTimeout(function() {
            window.location.href = "{{ $redirectUrl }}";
        }, 1000);
    </script>

    <p>Your sanction memo is downloading... Redirecting...</p>

</body>
</html>
