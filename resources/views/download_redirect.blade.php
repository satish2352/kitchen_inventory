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
            background-color: grey;
            margin: 0;
            flex-direction: column;
        }

        .loader {
            border: 5px solid grey;
            border-top: 5px solid white;
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
            link.download = "{{ $pdfBase64['location'] }}_" + formattedDate + ".pdf";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Redirect after a short delay
            setTimeout(function () {
                window.location.href = "{{ route('/dashboard') }}"; // Change this to your actual route
            }, 1200);
        });
    </script>
    
</body>
</html>

