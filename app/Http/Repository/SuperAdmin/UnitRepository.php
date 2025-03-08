<?php
namespace App\Http\Repository\SuperAdmin;

use App\Models\ActivityLog;
use App\Models\Locations;
use App\Models\Unit;
use DB;use Illuminate\Database\QueryException;use Illuminate\Support\Carbon;use Session;

class UnitRepository
{
    public function getUnitList()
    {
        try {
            $data_location = Unit::select('id', 'unit_name', 'created_at')
                ->where('is_deleted', '0')
                ->orderBy('unit_name', 'asc')
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

    public function editUnit($reuest)
    {
        try {
            // $data_district = [];

            $data_users_data = Unit::where('id', '=', $reuest->locationId)
                ->select(
                    'unit_name', 'id'
                )->get()
                ->toArray();

            $data_location = $data_users_data[0];
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addUnit($request)
    {
        try {
            $data                     = [];
            $location_data            = new Unit();
            $location_data->unit_name = $request['unit_name'];
            $location_data->save();
            $last_insert_id = $location_data->id;

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1125');

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

    public function updateUnit($request)
    {
        try {
            $user_data = Unit::where('id', $request['edit_id'])
                ->update([
                    'unit_name' => $request['unit_name'],
                ]);

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1126');

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

    public function deleteUnit($id)
    {
        try {
            $all_data = [];

            $student_data = Unit::find($id);

            // Delete the record from the database
            $is_deleted               = $student_data->is_deleted == 1 ? 0 : 1;
            $student_data->is_deleted = $is_deleted;
            $student_data->save();

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1127');

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
