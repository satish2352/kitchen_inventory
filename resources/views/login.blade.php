@include('layouts.header')

@yield('content')

<div class="container-fluid p-3">

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
                <label for="exampleInputUsername" class="form-label">User Name</label>
                <input type="text" class="form-control" name='user_name' value='{{ old('user_name') }}'
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
</div>

@extends('layouts.footer')
