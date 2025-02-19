<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
// For decryption
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
}
;
use Session;
use Cookie;

class DashboardController extends Controller {
    public function __construct() {
        // Constructor code here if necessary
    }

    public function index( Request $request ) {
        $sess_user_id = session()->get( 'login_id' );
        $role_id = session()->get( 'user_role' );

        if ( $role_id == '1' ) {
            $userCount = UsersData::where( 'is_deleted', '0' )->where( 'is_approved', '1' )->count();

            $MasterInventoryCount = MasterKitchenInventory::where( 'is_deleted', '0' )
            ->distinct( 'location_id' )
            ->count( 'location_id' );

            $ActivityLogCount = ActivityLog::count();

            // $LocationWiseInventoryCount = LocationWiseInventory::select( 'DATE(created_at) as date' )
            // ->distinct( 'location_id' )
            // ->count( 'location_id' );

            $LocationWiseInventoryCount = LocationWiseInventory::selectRaw( 'DATE(created_at) as date, COUNT(*) as count' )
            ->where( 'is_deleted', '0' )
            ->whereIn( 'location_id', explode( ',', session()->get( 'locations_all' ) ) )
            ->groupBy( 'date' )
            ->get()->count();

            $CategoryCount = Category::where( 'is_deleted', '0' )->count();
            $LocationCount = Locations::where( 'is_deleted', '0' )->count();

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
            return view( 'dashboard', compact( 'return_data' ) );

        } else if ( $role_id == '2' ) {

            $userCount = UsersData::where( 'is_deleted', '0' )
            ->where( 'added_byId', $sess_user_id )
            ->count();

            $alluserCount = UsersData::where( 'is_deleted', '0' )->where( 'added_byId', $sess_user_id )
            ->count();

            $LocationWiseInventoryCount = LocationWiseInventory::selectRaw( 'DATE(created_at) as date, COUNT(*) as count' )
            ->where( 'is_deleted', '0' )
            ->whereIn( 'location_id',  explode( ',', session()->get( 'locations_all' ) ) )
            ->groupBy( 'date' )
            ->get()->count();

            $return_data = [
                'status' => 'true',
                'message' => 'Counts retrieved successfully',
                'users_count' => $userCount,
                'LocationWiseInventoryCount' => $LocationWiseInventoryCount,
                'role_id' => $role_id,
                'alluserCount' => $alluserCount

            ];
            return view( 'dashboard', compact( 'return_data' ) );
        } else if ( $role_id == '3' ) {

            $LocationWiseInventoryCount = LocationWiseInventory::selectRaw( 'DATE(created_at) as date, COUNT(*) as count' )
            ->where( 'is_deleted', '0' )
            ->whereIn( 'location_id', explode( ',', session()->get( 'locations_all' ) ) )
            ->groupBy( 'date' )
            ->get()->count();

            $return_data = [
                'status' => 'true',
                'message' => 'Counts retrieved successfully',
                'LocationWiseInventoryCount' => $LocationWiseInventoryCount,

            ];
            return view( 'dashboard', compact( 'return_data' ) );
        }

    }

    public function logout( Request $request ) {

        $request->session()->forget( 'login_id' );
        $request->session()->forget( 'user_name' );

        $request->session()->flush();

        return redirect( '/' );
    }
}
