<?php
namespace App\Http\Repository\SuperAdmin;

use App\Models\ActivityLog;
use App\Models\Locations;
use Illuminate\Support\Carbon;use Session;

class LocationRepository
{
    public function getLocationList()
    {
        try {
            $data_location = Locations::select('id', 'location')
                ->where('is_deleted', '0')
                ->orderBy('location', 'asc')
                ->paginate(10);
            // ->get();

            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }

    }

    public function addLocationCheck($request)
    {
        try {
            return Locations::where('location', '=', $request['location'])
            // ->orWhere('u_uname','=',$request['u_uname'])
                ->select('id')->get();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function editLocation($reuest)
    {
        try {
            // $data_district = [];

            $data_users_data = Locations::where('locations.id', '=', $reuest->locationId)
                ->select(
                    'locations.location', 'id'
                )->get()
                ->toArray();

            $data_location = $data_users_data[0];
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addLocationInsert($request)
    {
        try {
            $data                    = [];
            $location_data           = new Locations();
            $location_data->location = ucwords(strtolower($request['location']));
            // $location_data->role = $request['role'];
            $location_data->save();
            $last_insert_id = $location_data->id;

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1116');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();

            return $last_insert_id;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateLocation($request)
    {
        try {
            $user_data = Locations::where('id', $request['edit_id'])
                ->update([
                    'location' => ucwords(strtolower($request['location'])),
                ]);

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1117');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();

            return $request->edit_id;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    // public function deleteLocation($id)
    // {
    //     try {
    //         $user = Locations::find($id);
    //         if ($user) {

    //             $user->delete();

    //             return $user;
    //         } else {
    //             return null;
    //         }
    //     } catch (\Exception $e) {
    //         return $e;
    //     }
    // }

    public function deleteLocation($id)
    {
        try {
            $all_data = [];

            $student_data = Locations::find($id);

            // Delete the record from the database
            $is_deleted               = $student_data->is_deleted == 1 ? 0 : 1;
            $student_data->is_deleted = $is_deleted;
            $student_data->save();

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1118');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();

            return $student_data;

            // }
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Intern ID Card details not found.',
            // ], 404);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
