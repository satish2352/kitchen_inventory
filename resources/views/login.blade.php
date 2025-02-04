@include('layouts.header')

@yield('content')

<style>
    
// CSS

/* Body Styling */
body {
  background-color: #f8f9fa;
  font-family: Arial, sans-serif;
}

/* General Container Styling */
.main-container {
  max-width: 500px;
  margin: 50px auto;
  padding: 20px;
}

/* Form Container */
.login-container,
.signup-container,
.otp-container,
.forget-container {
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
  padding: 50px 15px;
}

/* Form Styling */
.login-form,
.signup-form,
.otp-form,
.forget-form {
  background-color: #ffffff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Form Title */
.login-form h2,
.signup-form h2,
.otp-form h2,
.forget-form h2 {
  text-align: center;
  margin-bottom: 20px;
}

/* Form Field Styling */
.form-control,
.otp-input {
  margin-bottom: 15px;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

/* Focused Input Field */
.form-control:focus,
.otp-input:focus {
  border-color: #007bff;
  outline: none;
}

/* Button Styling */
.btn-custom {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

.btn-custom:hover {
  background-color: #0056b3;
}

/* Link Styling */
a {
  color: #007bff;
  text-decoration: none;
}

/* Alert Styling */
.alert {
  display: none;
  padding: 10px;
  background-color: #f8d7da;
  color: #721c24;
  border-radius: 5px;
  margin-bottom: 15px;
}

/* Input Group for OTP */
.otp-input-group {
  display: flex;
  justify-content: center;
  gap: 10px;
}

/* OTP Input Styling */
.otp-input {
  width: 40px;
  height: 50px;
  text-align: center;
  font-size: 18px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.otp-input:focus {
  border-color: #007bff;
  outline: none;
}

.red-text{
    color:red;
}



/* Responsive Design */
@media (max-width: 480px) {
  .container {
    padding: 10px;
  }

  .login-container,
  .signup-container,
  .otp-container,
  .forget-container {
    padding: 30px 10px;
  }

  .otp-input-group {
    flex-wrap: wrap;
    justify-content: space-around;
  }

  .otp-input {
    width: 35px;
    height: 45px;
    font-size: 16px;
  }
}

</style>

<!-- <div class="container-fluid p-3">

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

    <form class="modal-content animate" method="post" action='{{ route('submitLogin') }}'>
        @csrf

        <div class="row">
            <div class="col-sm-12 col-md-12 mb-3">
                <label for="exampleInputUsername" class="form-label">Email</label>
                <input type="text" class="form-control" name='email' value='{{ old('email') }}'
                    aria-describedby="usernameHelp">
            </div>
            @if ($errors->has('email'))
                <span class="red-text"><?php echo $errors->first('email', ':message'); ?></span>
            @endif
            <div class="col-sm-12 col-md-12 mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="passport" type="password" name='password' class="form-control">
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-outline-warning change-password-btn">Change
                Password</button>
        </div>
        @if ($errors->has('password'))
            <span class="red-text"><?php echo $errors->first('password', ':message'); ?></span>
        @endif

        <div class="modal-footer login-modal-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary ok-btn">OK</button>

            <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div> -->


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
<div class="container main-container">
  <!-- Login Form -->
  <div class="login-container" id="login-container">
    <div class="alert alert-danger" id="error-message" role="alert">
      Invalid username or password!
    </div>
    <div class="login-form">
      <h2>Login</h2>
      <!-- <form id="login-form"> -->
    <form class="modal-content animate" method="post" action="{{ route('submitLogin') }}">
    @csrf
        <div class="mb-3">
          <label for="username" class="form-label">Email ID</label>
                <input type="text" class="form-control" name='email' value="{{ old('email') }}"
                    aria-describedby="usernameHelp" placeholder="Enter your email id">
                    @if ($errors->has('email'))
                <span class="red-text"><?php echo $errors->first('email', ':message'); ?></span>
            @endif
        
        </div>
        <div class="mb-3 position-relative"> <label for="password" class="form-label">Password</label> <div class="position-relative"> <input id="password" type="password" name="password" class="form-control pe-5" placeholder="Enter your password"> <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i> </div> @if ($errors->has('password')) <span class="red-text"><?php echo $errors->first('password', ':message'); ?></span> @endif </div>
        <!-- <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" name='password' class="form-control" placeholder="Enter your password">
          @if ($errors->has('password'))
            <span class="red-text"><?php //echo $errors->first('password', ':message'); ?></span>
        @endif
        </div> -->
        <!-- <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember-me">
          <label class="form-check-label" for="remember-me">Remember me</label>
        </div> -->
        <button type="submit" class="btn btn-primary btn-custom">Login</button>
        <div class="mt-3 text-center">
          <a href="#" id="forgot-password-link">Forgot password?</a> 
          <!-- <a href="#" id="register-link">Register</a> -->
        </div>
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
