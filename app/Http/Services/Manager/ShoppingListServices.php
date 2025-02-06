<?php
namespace App\Http\Services\Manager;

use App\Http\Repository\Manager\ShoppingListRepository;


use App\Models\
{ User };
use Carbon\Carbon;
use Config;
use Storage;

class ShoppingListServices
{

	protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct() {
        $this->repo = new ShoppingListRepository();
    }

    public function addKitchenInventoryByManager($request){
        try {

                $last_id = $this->repo->addKitchenInventoryByManager($request);
                // dd($last_id);
                if ($last_id) {
                    return ['status' => 'success', 'msg' => 'Shopping List Data Added Successfully.'];
                } else {
                    return ['status' => 'error', 'msg' => 'Shopping List Data get Not Added.'];
                }  

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
        return ['status'=>'success','msg'=>'Master Kitchen Inventory Updated Successfully.'];
    }

    public function deleteItem($id){
        try {
            $delete = $this->repo->deleteItem($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'Master Kitchen Inventory Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Master Kitchen Inventory Not Deleted.'];
            }  
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        } 
    }
}    