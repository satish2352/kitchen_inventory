<?php
namespace App\Http\Repository\Manager;

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
	LocationWiseInventory
};
use Illuminate\Support\Facades\Mail;

class ShoppingListRepository
{

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

    public function addKitchenInventoryByManager($request)
	{
		$sess_user_id = session()->get('login_id');
		$sess_location_id = session()->get('location_selected_id');
		$inventoryIds = $request->input('master_inventory_id');
		$quantities = $request->input('quantity');

		$data =array();
		foreach ($inventoryIds as $index => $inventoryId) {
		$LocationWiseInventoryData = new LocationWiseInventory();
		$LocationWiseInventoryData->user_id = $sess_user_id;
		$LocationWiseInventoryData->inventory_id = $inventoryIds[$index];
		$LocationWiseInventoryData->location_id = $sess_location_id;
		$LocationWiseInventoryData->quantity = $quantities[$index];
		$LocationWiseInventoryData->approved_by = 1;
		$LocationWiseInventoryData->save();
		$last_insert_id = $LocationWiseInventoryData->id;
		}
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

        return $student_data;

            // }
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Intern ID Card details not found.',
            // ], 404);

    }
}