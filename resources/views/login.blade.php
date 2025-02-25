@include('layouts.header')

@yield('content')

<style>
    @import url("//fonts.googleapis.com/css?family=Google+Sans:400,500,600,700");
    @import url("https://fonts.googleapis.com/icon?family=Material+Icons");

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        font-weight: 500;
        letter-spacing: 0.3px;
        -webkit-tap-highlight-color: transparent;
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizelegibility;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: #f88383;
    }

    .btn-submit {
        background: linear-gradient(to right, #a80403, #f88383);
    }

    .btn-submit:hover {
        background: #a80403;
    }

    form {
        background-color: white;
        padding: 30px;
        width: 350px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    header {
        text-align: center;
        /* padding: 10px 0; */
    }

    .wrapper {
        display: flex;
        position: relative;
        z-index: 2;
    }

    input {
        width: 100%;
        padding: 10px;
        outline: none;
        border: none;
        font-size: 20px;
        border-bottom: 2px solid gray;
        background-color: transparent;
        padding-left: 40px;
    }

    input:focus {
        border-bottom: linear-gradient(to right, #a80403, #f88383);
    }

    i {
        font-size: 20px !important;
        padding: 10px;
        position: absolute;
    }

    button {
        padding: 10px;
        margin: 10px 0;
        font-size: 18px;
        color: white;
        border: none;
        cursor: pointer;
        position: relative;
        z-index: 2;
    }

    button:hover {
        background-color: #7142ff;
    }

    a {
        text-decoration: none;
        position: relative;
        z-index: 2;
    }

    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .error-message {
        color: red;
        font-size: 14px;
        text-align: left;
        margin-top: 5px;
    }

    .error {
        color: red;
        font-size: 14px;
        text-align: left;
        margin-top: 5px;
        font-weight: bold;
    }

    .pwa-button-container {
        position: fixed;
        left: 88%;
        top: 6%;
        transform: translateY(-50%);
    }

    #installPWA {
        color: white;
        font-size: 16px;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        animation: blink 1s linear infinite;
    }

    @keyframes blink {

        0%,
        100% {
            background-color: rgba(108, 230, 210, 0.62);
        }

        50% {
            background-color: rgba(81, 255, 0, 0.66);
        }
    }

    #installPWA {
        background-color: rgb(106, 95, 255);
    }

    #installPWA:hover {
        background-color: #ff512f;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }



    @media only screen and (min-width: 280px) and (max-width: 375px) {
        form {
            background-color: white;
            padding: 30px;
            width: 250px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .eye_css {
            margin-right: -2rem !important;
        }

        .pwa-button-container {
            left: 44%;
            top: 8%;
        }
    }

    .pwa-button-new {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 1000;
    }

    .session-data {
        position: fixed;
        top: 10px;
        z-index: 1000;
    }

    .pwa-button-new button {
        background-color: rgb(106, 95, 255);
        color: white;
        font-size: 16px;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        animation: blink 1s linear infinite;
    }

    @keyframes blink {

        0%,
        100% {
            background-color: rgba(108, 230, 210, 0.62);
        }

        50% {
            background-color: rgba(81, 255, 0, 0.66);
        }
    }

    .pwa-button-new button:hover {
        background-color: #ff512f;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Adjust for small screens */
    @media only screen and (max-width: 768px) {
        .pwa-button-new {
            top: 5px;
            right: 5px;
        }

        .pwa-button-new button {
            font-size: 14px;
            padding: 10px 15px;
        }
    }
</style>

@if (isset($return_data['msg_alert']) && $return_data['msg_alert'] == 'green')
    <div class="alert alert-success" role="alert">
        {{ $return_data['msg'] }}
    </div>
@endif

<div class="session-data">
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <p>{{ session()->get('error') }} </p>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <p> {{ session('success') }} </p>
        </div>
    @endif
</div>

<div class="pwa-button-new">
    <button id="installPWA">Install This App</button>
</div>


<div class="container d-flex justify-content-center align-items-center min-vh-100 position-relative">
    <div class="form-container">
        <form class="modal-content animate" id="frm_register" method="post" action="{{ route('submitLogin') }}">
            @csrf
            <header>
                <img src="{{ asset('/img/main_logo.png') }}" width="100%;" />
                <h2>Log In</h2>
            </header>
            <div class="wrapper">
                <i class="material-icons">alternate_email</i>
                <input type="text" name="email" value="{{ old('email') }}" aria-describedby="usernameHelp"
                    placeholder="Enter Email ID">
            </div>
            <div class="error-message">
                @if ($errors->has('email'))
                    {{ $errors->first('email') }}
                @endif
            </div>
            <div class="wrapper">
                <i class="material-icons">lock</i>
                <input id="password" type="password" name="password" placeholder="Enter Password">
                <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y eye_css" id="togglePassword"
                    style="cursor: pointer;"></i>
            </div>
            <div class="error-message">
                @if ($errors->has('password'))
                    {{ $errors->first('password') }}
                @endif
            </div>
            <button type="submit" class="rounded-3 btn-submit mt-4">Submit</button>
        </form>
    </div>
</div>

<!-- Forgot Password Form -->
<div class="forget-container" id="forget-container" style="display: none;">
    <div class="alert alert-danger" id="forget-error-message" role="alert">
        Please enter a valid email address!
    </div>
    <div class="forget-form">
        <h2>Forgot Password</h2>
        <form id="forget-form">
            <div class="mb-3">
                <label for="forget-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="forget-email" placeholder="Enter your registered email"
                    required>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">Reset Password</button>
            <div class="mt-3 text-center">
                <a href="#" id="back-to-login-from-forget-link">Back to Login</a>
            </div>
        </form>
    </div>
</div>
</div>

@extends('layouts.footer')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('togglePassword').addEventListener('click', function() {
            let passwordField = document.getElementById('password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
                // Cross-line effect 
            } else {
                passwordField.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Initialize the form validation
        $('#frm_register').validate({
            rules: {
                email: {
                    required: true, // Email field is required
                    email: true, // Must be a valid email format
                    maxlength: 255, // Email cannot be more than 255 characters
                },
                password: {
                    required: true, // Password field is required
                    // minlength: 6,            // Password must be at least 6 characters long
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address.", // Custom message for the required rule
                    email: "Please enter a valid email address.", // Custom message for invalid email format
                    maxlength: "Email address cannot exceed 255 characters." // Custom message for maxlength rule
                },
                password: {
                    required: "Please enter your password.", // Custom message for the required rule
                    // minlength: "Password must be at least 6 characters long."  // Custom message for minlength rule
                }
            },
            errorPlacement: function(error, element) {
                // Append error message below the respective input field
                error.insertAfter(element.closest('.wrapper'));
            },
            highlight: function(element, errorClass, validClass) {
                // Highlight the input field with an error
                $(element).closest('.wrapper').addClass('has-error');
            },
            unhighlight: function(element, errorClass, validClass) {
                // Remove the highlight once the input is valid
                $(element).closest('.wrapper').removeClass('has-error');
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("installPWA").click();
    });
</script>

<!-- <script>
    let deferredPrompt;

    document.addEventListener("DOMContentLoaded", function() {
                const installButton = document.getElementById("installPWA");
                // const iosInstructions = document.getElementById("iosInstructions");
                const shareButton = document.getElementById("shareButton");

                // function isIOS() {
                //     return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                // }

                function isPWAInstalled() {
                    return window.matchMedia('(display-mode: standalone)').matches || localStorage.getItem(
                        'pwaInstalled') === 'yes';
                }

                if (isPWAInstalled()) {
                    installButton.style.display = "none";
                    // iosInstructions.style.display = "none";
                    // } else if (isIOS()) {
                    //     iosInstructions.style.display = "block"; // Show iOS instructions
                    // } 
                    else {
                        // Listen for the beforeinstallprompt event (for Android/Chrome)
                        window.addEventListener("beforeinstallprompt", (event) => {
                            event.preventDefault();
                            deferredPrompt = event;
                            installButton.style.display = "block"; // Show install button
                        });

                        // Handle install button click
                        installButton.addEventListener("click", () => {
                            if (deferredPrompt) {
                                deferredPrompt.prompt();
                                deferredPrompt.userChoice.then((choiceResult) => {
                                    if (choiceResult.outcome === "accepted") {
                                        localStorage.setItem('pwaInstalled', 'yes');
                                        console.log("User accepted the install");
                                        installButton.style.display = "none"; // Hide button immediately
                                    } else {
                                        console.log("User dismissed the install");
                                    }
                                    deferredPrompt = null;
                                });
                            }
                        });
                    }

                    // Listen for the appinstalled event
                    window.addEventListener("appinstalled", () => {
                        console.log("PWA was installed");
                        localStorage.setItem('pwaInstalled', 'yes');
                        installButton.style.display = "none";
                    });

                    // iOS Share Button Handling
                    if (navigator.share) {
                        shareButton.addEventListener("click", () => {
                            navigator.share({
                                title: document.title,
                                url: window.location.href
                            }).catch((error) => console.log("Sharing failed", error));
                        });
                    } else {
                        shareButton.style.display = "none"; // Hide button if not supported
                    }
                });
</script> -->




<script>
    let deferredPrompt;

    document.addEventListener("DOMContentLoaded", function() {
        const installButton = document.getElementById("installPWA");

        // Check if the PWA is already installed
        if (window.matchMedia('(display-mode: standalone)').matches || localStorage.getItem('pwaInstalled') ===
            'yes') {
            installButton.style.display = "none"; // Hide button if PWA is installed
        }

        // Listen for the beforeinstallprompt event
        window.addEventListener("beforeinstallprompt", (event) => {
            event.preventDefault();
            deferredPrompt = event; // Store the event for later use
            installButton.style.display = "block"; // Show install button
        });

        // Handle install button click
        installButton.addEventListener("click", () => {
            if (deferredPrompt) {
                deferredPrompt.prompt(); // Show the install prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === "accepted") {
                        localStorage.setItem('pwaInstalled', 'yes');
                        console.log("User accepted the install");
                        installButton.style.display = "none"; // Hide button immediately
                    } else {
                        console.log("User dismissed the install");
                    }
                    deferredPrompt = null;
                });
            }
        });

        // Listen for the appinstalled event
        window.addEventListener("appinstalled", () => {
            console.log("PWA was installed");
            localStorage.setItem('pwaInstalled', 'yes');
            installButton.style.display = "none"; // Hide button immediately after install
        });
    });
</script>
