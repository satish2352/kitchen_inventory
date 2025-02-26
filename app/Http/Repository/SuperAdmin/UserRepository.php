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

	public function getUsersList()
	{
		try {
			$data_location = UsersData::select('id', 'name', 'location', 'user_role', 'email', 'password', 'created_at', 'email', 'phone', 'is_approved', 'added_by', 'user_role')
				->where('is_deleted', '0')
				->where('user_role', '<>', 1)
				->where('is_approved', '1')
				->orderBy('created_at', 'desc')
				->paginate(10);

			// Fetch locations for each user
			$data_location->each(function ($user_data) {
				$locationIds = explode(',', $user_data->location);
				$user_data->locations = Locations::whereIn('id', $locationIds)->pluck('location')->toArray();
			});

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

	public function editUser($reuest)
	{
		try {
			$data_users_data = UsersData::where('users_data.id', '=', $reuest->locationId)
				->select('users_data.*')->get()
				->toArray();

			$data_location = $data_users_data[0];
			return $data_location;
		} catch (\Exception $e) {
			
			info($e->getMessage());
		}

	}

	public function addUser($request)
	{
		try {

			$sess_user_id = session()->get('login_id');
			$sess_user_name = session()->get('user_name');
			$sess_location_id = session()->get('location_selected_id');

			$data = array();
			$user_data = new UsersData();
			$user_data->name = ucwords(strtolower($request['name']));
			$user_data->user_role = $request['role'];
			$user_data->phone = isset($request['phone']) ? $request['phone'] : '1234567890';
			$user_data->email = $request['email'];
			$user_data->password = $request['password'];
			$user_data->added_by = 1;
			$user_data->is_approved = 1;
			$user_data->added_byId = $sess_user_id;
			$user_data->created_at = Carbon::now('America/New_York');

			if ($request->has('location')) {
				$user_data->location = implode(',', $request['location']); // Join values with commas
			}
			$user_data->save();

			try {
				$email_data = [
					'email' => $request['email'],
					'password' => $request['password'],

				];
				$toEmail = $request['email'];
				$senderSubject = 'Credentials for the Buffalo Boss login' . date('d-m-Y H:i:s');
				$fromEmail = env('MAIL_USERNAME');
				Mail::send('user_added_mail', ['email_data' => $email_data], function ($message) use ($toEmail, $fromEmail, $senderSubject) {
					$message->to($toEmail)->subject($senderSubject);
					$message->from($fromEmail, ' Buffalo Boss');
				});

			} catch (\Exception $e) {
				info($e->getMessage());  // Keep dd to see the error in debugging, or just Log it
			}

			$last_insert_id = $user_data->id;

			if ($last_insert_id) {
				$LogMsg = config('constants.SUPER_ADMIN.1113');

				$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
				$ActivityLogData = new ActivityLog();
				$ActivityLogData->user_id = $sess_user_id;
				$ActivityLogData->activity_message = $FinalLogMessage;
				$ActivityLogData->created_at = Carbon::now('America/New_York');
				$ActivityLogData->save();
			}

			return $last_insert_id;

		} catch (\Exception $e) {
			
			info($e->getMessage());
		}

	}

	public function updateUser($request)
	{
		try {
			$locations = implode(',', $request['location']); // Implode the array into a string (e.g., "1,2,3")
			$user_data = UsersData::where('id', $request['edit_id'])
				->update([
					'name' => ucwords(strtolower($request['name'])),
					'location' => $locations,
					'user_role' => $request['role'],
					'phone' => isset($request['phone']) ? $request['phone'] : '1234567890',
					'email' => $request['email'],
					'password' => $request['password'],
					'updated_at' => Carbon::now('America/New_York')

				]);

			$sess_user_id = session()->get('login_id');
			$sess_user_name = session()->get('user_name');
			$sess_location_id = session()->get('location_selected_id');

			$LogMsg = config('constants.SUPER_ADMIN.1114');

			$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
			$ActivityLogData = new ActivityLog();
			$ActivityLogData->user_id = $sess_user_id;
			$ActivityLogData->activity_message = $FinalLogMessage;
			$ActivityLogData->created_at = Carbon::now('America/New_York');
			$ActivityLogData->save();
			// dd($user_data);
			return $request->edit_id;

		} catch (Exception $e) {
			info($e->getMessage());
		}
	}

	public function deleteUser($id)
	{
		try {
			$student_data = UsersData::find($id);
			$is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
			$student_data->is_deleted = $is_deleted;
			$student_data->save();

			$sess_user_id = session()->get('login_id');
			$sess_user_name = session()->get('user_name');

			$LogMsg = config('constants.SUPER_ADMIN.1115');

			$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
			$ActivityLogData = new ActivityLog();
			$ActivityLogData->user_id = $sess_user_id;
			$ActivityLogData->activity_message = $FinalLogMessage;
			$ActivityLogData->created_at = Carbon::now('America/New_York');
			$ActivityLogData->save();
			return $student_data;
		} catch (\Exception $e) {
			
			info($e->getMessage());
		}

	}

	public function getApproveUsers()
	{
		try {
			$data_location = UsersData::select('id', 'name', 'location', 'user_role', 'email', 'password', 'created_at', 'email', 'phone', 'is_approved')
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
		} catch (\Exception $e) {
			
			info($e->getMessage());
		}
	}

	public function updateOne($request)
	{
		try {
			$slide = UsersData::find($request); // Assuming $request directly contains the ID
			if ($slide) {
				$is_active = $slide->is_approved == 1 ? 0 : 1;
				$slide->is_approved = $is_active;
				$slide->save();


				$sess_user_id = session()->get('login_id');
				$sess_user_name = session()->get('user_name');
				$sess_location_id = session()->get('location_selected_id');


				$LogMsg = config('constants.SUPER_ADMIN.1124');

				$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
				$ActivityLogData = new ActivityLog();
				$ActivityLogData->user_id = $sess_user_id;
				$ActivityLogData->activity_message = $FinalLogMessage;
				$ActivityLogData->created_at = Carbon::now('America/New_York');
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
		try {
			$locations = implode(',', $request['location']); // Implode the array into a string (e.g., "1,2,3")
			$user_data = UsersData::where('id', $request['edit_id'])
				->update([
					'name' => ucwords(strtolower($request['name'])),
					'location' => $locations,
					'user_role' => $request['role'],
					'phone' => isset($request['phone']) ? $request['phone'] :'1234567890',
					'email' => $request['email'],
					'password' => $request['password'],
					'updated_at' => Carbon::now('America/New_York')

				]);

			$sess_user_id = session()->get('login_id');
			$sess_user_name = session()->get('user_name');

			$LogMsg = config('constants.SUPER_ADMIN.1114');

			$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
			$ActivityLogData = new ActivityLog();
			$ActivityLogData->user_id = $sess_user_id;
			$ActivityLogData->activity_message = $FinalLogMessage;
			$ActivityLogData->created_at = Carbon::now('America/New_York');
			$ActivityLogData->save();
			return $request->edit_id;
		} catch (\Exception $e) {
			
			info($e->getMessage());
		}
	}

	public function deleteApproveUser($id)
	{
		try {
			$student_data = UsersData::find($id);
			$is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
			$student_data->is_deleted = $is_deleted;
			$student_data->save();

			$sess_user_id = session()->get('login_id');
			$sess_user_name = session()->get('user_name');
			$sess_location_id = session()->get('location_selected_id');

			$LogMsg = config('constants.SUPER_ADMIN.1115');

			$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
			$ActivityLogData = new ActivityLog();
			$ActivityLogData->user_id = $sess_user_id;
			$ActivityLogData->activity_message = $FinalLogMessage;
			$ActivityLogData->created_at = Carbon::now('America/New_York');
			$ActivityLogData->save();

			return $student_data;
		} catch (\Exception $e) {
			
			info($e->getMessage());
		}
	}
}