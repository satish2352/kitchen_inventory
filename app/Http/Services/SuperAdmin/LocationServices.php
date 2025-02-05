<?php
namespace App\Http\Services\SuperAdmin;

use App\Http\Repository\SuperAdmin\LocationRepository;


use App\Models\
{ User };
use Carbon\Carbon;
use Config;
use Storage;

class LocationServices
{

	protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct() {
        $this->repo = new LocationRepository();
    }

    public function index() {
        $data_location = $this->repo->getLocationList();
        // dd($data_location);
        return $data_location;
    }

    public function addLocation($request){
        try {

            // $chk_dup = $this->repo->addLocationCheck($request);
            // if(sizeof($chk_dup)>0)
            // {
            //     return ['status'=>'failed','msg'=>'The Location name has already been taken.'];
            // }
            // else
            // {
                $last_id = $this->repo->addLocationInsert($request);
                // dd($last_id);
                if ($last_id) {
                    return ['status' => 'success', 'msg' => 'Location Added Successfully.'];
                } else {
                    return ['status' => 'error', 'msg' => 'Location get Not Added.'];
                }  
            // }

        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
            }      
    }

    public function editLocation($request) {
        $data_location = $this->repo->editLocation($request);
        // dd($data_location);
        return $data_location;
    }

    public function updateLocation($request) {
        $user_register_id = $this->repo->updateLocation($request);
        return ['status'=>'success','msg'=>'Location Updated Successfully.'];
    }

    public function deleteLocation($id){
        try {
            $delete = $this->repo->deleteLocation($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'Location Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Location Not Deleted.'];
            }  
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        } 
    }
}    