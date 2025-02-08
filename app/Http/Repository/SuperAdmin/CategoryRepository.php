<?php
namespace App\Http\Repository\SuperAdmin;

use Illuminate\Database\QueryException;
use DB;
use Illuminate\Support\Carbon;
use Session;
use App\Models\{
	Locations,
	Category,
	Unit
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

        return $last_insert_id;

	}

    public function updateCategory($request)
	{
		$user_data = Category::where('id',$request['edit_id']) 
						->update([
							'category_name' => ucwords(strtolower($request['category_name']))
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

    public function deleteCategory($id)
    {
        $all_data=[];

        $student_data = Category::find($id);

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