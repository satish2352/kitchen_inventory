<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\Manager\ShoppingListServices;
use App\Models\ {
    Items,
    Locations,
    LocationWiseInventory,
    MasterKitchenInventory,
    ActivityLog
};
use Session;
use Cookie;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->service = new ShoppingListServices();

    }

    public function getActivityLog() 
{
    $sess_user_id = session()->get('login_id');
    $location_selected_name = session()->get('location_selected_name');
    $location_selected_id = session()->get('location_selected_id');

    $ActiviyLogData = ActivityLog::select('id', 'activity_message', 'created_at')
        ->orderBy('created_at', 'desc') // Optional: Sort by latest first
        ->paginate(10); // Change 10 to the number of items per page
// dd($ActiviyLogData);
    return view('activity', compact('ActiviyLogData'));
}

public function searchActivityLog(Request $request)
{
    $query = $request->input('query');
    $sess_user_id = session()->get('login_id');

    $ActiviyLogData = ActivityLog::select('id', 'activity_message', 'created_at')
            ->where('activity_message', 'like', "%$query%")
        ->orderBy('created_at', 'desc') // Optional: Sort by latest first
        ->paginate(10);


    // Modify the query to search users based on name, email, or phone
    // $ActiviyLogData = UsersData::where('added_byId', $sess_user_id)
    //                  ->where(function ($q) use ($query) {  // Group the OR conditions
    //                      $q->where('name', 'like', "%$query%")
    //                        ->orWhere('email', 'like', "%$query%")
    //                        ->orWhere('phone', 'like', "%$query%");
    //                  })
    //                  ->get();
                   
    // Return the user listing Blade with the search results (no full page reload)
    return view('activity-search-results', compact('ActiviyLogData'))->render();
}


}
