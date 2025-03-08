<?php
namespace App\Http\Repository\SuperAdmin;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Locations;
use DB;use Illuminate\Database\QueryException;use Illuminate\Support\Carbon;use Session;

class CategoryRepository
{
    public function getCategoryList()
    {
        try {
            $data_location = Category::select('id', 'category_name', 'created_at', 'priority')
                ->where('is_deleted', '0')
                ->orderBy('category_name', 'asc')
                ->paginate(10);
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

    public function editCategory($reuest)
    {
        try {
            $data_users_data = Category::where('id', '=', $reuest->edit_id)
                ->select(
                    'category_name', 'id', 'priority'
                )->get()
                ->toArray();

            $data_location = $data_users_data[0];
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addCategory($request)
    {
        try {
            $location_data                = new Category();
            $location_data->category_name = $request['category_name'];
            $location_data->priority      = $request['priority'];
            $location_data->save();
            $last_insert_id = $location_data->id;

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1119');

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

    public function updateCategory($request)
    {
        try {
            $user_data = Category::where('id', $request['edit_id'])
                ->update([
                    'category_name' => $request['category_name'],
                    'priority'      => $request['priority'],
                ]);

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1120');

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

    public function deleteCategory($id)
    {
        try {
            $all_data = [];

            $student_data = Category::find($id);

            // Delete the record from the database
            $is_deleted               = $student_data->is_deleted == 1 ? 0 : 1;
            $student_data->is_deleted = $is_deleted;
            $student_data->save();

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1121');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();

            return $student_data;
        } catch (\Exception $e) {
            info($e->getMessage());
        }

    }
}
