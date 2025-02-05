<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;  // For decryption
// use App\Models\UsersData;
use App\Models\ {
    Locations,
    Category,
    Unit,
    User,
    UsersData,
    MasterKitchenInventory
};
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
        $userCount = UsersData::where('is_deleted', '0')->count();
        $MasterInventoryCount = MasterKitchenInventory::where('is_deleted', '0')->count();
        // dd($userCount);
                                // $userCount = UsersData::where('role_id', 2)
                                // ->orWhere('role_id', 3)
                                // ->count();
        $return_data = [
            'status' => 'true',
            'message' => 'Counts retrieved successfully',
            'users_count' => $userCount,
            'master_inventory_count' => $MasterInventoryCount
        ];
        return view('dashboard',compact('return_data'));
    }

    public function logout(Request $request)
    {
       
        $request->session()->forget('login_id');
        $request->session()->forget('user_name');

        $request->session()->flush();

        return redirect('/');
    }
}
