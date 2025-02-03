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
	Items
};
use Illuminate\Support\Facades\Mail;

class ItemsRepository
{

	public function getItemsList() {
		$data_location = Items::leftJoin('category', 'items.category', '=', 'category.id')
			->leftJoin('units', 'items.unit', '=', 'units.id')
			->select(
				'items.id',
				'items.category',
				'items.item_name',
				'items.unit',
				'items.price',
				'items.created_at',
				'category.category_name',
				'units.unit_name'
			)
			->where('items.is_deleted', '0')
			->orderBy('category.category_name', 'asc') // Order by category name first
			->orderBy('items.item_name', 'asc') // Then order by item name
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

    public function addLocationCheck($request)
	{
		return Locations::where('location', '=', $request['location'])
			// ->orWhere('u_uname','=',$request['u_uname'])
			->select('id')->get();
	}

    public function editItem($reuest)
	{

		// $data_district = [];

		$data_users_data = Items::where('items.id', '=', $reuest->locationId)
			->select('items.*')->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		// dd($data_location);
		return $data_location;
	}

    public function addItem($request)
	{
		// dd($request);
		$data =array();
		$user_data = new Items();
		$user_data->item_name = $request['item_name'];
		$user_data->category = $request['category'];
		$user_data->unit = $request['unit'];
		$user_data->price = $request['price'];
		$user_data->save();
		$last_insert_id = $user_data->id;
// dd($user_data);
        return $last_insert_id;

	}

    public function updateItem($request)
	{
		// dd($request);
		$user_data = Items::where('id',$request['edit_id']) 
						->update([
							'item_name' => $request['item_name'],
							'category' => $request['category'],
							'unit' => $request['unit'],
							'price' => $request['price']
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

        $student_data = Items::find($id);
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