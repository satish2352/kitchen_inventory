<?php
namespace App\Http\Repository\SuperAdmin;

use Illuminate\Database\QueryException;
use DB;
use Illuminate\Support\Carbon;
use Session;
use App\Models\{
	Locations
};
use Illuminate\Support\Facades\Mail;

class LocationRepository
{
    public function getLocationList() {
        $data_location = Locations::select('id','location_name',
								'role'
							)
							->orderBy('location_name', 'asc')
							->get();
							
		return $data_location;
	}

    public function addLocationCheck($request)
	{
		return User::where('location', '=', $request['location'])
			// ->orWhere('u_uname','=',$request['u_uname'])
			->select('id')->get();
	}

    public function editLocation($reuest)
	{

		// $data_district = [];

		$data_users_data = Locations::where('locations.id', '=', base64_decode($reuest->edit_id))
			->select(
				'locations.location',
				'role'
			)->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		return $data_location;
	}

    public function addLocationInsert($request)
	{
		$data =array();
		$location_data = new Locations();
		$location_data->location_name = $request['location_name'];
		$location_data->role = $request['role'];
		$location_data->save();
		$last_insert_id = $location_data->location_id;

        return $last_insert_id;

	}

    public function updateLocation($request)
	{
		$user_data = Locations::where('id',$request['edit_id']) 
						->update([
							'location_name' => $request['location_name'],
							'role' => $request['role']
						]);
		
		return $request->edit_id;
	}

    public function deleteLocation($id)
    {
        try {
            $user = Locations::find($id);
            if ($user) {
              
                $user->delete();
               
                return $user;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}