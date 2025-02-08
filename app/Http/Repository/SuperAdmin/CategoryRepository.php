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
	ActivityLog
};
use Illuminate\Support\Facades\Mail;

class CategoryRepository
{
    public function getCategoryList() {
        $data_location = Category::select('id','category_name','created_at'
							)
							->where('is_deleted', '0')
							->orderBy('category_name', 'asc')
							->paginate(10);
							// ->get();
							
		return $data_location;
	}

    public function addLocationCheck($request)
	{
		return Locations::where('location', '=', $request['location'])
			// ->orWhere('u_uname','=',$request['u_uname'])
			->select('id')->get();
	}

    public function editCategory($reuest)
	{

		// $data_district = [];

		$data_users_data = Category::where('id', '=', $reuest->locationId)
			->select(
				'category_name','id'
			)->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		return $data_location;
	}

    public function addCategory($request)
	{
		$data =array();
		$location_data = new Category();
		$location_data->category_name = ucwords(strtolower($request['category_name']));
		$location_data->save();
		$last_insert_id = $location_data->id;

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
				
		$LogMsg= config('constants.SUPER_ADMIN.1119');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();	

        return $last_insert_id;

	}

    public function updateCategory($request)
	{
		$user_data = Category::where('id',$request['edit_id']) 
						->update([
							'category_name' => ucwords(strtolower($request['category_name']))
						]);

						$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
				
		$LogMsg= config('constants.SUPER_ADMIN.1120');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();
		// dd($user_data);
		return $request->edit_id;
	}

    public function deleteCategory($id)
    {
        $all_data=[];

        $student_data = Category::find($id);

                // Delete the record from the database
                $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                $student_data->is_deleted = $is_deleted;
                $student_data->save();

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
				
		$LogMsg= config('constants.SUPER_ADMIN.1121');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();

        return $student_data;

    }
}