<?php

namespace App\Http\Controllers\Admin\LoginRegister;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\LoginRegister\RegisterServices;

class RegisterController extends Controller {
    /**
     * Topic constructor.
     */
    public function __construct()
    {
        $this->service = new RegisterServices();
    }

    public function index()
    {
        $register_user = $this->service->index();
        return view('admin.pages.users.users-list',compact('register_user'));
    }

    public function submitLogin(Request $request) 
    {
        // Define the validation rules
        $rules = [
            'user_name' => 'required|exists:users_data,user_name', // Check if the user_name exists in the users_data table
            'password' => 'required',  // Make sure the password field is required
        ];

        // Define custom validation messages
        $messages = [   
            'user_name.required' => 'Please Enter user_name.',
            'user_name.exists' => 'The provided user_name does not exist.',
            'password.required' => 'Please Enter Password.',
        ];

                // $login_details = UsersData::insert([
            //     'user_name' => $request['user_name'],     
            //     'password' => \Crypt::encryptString(trim($request['password']))
            //     ]);
            

        // Start validation process
        $validation = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validation->fails()) {
            return redirect('login')
                ->withInput()
                ->withErrors($validation);
        }

        try {
            // Fetch user details from the database
            $get_user = UsersData::where('user_name', $request['user_name'])->first();

            if ($get_user) {
                // The username exists, now verify the password
                $password = $request->password;

                // Decrypt the password stored in the database
                $decryptedPassword = Crypt::decryptString($get_user->password);

                // Compare the decrypted password with the input password
                if ($password === $decryptedPassword) {
                    // Store the user data in session
                    $request->session()->put('user_name', $get_user->user_name);
                    $request->session()->put('login_id', $get_user->id);
                    
                    // Return a successful login redirect
                    return redirect(route('dashboard'));  // Change to your dashboard route
                } else {
                    // Invalid password
                    return redirect('login')
                        ->withInput()
                        ->withErrors(['password' => 'These credentials do not match our records.']);
                }
            } else {
                // Invalid username
                return redirect('login')
                    ->withInput()
                    ->withErrors(['user_name' => 'These credentials do not match our records.']);
            }

        } catch (Exception $e) {
            // If there's an exception, redirect to the feedback page with the error message
            return redirect('feedback-suggestions')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }
}