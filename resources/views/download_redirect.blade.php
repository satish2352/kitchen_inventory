<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloading...</title>
    <style>
        /* Loader CSS */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
            flex-direction: column;
        }

        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .message {
            margin-top: 10px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('alert_status') && session('alert_msg'))
            Swal.fire({
                title: "{{ session('alert_status') == 'success' ? 'Success' : 'Error' }}",
                text: "{{ session('alert_msg') }}",
                icon: "{{ session('alert_status') }}",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        @endif
    });
</script>
    <!-- Loader -->
    <div class="loader"></div>
    <div class="message">Downloading your file, please wait...</div>
   

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Convert base64 PDF to a downloadable file
            var pdfBase64 = "{{ $pdfBase64['pdf'] }}";
            var byteCharacters = atob(pdfBase64);
            var byteNumbers = new Uint8Array(byteCharacters.length);
            for (var i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            var pdfBlob = new Blob([byteNumbers], { type: 'application/pdf' });
            var url = URL.createObjectURL(pdfBlob);

            var currentDate = new Date("{{ $pdfBase64['currentDate'] }}"); // Converts string to Date object
            var formattedDate = currentDate.toLocaleDateString('en-GB'); // Formats as DD-MM-YYYY

            var link = document.createElement('a');
            link.href = url;
            link.download = "{{ $pdfBase64['location'] }}_" + formattedDate + "_inventory_history.pdf";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Redirect after a short delay
            setTimeout(function () {
                window.location.href = "{{ route('/dashboard') }}"; // Change this to your actual route
            }, 2000);
        });
    </script>
</body>
</html>

