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

class UnitRepository
{
    public function getUnitList() {
        $data_location = Unit::select('id','unit_name','created_at'
							)
							->orderBy('unit_name', 'asc')
							->get();
							
		return $data_location;
	}

    public function addLocationCheck($request)
	{
		return Locations::where('location', '=', $request['location'])
			// ->orWhere('u_uname','=',$request['u_uname'])
			->select('id')->get();
	}

    public function editUnit($reuest)
	{

		// $data_district = [];

		$data_users_data = Unit::where('id', '=', $reuest->locationId)
			->select(
				'unit_name','id'
			)->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		return $data_location;
	}

    public function addUnit($request)
	{
		$data =array();
		$location_data = new Unit();
		$location_data->unit_name = $request['unit_name'];
		$location_data->save();
		$last_insert_id = $location_data->id;

        return $last_insert_id;

	}

    public function updateUnit($request)
	{
		$user_data = Unit::where('id',$request['edit_id']) 
						->update([
							'unit_name' => $request['unit_name']
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

    public function deleteUnit($id)
    {
        $all_data=[];

        $student_data = Unit::find($id);

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