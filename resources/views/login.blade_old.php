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

      @media only screen and (min-width: 320px) and (max-width: 375px) {
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
    <button id="installPWA">Install App</button>


    <div
    
      class="container d-flex justify-content-center align-items-center min-vh-100">
      <div class="form-container">
      <form class="modal-content animate" id="frm_register" method="post" action="{{ route('submitLogin') }}">
      @csrf
          <header>
            <img src="{{ asset('/img/logo.png') }}" width="50px" height="50px" />
            <h2>Log In</h2>
          </header>
          <div class="wrapper">
            <i class="material-icons">alternate_email</i>
            <!-- <input type="text" class="form-control" placeholder="Enter Email Id" name='email'/> -->
            <input type="text" name='email' value="{{ old('email') }}"
                    aria-describedby="usernameHelp" placeholder="Enter your email id">
                    
          </div>
          <div class="error-message">
            @if ($errors->has('email'))
                <?php echo $errors->first('email', ':message'); ?>
             @endif
          </div>
          <div class="wrapper">
            <i class="material-icons">lock</i> 
            <!-- <input id="password" type="password" name="password" placeholder="Password" required /> -->
            <input id="password" type="password" name="password" placeholder="Enter your password">
            <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
          </div>
          <div class="error-message">
          @if ($errors->has('password')) 
          <?php echo $errors->first('password', ':message'); ?> 
          @endif
        </div>
          <button type="submit" class="rounded-3 btn-submit mt-4">
            Submit
          </button>
          <!-- <a href="#">Forgot Your Password</a> -->
        </form>
      </div>
    </div>








  

  <!-- OTP Verification Form -->
  <div class="otp-container" id="otp-container" style="display: none;">
    <div class="alert alert-danger" id="otp-error-message" role="alert">
      Please enter the correct OTP!
    </div>
    <div class="otp-form">
      <h2>Verify OTP</h2>
      <form id="otp-form">
        <div class="otp-input-group">
          <input type="text" class="otp-input" maxlength="1" required>
          <input type="text" class="otp-input" maxlength="1" required>
          <input type="text" class="otp-input" maxlength="1" required>
          <input type="text" class="otp-input" maxlength="1" required>
          <input type="text" class="otp-input" maxlength="1" required>
          <input type="text" class="otp-input" maxlength="1" required>
        </div>
        <button type="submit" class="btn btn-primary btn-custom mt-3">Verify</button>
        <div class="mt-3 text-center">
          <a href="#">Resend OTP</a>
        </div>
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


<!-- <script type="text/javascript">
  // Add custom validation method
$.validator.addMethod("passwordStrength", function(value, element) {
    return this.optional(element) || /^(?=(?:[^a-zA-Z]*[a-zA-Z]){5,})(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
}, "Password must contain at least 5 letters, 1 number, and 1 special character");
    

    // Initialize validation for the add form
    $("#frm_register").validate({
      rules: {
        email: {
          required: true,
          email:true,
          // minlength: 3
        },
        password: {
            required: true
            // minlength: 6,
            // passwordStrength: true
        }
        
      },
      messages: {
        email: {
          required: "Please enter email ID",
          required: "Please Enter valid email Id"
          // minlength: "Category name must be at least 3 characters long"
        },
        password: {
            required: "Password is required"
            // minlength: "Password must be at least 6 characters long",
            // passwordStrength: "Password must contain at least 5 letters, 1 number, and 1 special character"
        }
      },
      errorElement: "span",
      errorClass: "error-text",
      highlight: function (element) {
        $(element).addClass("is-invalid").removeClass("is-valid");
      },
      unhighlight: function (element) {
        $(element).addClass("is-valid").removeClass("is-invalid");
      }
    });

     // Remove error message dynamically when password field is cleared
     $("#password").on("input", function () {
        if ($(this).val().trim() === "") {
            $(this).removeClass("is-invalid is-valid"); // Remove validation styling
            $(this).siblings("span.error-text").remove(); // Remove error message
        }
    });

</script> -->
