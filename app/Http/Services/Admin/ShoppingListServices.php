<?php
namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\ShoppingListRepository;


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

    public function addKitchenInventoryByAdmin($request){
        try {

                $pdfBase64 = $this->repo->addKitchenInventoryByAdmin($request);
                // dd($last_id);
                if ($pdfBase64) {
                    return ['status' => 'success', 
                            'msg' => 'Shopping List Data Updated Successfully.',
                            'pdfBase64' => $pdfBase64
                        ];
                } else {
                    return ['status' => 'error', 'msg' => 'Shopping List Data get Not Updated.'];
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

    public function updateKitchenInventoryByAdmin($request) {
        $pdfBase64 = $this->repo->updateKitchenInventoryByAdmin($request);
        return [
            'status' => 'success',
            'msg' => 'Master Kitchen Inventory Updated Successfully.',
            'pdfBase64' => $pdfBase64
        ];
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