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
	Items
};
use Illuminate\Support\Facades\Mail;

class ItemsRepository
{
    public function getItemsList() {
        $data_location = Items::leftJoin('category', 'items.category', '=', 'category.id')
								->leftJoin('units', 'items.unit', '=', 'units.id')
		->select('items.id','items.category','item_name','unit','price','items.created_at','category.category_name','units.unit_name')
							->where('items.is_deleted', '0')
							->orderBy('item_name', 'asc')
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

    public function addItem($request)
	{
		// dd($request);
		$data =array();
		$user_data = new Items();
		$user_data->item_name = $request['item_name'];
		$user_data->category = $request['category'];
		// $user_data->quantity = $request['quantity'];
		$user_data->unit = $request['unit'];
		$user_data->price = $request['price'];
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