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
	MasterKitchenInventory
};
use Illuminate\Support\Facades\Mail;

class MasterKitchenInventoryRepository
{

	public function getItemsList() 
	{
		$location_selected_id = session()->get('location_selected_id');
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
				'category.category_name',
				'units.unit_name',
				'locations.location'
			)
			->where('master_kitchen_inventory.is_deleted', '0')
			->where('master_kitchen_inventory.location_id', $location_selected_id)
			->orderBy('category.category_name', 'asc') // Order by category name first
			->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
			->get()
			->groupBy('category_name'); // Group items by category name
	// dd($data_location);
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