<?php
namespace App\Http\Repository\SuperAdmin;

use Illuminate\Database\QueryException;
use DB;
use Illuminate\Support\Carbon;
use Session;
use App\Models\{
	Locations,
	Category,
	Unit,
	User,
	Items,
	MasterKitchenInventory,
	ActivityLog
};
use Illuminate\Support\Facades\Mail;

class MasterKitchenInventoryRepository
{

	public function getItemsList() 
{
    $location_selected_id = session()->get('location_selected_id');

    // Get all categories that are active and not deleted
    $categories = Category::where('is_active', 1)
        ->where('is_deleted', 0)
        ->pluck('id');  // Only get the category IDs

    $data_location = [];

    // Loop through each category and check if it has at least one non-deleted item
    foreach ($categories as $category_id) {
        $items = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
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
                'category.category_name',
                'units.unit_name',
                'locations.location'
            )
            ->where('master_kitchen_inventory.is_deleted', 0)  // Only non-deleted items
            ->where('master_kitchen_inventory.location_id', $location_selected_id)  // Only for the selected location
            ->where('master_kitchen_inventory.category', $category_id)  // For the current category
            ->orderBy('master_kitchen_inventory.item_name', 'asc')  // Ordering by item name
            ->paginate(10);  // Paginate the results for each category

        // Only add the category to the result if it has items
        if ($items->count() > 0) {
            $data_location[$category_id] = $items;  // Store paginated items by category
        }
    }

    return $data_location;
}




	
    // public function getItemsList() {
    //     $data_location = Items::leftJoin('category', 'items.category', '=', 'category.id')
	// 							->leftJoin('units', 'items.unit', '=', 'units.id')
	// 	->select('items.id','items.category','item_name','unit','price','items.created_at','category.category_name','units.unit_name')
	// 						->where('items.is_deleted', '0')
	// 						->orderBy('item_name', 'asc')
	// 						->get();
							
	// 	return $data_location;
	// }

    // public function addLocationCheck($request)
	// {
	// 	return Locations::where('location', '=', $request['location'])
	// 		// ->orWhere('u_uname','=',$request['u_uname'])
	// 		->select('id')->get();
	// }

    public function editItem($reuest)
	{

		// $data_district = [];

		$data_users_data = MasterKitchenInventory::where('master_kitchen_inventory.id', '=', $reuest->locationId)
			->select('master_kitchen_inventory.*')->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		// dd($data_location);
		return $data_location;
	}

    public function addItem($request)
	{
		// dd($request);
		$data =array();
		$user_data = new MasterKitchenInventory();
		$user_data->item_name = $request['item_name'];
		$user_data->category = $request['category'];
		$user_data->unit = $request['unit'];
		$user_data->price = $request['price'];
		$user_data->location_id = $request['location_id'];
		$user_data->quantity = $request['quantity'];
		$user_data->save();
		$last_insert_id = $user_data->id;
		// dd($user_data);

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
						
		$LogMsg= config('constants.SUPER_ADMIN.1111');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();

        return $last_insert_id;

	}

    public function updateItem($request)
	{
		// dd($request);
		$user_data = MasterKitchenInventory::where('id',$request['edit_id']) 
						->update([
							'item_name' => $request['item_name'],
							'category' => $request['category'],
							'unit' => $request['unit'],
							'price' => $request['price'],
							'location_id' => $request['location_id'],
							'quantity' => $request['quantity'],
						]);

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
						
		$LogMsg= config('constants.SUPER_ADMIN.1122');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();
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

    public function deleteItem($id)
    {
        $all_data=[];

        $student_data = MasterKitchenInventory::find($id);
// dd($student_data);
                // Delete the record from the database
                $is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
                $student_data->is_deleted = $is_deleted;
                $student_data->save();

		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
						
		$LogMsg= config('constants.SUPER_ADMIN.1123');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();

        return $student_data;

    }

	public function copyMasterInventory($request)
{
    $data_master_inventory_data = MasterKitchenInventory::where('master_kitchen_inventory.location_id', '=', $request->from_location_id)
        ->where('master_kitchen_inventory.is_deleted', '=', '0')
        ->select('master_kitchen_inventory.*')->get()
        ->toArray();

    $data_master_inventory_to_location = MasterKitchenInventory::where('master_kitchen_inventory.location_id', '=', $request->to_location_id)
        ->where('master_kitchen_inventory.is_deleted', '=', '0')
        ->select('master_kitchen_inventory.*')->get()
        ->toArray();


    if (empty($data_master_inventory_data)) {
        session()->flash('alert_status', 'error');
        session()->flash('alert_msg', 'No inventory data found for the selected From Location.');
        return ['status' => 'error', 'msg' => 'No inventory data found for the selected From Location.'];
    }else{
        $existingItemIds = array_column($data_master_inventory_to_location, 'item_name');

        $filteredInventoryData = array_filter($data_master_inventory_data, function ($item) use ($existingItemIds) {
            return !in_array($item['item_name'], $existingItemIds);
        });

        $filteredInventoryData = array_values($filteredInventoryData);

        if (empty($filteredInventoryData)) {
        session()->flash('alert_status', 'error');
        session()->flash('alert_msg', 'All data from the "From Location" has already been inserted into the "To Location" data.');
        return ['status' => 'error', 'msg' => 'All data from the "From Location" has already been inserted into the "To Location" data..'];
        }else{
            foreach ($filteredInventoryData as $index => $inventoryData) {
                $user_data = new MasterKitchenInventory();
                $user_data->item_name = $inventoryData['item_name'];
                $user_data->category = $inventoryData['category'];
                $user_data->unit = $inventoryData['unit'];
                $user_data->price = $inventoryData['price'];
                $user_data->location_id = $request->to_location_id;
                $user_data->quantity = $inventoryData['quantity'];
                $user_data->save();
            }
        
            // Logging activity
            $sess_user_id = session()->get('login_id');
            $sess_user_name = session()->get('user_name');
            
            $LogMsg = config('constants.SUPER_ADMIN.1128');
            $FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
            
            $ActivityLogData = new ActivityLog();
            $ActivityLogData->user_id = $sess_user_id;
            $ActivityLogData->activity_message = $FinalLogMessage;
            $ActivityLogData->save();
        
            return ['status' => 'success', 'msg' => 'Master Inventory Copied Successfully.'];
        }
    }

   
}

}