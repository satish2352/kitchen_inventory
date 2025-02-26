<?php
namespace App\Http\Services\SuperAdmin;

use App\Http\Repository\SuperAdmin\ShoppingListRepository;

class ShoppingListServices
{

    protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct()
    {
        $this->repo = new ShoppingListRepository();
    }

    public function editItem($request)
    {
        try {
            $data_location = $this->repo->editItem($request);
            // dd($data_location);
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addKitchenInventoryBySuperAdmin($request)
    {
        try {

            $pdfBase64 = $this->repo->addKitchenInventoryBySuperAdmin($request);
            // dd($last_id);
            if ($pdfBase64) {
                return ['status' => 'success',
                    'msg'            => 'Shopping List Data Updated Successfully.',
                    'pdfBase64'      => $pdfBase64,
                ];
            } else {
                return ['status' => 'error', 'msg' => 'Shopping List Data get Not Updated.'];
            }

        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    public function updateKitchenInventoryBySuperAdmin($request)
    {
        try {
            $pdfBase64 = $this->repo->updateKitchenInventoryBySuperAdmin($request);
            return [
                'status'    => 'success',
                'msg'       => 'Kitchen Inventory Updated Successfully.',
                'pdfBase64' => $pdfBase64,
            ];
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function deleteItem($id)
    {
        try {
            $delete = $this->repo->deleteItem($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'Kitchen Inventory Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Kitchen Inventory Not Deleted.'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }
}
