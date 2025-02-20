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

      .error{
        color: red;
        font-size: 14px;
        text-align: left;
        margin-top: 5px;
        font-weight:bold;
      }

      .pwa-button-container {
        position: fixed;
        left: 88%;
        top: 6%;
        transform: translateY(-50%);
      }

/* #installPWA {
    background: linear-gradient(to right, #ff7e5f, #feb47b);
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
    0%, 100% {background: linear-gradient(to right, #ff7e5f, #feb47b);}
    50% {background: linear-gradient(to right, #ff512f, #dd2476);}
}

#installPWA:hover {
    background: linear-gradient(to right, #ff512f, #dd2476);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
} */



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
    0%, 100% {background-color:rgba(108, 230, 210, 0.62);}
    50% {background-color:rgba(81, 255, 0, 0.66);}
}

#installPWA {
    background-color:rgb(106, 95, 255);
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

      /* @media only screen and (min-width: 280px) and (max-width: 375px) {
        .eye_css {
          margin-right: -2rem !important;
        }
        .pwa-button-container {
          left: 56%;
          top: 10%;
        }
      } */

      .pwa-button-new {
    position: fixed;
    top: 10px;
    right: 10px;
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
    0%, 100% { background-color: rgba(108, 230, 210, 0.62); }
    50% { background-color: rgba(81, 255, 0, 0.66); }
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

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <p>{{ session()->get('error') }} </p>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-danger" role="alert">
            <p> {{ session('success') }} </p>
        </div>
    @endif
    

    <!-- <div class="pwa-button-container">
        <button id="installPWA">Install This App</button>
    </div> -->

    <div class="pwa-button-new" @if(isset($localStorageData)) style="displey:none" @endif>
        <button id="installPWA">Install This App</button>
    </div>

    <p id="pwa-status">Checking PWA status...</p>
    <!-- <button id="installPWA">Install this app for a better experience.</button> -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100 position-relative">
    <!-- Install PWA Button -->
    

    <!-- Login Form -->
    <div class="form-container">
        <form class="modal-content animate" id="frm_register" method="post" action="{{ route('submitLogin') }}">
            @csrf
            <header>
                <img src="{{ asset('/img/main_logo.png') }}" width="100%;" />
                <h2>Log In</h2>
            </header>
            <div class="wrapper">
                <i class="material-icons">alternate_email</i>
                <input type="text" name="email" value="{{ old('email') }}"
                       aria-describedby="usernameHelp" placeholder="Enter email id">
            </div>
            <div class="error-message">
                @if ($errors->has('email'))
                    {{ $errors->first('email') }}
                @endif
            </div>
            <div class="wrapper">
                <i class="material-icons">lock</i> 
                <input id="password" type="password" name="password" placeholder="Enter password">
                <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y eye_css" id="togglePassword" style="cursor: pointer;"></i>
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
          <input type="email" class="form-control" id="forget-email" placeholder="Enter your registered email" required>
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
document.addEventListener("DOMContentLoaded", function () {
   document.getElementById('togglePassword').addEventListener('click', function () {
     let passwordField = document.getElementById('password');
      if (passwordField.type === 'password') { passwordField.type = 'text';
         this.classList.remove('fa-eye');
          this.classList.add('fa-eye-slash');
 // Cross-line effect 
 } else {
   passwordField.type = 'password';
    this.classList.remove('fa-eye-slash');
     this.classList.add('fa-eye');
     } });
     }); 
 </script>

<script>
  $(document).ready(function () {
    // Initialize the form validation
    $('#frm_register').validate({
      rules: {
        email: {
          required: true,          // Email field is required
          email: true,             // Must be a valid email format
          maxlength: 255,          // Email cannot be more than 255 characters
        },
        password: {
          required: true,          // Password field is required
          // minlength: 6,            // Password must be at least 6 characters long
        }
      },
      messages: {
        email: {
          required: "Please enter your email address.",             // Custom message for the required rule
          email: "Please enter a valid email address.",              // Custom message for invalid email format
          maxlength: "Email address cannot exceed 255 characters."   // Custom message for maxlength rule
        },
        password: {
          required: "Please enter your password.",                  // Custom message for the required rule
          // minlength: "Password must be at least 6 characters long."  // Custom message for minlength rule
        }
      },
      errorPlacement: function (error, element) {
        // Append error message below the respective input field
        error.insertAfter(element.closest('.wrapper'));
      },
      highlight: function (element, errorClass, validClass) {
        // Highlight the input field with an error
        $(element).closest('.wrapper').addClass('has-error');
      },
      unhighlight: function (element, errorClass, validClass) {
        // Remove the highlight once the input is valid
        $(element).closest('.wrapper').removeClass('has-error');
      }
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("installPWA").click();
  });
</script>


<script>
  let deferredPrompt;

  // if ('getInstalledRelatedApps' in navigator) {
  //   navigator.getInstalledRelatedApps().then((apps) => {
  //     alert(apps)
  //     if (apps.length > 0) {
  //       console.log("PWA is installed!");
  //       $('.pwa-button-new').css('display', 'none');
  //     } else {
  //       console.log("PWA is NOT installed.");
  //       $('.pwa-button-new').css('display', 'block');
  //     }
  //   }).catch((error) => {
  //     console.error("Error checking installed apps:", error);
  //   });
  // } else {
  //   console.log('getInstalledRelatedApps API is not supported.');
  //   $('.pwa-button-new').css('display', 'block');
  // }

 

  window.addEventListener("beforeinstallprompt", (event) => {
    event.preventDefault();
    deferredPrompt = event; // Store the event for later use

    // Enable the install button
    document.getElementById("installPWA").style.display = "block";
  });

  document.getElementById("installPWA").addEventListener("click", () => {
    if (deferredPrompt) {
      deferredPrompt.prompt(); // Show the install prompt
      deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === "accepted") {
          localStorage.setItem('pwaInstalled', 'yes');
          console.log("User accepted the install");
        } else {
          console.log("User dismissed the install");
        }
        deferredPrompt = null; // Reset so it doesn't prompt again
      });
    } 
    // else {
    //   alert("Install prompt is not available right now.");
    // }
  });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.matchMedia('(display-mode: standalone)').matches) {
            document.getElementById('pwa-status').innerText = "PWA is Installed";
        } else {
            document.getElementById('pwa-status').innerText = "PWA is Not Installed";
        }
    });
</script>

<!-- <script>
    // Get value from localStorage
    var localStorageData = localStorage.getItem('pwaInstalled');
    
    // Set the value to the hidden input field (or update global variable)
    document.getElementById('localStorageValue').value = localStorageData;
</script> -->
