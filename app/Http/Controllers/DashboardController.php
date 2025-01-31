<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;  // For decryption
use App\Models\UsersData;
use Session;
use Cookie;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Constructor code here if necessary
    }

    public function index(Request $request) 
    {
        
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('login_id');
        $request->session()->forget('user_name');

        $request->session()->flush();

        return redirect('/');
    }
}
