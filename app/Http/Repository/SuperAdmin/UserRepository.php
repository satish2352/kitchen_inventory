<?php
namespace App\Http\Repository\SuperAdmin;

use Illuminate\Database\QueryException;
use DB;
use Illuminate\Support\Carbon;
use Session;
use App\Models\{
	Locations,
	Category,
	Unit,
	User,
	UsersData,
	ActivityLog
};
use Illuminate\Support\Facades\Mail;

class UserRepository
{

    public function getUsersList() {
        $data_location = UsersData::select('id','name','location','user_role','email','password','created_at','email','phone',
		'is_approved','added_by','user_role')
							->where('is_deleted', '0')
							->orderBy('created_at', 'desc')
							->paginate(10);
							// ->get();

							  // Fetch locations for each user
    $data_location->each(function ($user_data) {
        $locationIds = explode(',', $user_data->location);
        $user_data->locations = Locations::whereIn('id', $locationIds)->pluck('location')->toArray();
    });
							
		return $data_location;
	}

    public function addLocationCheck($request)
	{
		return Locations::where('location', '=', $request['location'])
			// ->orWhere('u_uname','=',$request['u_uname'])
			->select('id')->get();
	}

    public function editUser($reuest)
	{

		// $data_district = [];

		$data_users_data = UsersData::where('users_data.id', '=', $reuest->locationId)
			->select('users_data.*')->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		// dd($data_location);
		return $data_location;
	}

    public function addUser($request)
	{

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');

		// dd($request);
		$data =array();
		$user_data = new UsersData();
		$user_data->name = ucwords(strtolower($request['name']));
		// $user_data->location = $request['location'];
		$user_data->user_role = $request['role'];
		$user_data->phone = $request['phone'];
		$user_data->email = $request['email'];
		$user_data->password = $request['password'];
		$user_data->added_by = 1;
		$user_data->added_byId = $sess_user_id;
		// $user_data->save();

		 // Save selected locations as a comma-separated string
		 if ($request->has('location')) {
			$user_data->location = implode(',', $request['location']); // Join values with commas
		}
		$user_data->save();

		$last_insert_id = $user_data->id;

		if($last_insert_id)
		{
		$LogMsg= config('constants.SUPER_ADMIN.1113');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();
		}

        return $last_insert_id;

	}

    public function updateUser($request)
	{

		$locations = implode(',', $request['location']); // Implode the array into a string (e.g., "1,2,3")
		$user_data = UsersData::where('id',$request['edit_id']) 
						->update([
							'name' => ucwords(strtolower($request['name'])),
							'location' => $locations,
							'user_role' => $request['role'],
							'phone' => $request['phone'],
							'email' => $request['email'],
							'password' => $request['password'],
						]);

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
						
		$LogMsg= config('constants.SUPER_ADMIN.1114');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();
		// dd($user_data);
		return $request->edit_id;
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

    public function deleteUser($id)
    {
        $all_data=[];

        $student_data = UsersData::find($id);
// dd($student_data);
                // Delete the record from the database
                $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                $student_data->is_deleted = $is_deleted;
                $student_data->save();

		// 		if($last_insert_id)
		// {

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');


		$LogMsg= config('constants.SUPER_ADMIN.1115');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();
		// }

        return $student_data;

    }

	public function getApproveUsers() {
        $data_location = UsersData::select('id','name','location','user_role','email','password','created_at','email','phone','is_approved')
							->where('is_deleted', '0')
							->where('added_by', 2)
							->where('is_approved', 0)
							->orderBy('created_at', 'desc')
							->get();

							  // Fetch locations for each user
    $data_location->each(function ($user_data) {
        $locationIds = explode(',', $user_data->location);
        $user_data->locations = Locations::whereIn('id', $locationIds)->pluck('location')->toArray();
    });
							
		return $data_location;
	}

	public function updateOne($request){
        try {
            $slide = UsersData::find($request); // Assuming $request directly contains the ID
// dd($slide);
            // Assuming 'is_active' is a field in the Slider model
            if ($slide) {
                $is_active = $slide->is_approved == 1 ? 0 : 1;
                $slide->is_approved = $is_active;
                $slide->save();


				$sess_user_id = session()->get('login_id');
				$sess_user_name = session()->get('user_name');
				$sess_location_id = session()->get('location_selected_id');


				$LogMsg= config('constants.SUPER_ADMIN.1124');

				$FinalLogMessage = $sess_user_name.' '.$LogMsg;
				$ActivityLogData = new ActivityLog();
				$ActivityLogData->user_id = $sess_user_id;
				$ActivityLogData->activity_message = $FinalLogMessage;
				$ActivityLogData->save();
                return [
                    'msg' => 'User Approved successfully.',
                    'status' => 'success'
                ];
            }

            return [
                'msg' => 'User not found.',
                'status' => 'error'
            ];
        } catch (\Exception $e) {
            return [
                'msg' => 'Failed to Approve User.',
                'status' => 'error'
            ];
        }
    }

	public function updateApproveUserAllData($request)
	{

		$locations = implode(',', $request['location']); // Implode the array into a string (e.g., "1,2,3")
		$user_data = UsersData::where('id',$request['edit_id']) 
						->update([
							'name' => ucwords(strtolower($request['name'])),
							'location' => $locations,
							'user_role' => $request['role'],
							'phone' => $request['phone'],
							'email' => $request['email'],
							'password' => $request['password'],
						]);

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');

		$LogMsg= config('constants.SUPER_ADMIN.1114');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();
		// dd($user_data);
		return $request->edit_id;
	}

	public function deleteApproveUser($id)
    {
        $all_data=[];

        $student_data = UsersData::find($id);
// dd($student_data);
                // Delete the record from the database
                $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                $student_data->is_deleted = $is_deleted;
                $student_data->save();

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
				
		$LogMsg= config('constants.SUPER_ADMIN.1115');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();			

        return $student_data;

            // }
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Intern ID Card details not found.',
            // ], 404);

    }
}