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
    MasterKitchenInventory,
    ActivityLog,
    LocationWiseInventory
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
        $sess_user_id = session()->get('login_id');
        $role_id = session()->get('user_role');
        // dd($role_id);
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');

        
        if($role_id =='1'){
        $userCount = UsersData::where('is_deleted', '0') -> where('is_approved', '1') ->count();

        // ---------------------------
        $userLocationData = UsersData::where('is_deleted', '0')
        ->where('is_approved', '1')
        ->where('id', $sess_user_id)
        ->pluck('location')
        ->toArray(); 
        $userLocation = [];
        foreach ($userLocationData as $location) {
            $userLocation = array_merge($userLocation, explode(',', $location));
        }
        $MasterInventoryCount = MasterKitchenInventory::where('is_deleted', '0')
        ->whereIn('location_id', $userLocation)
        ->groupBy('location_id')
        ->count();
        // ---------------------------

        $ActivityLogCount = ActivityLog::count();
        $Count = LocationWiseInventory::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('is_deleted', '0')
        ->groupBy('date')
        ->get();

        $LocationWiseInventoryCount = $Count->count();

        $return_data = [
            'status' => 'true',
            'message' => 'Counts retrieved successfully',
            'users_count' => $userCount,
            'master_inventory_count' => $MasterInventoryCount,
            'ActivityLogCount' => $ActivityLogCount,
            'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
            'role_id' => $role_id

        ];
        return view('dashboard',compact('return_data'));

        }else if($role_id =='2'){

        $userCount = UsersData::where('is_deleted', '0')
        ->where('added_by', '2')
        ->where('added_byId', $sess_user_id)
        ->count();

        $alluserCount = UsersData::where('is_deleted', '0')
        ->count();
    
        // ----------------------------

        $userLocationData = UsersData::where('is_deleted', '0')
        ->where('is_approved', '1')
        ->where('id', $sess_user_id)
        ->pluck('location')
        ->toArray(); 
        $userLocation = [];
        foreach ($userLocationData as $location) {
            $userLocation = array_merge($userLocation, explode(',', $location));
        }

        $LocationWiseInventoryCount = LocationWiseInventory::where('is_deleted', '0')
        ->whereIn('location_id', $userLocation)
        ->groupBy('location_id')
        ->count();

        $return_data = [
            'status' => 'true',
            'message' => 'Counts retrieved successfully',
            'users_count' => $userCount,
            'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
            'role_id' => $role_id,
            'alluserCount' => $alluserCount

        ];
        return view('dashboard',compact('return_data'));
    }else if($role_id =='3'){

        $userCount = UsersData::where('is_deleted', '0')
        ->where('added_by', '2')
        ->where('added_byId', $sess_user_id)
        ->count();
        // dd($userCount);

        $alluserCount = UsersData::where('is_deleted', '0')
        ->count();
    
        // ----------------------------

        $userLocationData = UsersData::where('is_deleted', '0')
        ->where('is_approved', '1')
        ->where('id', $sess_user_id)
        ->pluck('location')
        ->toArray(); 
        $userLocation = [];
        foreach ($userLocationData as $location) {
            $userLocation = array_merge($userLocation, explode(',', $location));
        }

        $LocationWiseInventoryCount = LocationWiseInventory::where('is_deleted', '0')
        ->whereIn('location_id', $userLocation)
        ->groupBy('location_id')
        ->count();

        $return_data = [
            'status' => 'true',
            'message' => 'Counts retrieved successfully',
            'users_count' => $userCount,
            'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
            'role_id' => $role_id,
            'alluserCount' => $alluserCount

        ];
        return view('dashboard',compact('return_data'));
        }
        
    }

    public function logout(Request $request)
    {
       
        $request->session()->forget('login_id');
        $request->session()->forget('user_name');

        $request->session()->flush();

        return redirect('/');
    }
}
