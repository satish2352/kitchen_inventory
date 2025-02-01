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
	User
};
use Illuminate\Support\Facades\Mail;

class UserRepository
{
    public function getUsersList() {
        $data_location = User::select('id','name','location','role','email','password','created_at','email')
							->where('is_deleted', '0')
							->orderBy('name', 'asc')
							->get();
							
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

		$data_users_data = User::where('users.id', '=', $reuest->locationId)
			->select('users.*')->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		// dd($data_location);
		return $data_location;
	}

    public function addUser($request)
	{
		// dd($request);
		$data =array();
		$user_data = new User();
		$user_data->name = $request['name'];
		$user_data->location = $request['location'];
		$user_data->role = $request['role'];
		$user_data->phone = $request['phone'];
		$user_data->email = $request['email'];
		$user_data->password = $request['password'];
		$user_data->save();
		$last_insert_id = $user_data->id;
// dd($user_data);
        return $last_insert_id;

	}

    public function updateUser($request)
	{
		$user_data = User::where('id',$request['edit_id']) 
						->update([
							'name' => $request['name'],
							'location' => $request['location'],
							'role' => $request['role'],
							'phone' => $request['phone'],
							'email' => $request['email'],
							'password' => $request['password'],
						]);
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

        $student_data = User::find($id);
// dd($student_data);
                // Delete the record from the database
                $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                $student_data->is_deleted = $is_deleted;
                $student_data->save();

        return $student_data;

            // }
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Intern ID Card details not found.',
            // ], 404);

    }
}