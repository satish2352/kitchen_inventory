<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buffalo Boss Login Details</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        h2 {
            font-size: 24px;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        /* Container for central alignment */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        /* Title Styling */
        h2 {
            font-family: 'Verdana', sans-serif;
            color: #2980b9;
            font-weight: bold;
        }

        /* Styling the link for better visibility */
        .login-link {
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
            word-wrap: break-word;
        }

        /* Button with gradient */
        .button {
            display: inline-block;
            padding: 12px 20px;
            background: linear-gradient(135deg, #6dd5ed 0%, #2980b9 100%);
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        /* Hover effect for button */
        .button:hover {
            background: linear-gradient(135deg, #3498db 0%, #6dd5ed 100%);
            transform: translateY(-2px); /* Lift effect */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Hi, please find the login details for Buffalo Boss</h2>

        <p>Link: <a href="{{env('APP_URL_MAIL')}}" class="login-link">{{env('APP_URL_MAIL')}}</a></p>
        <p>Email for login: {{ $email_data['email'] }}</p>
        <p>Password: {{ $email_data['password'] }}</p>

        <a href="{{env('APP_URL_MAIL')}}" class="button">Go to Login Page</a>
        <h2>Thanks</h2>
        
    </div>

</body>
</html>

