<?php
namespace App\Http\Repository\SuperAdmin;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\MasterKitchenInventory;
use App\Models\Unit;
use Session;

class MasterKitchenInventoryRepository
{
    public function getItemsList()
    {
        try {
            $location_selected_id = session()->get('location_selected_id');
            $sess_user_id         = session()->get('login_id');

            $data_location = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
                ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
                ->leftJoin('locations', 'master_kitchen_inventory.location_id', '=', 'locations.id')
                ->select(
                    'master_kitchen_inventory.id',
                    'master_kitchen_inventory.category',
                    'master_kitchen_inventory.item_name',
                    'master_kitchen_inventory.unit',
                    'master_kitchen_inventory.price',
                    'master_kitchen_inventory.quantity',
                    'master_kitchen_inventory.created_at',
                    'master_kitchen_inventory.priority',
                    'category.category_name',
                    'units.unit_name',
                    'locations.location'
                )
                ->where('master_kitchen_inventory.is_deleted', '0')
                ->where('category.is_deleted', '0')
                ->where('master_kitchen_inventory.location_id', $location_selected_id)
                ->orderBy('category.priority', 'asc')
                ->orderBy('master_kitchen_inventory.priority', 'asc')
                ->get()
                ->groupBy('category_name');

            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function editItem($reuest)
    {
        try {
            $data_users_data = MasterKitchenInventory::where('master_kitchen_inventory.id', '=', $reuest->locationId)
                ->select('master_kitchen_inventory.*')
                ->get()
                ->toArray();

            $data_location = $data_users_data[0];
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addItem($request)
    {
        try {
            $data                   = [];
            $user_data              = new MasterKitchenInventory();
            $user_data->item_name   = $request['item_name'];
            $user_data->category    = $request['category'];
            $user_data->unit        = $request['unit'];
            $user_data->price       = $request['price'];
            $user_data->location_id = $request['location_id'];
            $user_data->quantity    = $request['quantity'];
            $user_data->priority    = $request['priority'];

            $user_data->save();
            $last_insert_id = $user_data->id;

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1111');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();

            return $last_insert_id;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateItem($request)
    {
        try {
            $user_data = MasterKitchenInventory::where('id', $request['edit_id'])
                ->update([
                    'item_name'   => $request['item_name'],
                    'category'    => $request['category'],
                    'unit'        => $request['unit'],
                    'price'       => $request['price'],
                    'location_id' => $request['location_id'],
                    'quantity'    => $request['quantity'],
                    'priority'    => $request['priority'],
                ]);

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1122');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();
            return $request->edit_id;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function deleteItem($id)
    {
        try {
            $all_data = [];

            $student_data             = MasterKitchenInventory::find($id);
            $is_deleted               = $student_data->is_deleted == 1 ? 0 : 1;
            $student_data->is_deleted = $is_deleted;
            $student_data->save();

            $sess_user_id     = session()->get('login_id');
            $sess_user_name   = session()->get('user_name');
            $sess_location_id = session()->get('location_selected_id');

            $LogMsg = config('constants.SUPER_ADMIN.1123');

            $FinalLogMessage                   = $sess_user_name . ' ' . $LogMsg;
            $ActivityLogData                   = new ActivityLog();
            $ActivityLogData->user_id          = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();

            return $student_data;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function copyMasterInventory($request)
    {
        try {
            $data_master_inventory_data = MasterKitchenInventory::where('master_kitchen_inventory.location_id', '=', $request->from_location_id)
                ->where('master_kitchen_inventory.is_deleted', '=', '0')
                ->select('master_kitchen_inventory.*')
                ->get()
                ->toArray();

            $data_master_inventory_to_location = MasterKitchenInventory::where('master_kitchen_inventory.location_id', '=', $request->to_location_id)
                ->where('master_kitchen_inventory.is_deleted', '=', '0')
                ->select('master_kitchen_inventory.*')
                ->get()
                ->toArray();

            if (empty($data_master_inventory_data)) {
                session()->flash('alert_status', 'error');
                session()->flash('alert_msg', 'No inventory data found for the selected From Location.');
                return ['status' => 'error', 'msg' => 'No inventory data found for the selected From Location.'];
            } else {
                $existingItemIds = array_column($data_master_inventory_to_location, 'item_name');

                $filteredInventoryData = array_filter($data_master_inventory_data, function ($item) use ($existingItemIds) {
                    return ! in_array($item['item_name'], $existingItemIds);
                });

                $filteredInventoryData = array_values($filteredInventoryData);

                if (empty($filteredInventoryData)) {
                    session()->flash('alert_status', 'error');
                    session()->flash('alert_msg', 'All data from the From Location has already been inserted into the To Location data.');
                    return ['status' => 'error', 'msg' => 'All data from the From Location has already been inserted into the To Location data..'];
                } else {
                    foreach ($filteredInventoryData as $index => $inventoryData) {
                        $user_data              = new MasterKitchenInventory();
                        $user_data->item_name   = $inventoryData['item_name'];
                        $user_data->category    = $inventoryData['category'];
                        $user_data->unit        = $inventoryData['unit'];
                        $user_data->price       = $inventoryData['price'];
                        $user_data->location_id = $request->to_location_id;
                        $user_data->quantity    = $inventoryData['quantity'];
                        $user_data->save();
                    }

                    // Logging activity
                    $sess_user_id   = session()->get('login_id');
                    $sess_user_name = session()->get('user_name');

                    $LogMsg          = config('constants.SUPER_ADMIN.1128');
                    $FinalLogMessage = $sess_user_name . ' ' . $LogMsg;

                    $ActivityLogData                   = new ActivityLog();
                    $ActivityLogData->user_id          = $sess_user_id;
                    $ActivityLogData->activity_message = $FinalLogMessage;
                    $ActivityLogData->save();

                    return ['status' => 'success', 'msg' => 'Master Inventory Copied Successfully.'];
                }
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
