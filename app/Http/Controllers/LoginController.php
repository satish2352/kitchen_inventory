<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;  // For decryption
use App\Models\UsersData;
use Session;
use Cookie;

class LoginController extends Controller
{
    public function __construct()
    {
        // Constructor code here if necessary
    }

    public function index(Request $request) 
    {
        return view('login');
    }

    public function submitLogin(Request $request) 
    {
        // Define the validation rules
        $rules = [
            'email' => 'required|exists:users_data,email', // Check if the user_name exists in the users_data table
            'password' => 'required',  // Make sure the password field is required
        ];

        // Define custom validation messages
        $messages = [   
            'email.required' => 'Please Enter email.',
            'email.exists' => 'The provided email does not exist.',
            'password.required' => 'Please Enter Password.',
        ];

        // Start validation process
        $validation = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validation->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validation);
        }

        try {
            // Fetch user details from the database
            $get_user = UsersData::where('email', $request['email'])->first();
            // dd($get_user['password']);
            if ($get_user) {
                // The username exists, now verify the password
                $password = $request->password;

                // Decrypt the password stored in the database
                // $decryptedPassword = Crypt::decryptString($get_user->password);
                $decryptedPassword =$get_user['password'];

                // Compare the decrypted password with the input password
                if ($password == $decryptedPassword) {
                    // Store the user data in session
                    $request->session()->put('email', $get_user['email']);
                    $request->session()->put('login_id', $get_user['id']);
                    $request->session()->put('user_role', $get_user['user_role']);
                    $request->session()->put('location', $get_user['location']);
                    // dd($request->session()->get('login_id'));
                    // Return a successful login redirect
                    // dd("dsdfasfsafgsa");
                    $request->session()->regenerate();
                    return redirect(route('/dashboard'));  // Change to your dashboard route
                   
                } else {
                    // Invalid password

                    return redirect('/')
                        ->withInput()
                        ->withErrors(['password' => 'These credentials do not match our records.']);
                }
            } else {
                // Invalid username
                return redirect('/')
                    ->withInput()
                    ->withErrors(['user_name' => 'These credentials do not match our records.']);
            }

        } catch (Exception $e) {
            // If there's an exception, redirect to the feedback page with the error message
            return redirect('feedback-suggestions')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function logout(Request $request)
    {
        // dd("sadfsadfs");
        $request->session()->forget('login_id');
        $request->session()->forget('user_name');

        $request->session()->flush();

        return redirect('/');
    }
}
