<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
// For decryption
// use App\Models\UsersData;
use App\Models\{
    Locations,
    Category,
    Unit,
    User,
    UsersData,
    MasterKitchenInventory,
    ActivityLog,
    LocationWiseInventory
};
use Cookie;
use Session;

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

        if ($role_id == '1') {
            $userCount = UsersData::where('is_deleted', '0')->where('is_approved', '1')->where('user_role','<>', 1)->count();

            $MasterInventoryCount = MasterKitchenInventory::leftJoin('locations', 'master_kitchen_inventory.location_id', '=', 'locations.id')
                ->where('master_kitchen_inventory.is_deleted', '0')
                ->where('locations.is_deleted', '0')
                ->distinct('master_kitchen_inventory.location_id')
                ->count('master_kitchen_inventory.location_id');

            $ActivityLogCount = ActivityLog::count();

            $LocationWiseInventoryCount = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
                ->selectRaw('DATE(location_wise_inventory.created_at) as date, COUNT(*) as count')
                ->where('location_wise_inventory.is_deleted', '0')
                ->where('locations.is_deleted', '0')
                // ->whereIn( 'location_id', explode( ',', session()->get( 'locations_all' ) ) )
                ->whereDate('location_wise_inventory.created_at', now()->toDateString())
                ->groupBy('date', 'location_wise_inventory.location_id')
                ->get()
                ->count();

            $CategoryCount = Category::where('is_deleted', '0')->count();
            $LocationCount = Locations::where('is_deleted', '0')->count();

            $return_data = [
                'status' => 'true',
                'message' => 'Counts retrieved successfully',
                'users_count' => $userCount,
                'master_inventory_count' => $MasterInventoryCount,
                'ActivityLogCount' => $ActivityLogCount,
                'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
                'CategoryCount' => $CategoryCount,
                'LocationCount' => $LocationCount,
                'role_id' => $role_id
            ];
            return view('dashboard', compact('return_data'));
        } else if ($role_id == '2') {
            $userCount = UsersData::where('is_deleted', '0')
                ->where('added_byId', $sess_user_id)
                ->count();

            $alluserCount = UsersData::where('is_deleted', '0')
                ->where('added_byId', $sess_user_id)
                ->count();

            $LocationWiseInventoryCount = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
                ->selectRaw('DATE(location_wise_inventory.created_at) as date, COUNT(*) as count')
                ->where('location_wise_inventory.is_deleted', '0')
                ->where('locations.is_deleted', '0')
                ->whereIn('location_wise_inventory.location_id', explode(',', session()->get('locations_all')))
                ->whereDate('location_wise_inventory.created_at', now()->toDateString())
                ->groupBy('date', 'location_wise_inventory.location_id')
                ->get()
                ->count();

            $return_data = [
                'status' => 'true',
                'message' => 'Counts retrieved successfully',
                'users_count' => $userCount,
                'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
                'role_id' => $role_id,
                'alluserCount' => $alluserCount
            ];
            return view('dashboard', compact('return_data'));
        } else if ($role_id == '3') {
            // dd(session()->get( 'locations_all' ));
            // dd(explode( ',', session()->get( 'locations_all' ) ));
            $LocationWiseInventoryCount = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
                ->selectRaw('DATE(location_wise_inventory.created_at) as date, COUNT(*) as count')
                ->where('location_wise_inventory.is_deleted', '0')
                ->where('locations.is_deleted', '0')
                ->whereIn('location_wise_inventory.location_id', explode(',', session()->get('locations_all')))
                ->whereDate('location_wise_inventory.created_at', now()->toDateString())
                ->groupBy('date', 'location_wise_inventory.location_id')
                ->get()
                ->count();

            $return_data = [
                'status' => 'true',
                'message' => 'Counts retrieved successfully',
                'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
            ];
            return view('dashboard', compact('return_data'));
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
