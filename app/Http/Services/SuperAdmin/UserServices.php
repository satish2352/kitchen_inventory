<?php
namespace App\Http\Services\SuperAdmin;

use App\Http\Repository\SuperAdmin\UserRepository;


use App\Models\
{ User };
use Carbon\Carbon;
use Config;
use Storage;

class UserServices
{

	protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct() {
        $this->repo = new UserRepository();
    }

    public function index() {
        $data_users = $this->repo->getUsersList();
        // dd($data_users);
        return $data_users;
    }

    public function addUser($request){
        try {

            // $chk_dup = $this->repo->addLocationCheck($request);
            // if(sizeof($chk_dup)>0)
            // {
            //     return ['status'=>'failed','msg'=>'The User name has already been taken.'];
            // }
            // else
            // {
                $last_id = $this->repo->addUser($request);
                // dd($last_id);
                if ($last_id) {
                    return ['status' => 'success', 'msg' => 'User Added Successfully.'];
                } else {
                    return ['status' => 'error', 'msg' => 'User get Not Added.'];
                }  
            // }

        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
            }      
    }

    public function editUser($request) {
        $data_location = $this->repo->editUser($request);
        // dd($data_location);
        return $data_location;
    }

    public function updateUser($request) {
        $user_register_id = $this->repo->updateUser($request);
        return ['status'=>'success','msg'=>'User Updated Successful.'];
    }

    public function deleteUser($id){
        try {
            $delete = $this->repo->deleteUser($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'User Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'User Not Deleted.'];
            }  
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        } 
    }
}    