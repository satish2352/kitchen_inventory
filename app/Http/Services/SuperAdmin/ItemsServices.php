<?php
namespace App\Http\Services\SuperAdmin;

use App\Http\Repository\SuperAdmin\ItemsRepository;


use App\Models\
{ User };
use Carbon\Carbon;
use Config;
use Storage;

class ItemsServices
{

	protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct() {
        $this->repo = new ItemsRepository();
    }

    public function index() {
        $data_users = $this->repo->getItemsList();
        // dd($data_users);
        return $data_users;
    }

    public function addItem($request){
        try {

            // $chk_dup = $this->repo->addLocationCheck($request);
            // if(sizeof($chk_dup)>0)
            // {
            //     return ['status'=>'failed','msg'=>'The Item name has already been taken.'];
            // }
            // else
            // {
                $last_id = $this->repo->addItem($request);
                // dd($last_id);
                if ($last_id) {
                    return ['status' => 'success', 'msg' => 'Item Added Successfully.'];
                } else {
                    return ['status' => 'error', 'msg' => 'Item get Not Added.'];
                }  
            // }

        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
            }      
    }

    public function editItem($request) {
        $data_location = $this->repo->editItem($request);
        // dd($data_location);
        return $data_location;
    }

    public function updateItem($request) {
        $user_register_id = $this->repo->updateItem($request);
        return ['status'=>'success','msg'=>'Item Updated Successful.'];
    }

    public function deleteItem($id){
        try {
            $delete = $this->repo->deleteItem($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'Item Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Item Not Deleted.'];
            }  
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        } 
    }
}    