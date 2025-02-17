<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\Admin\ShoppingListServices;
use Illuminate\Support\Facades\DB;
use App\Models\ {
    Items,
    Locations,
    LocationWiseInventory,
    MasterKitchenInventory,
    ActivityLog
};
use Session;
use Cookie;

class ShoppingListController extends Controller
{
    public function __construct()
    {
        $this->service = new ShoppingListServices();

    }

    public function getShopppingListAdmin(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');

        $all_kitchen_inventory = Items::where('is_deleted', '0')
            ->select('*')
            ->get()
            ->toArray();
        $InventoryData=array();

        if($location_selected_name !=''){

            $data_location_wise_inventory_new = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
                ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
                ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
                ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
                ->select(
                    'location_wise_inventory.id',
                    'master_kitchen_inventory.category',
                    'master_kitchen_inventory.item_name',
                    'master_kitchen_inventory.unit',
                    'master_kitchen_inventory.price',
                    'master_kitchen_inventory.quantity as masterQuantity',
                    'location_wise_inventory.quantity',
                    'location_wise_inventory.created_at',
                    'location_wise_inventory.id as locationWiseId',
                    'location_wise_inventory.inventory_id as masterInventoryId',
                    'category.category_name',
                    'units.unit_name',
                    'locations.location'
                )
                ->where('master_kitchen_inventory.location_id', $location_selected_id)
                ->where('master_kitchen_inventory.is_deleted', '0')
                ->whereDate('location_wise_inventory.created_at', now()->toDateString())
                ->orderBy('category.category_name', 'asc')
                ->orderBy('master_kitchen_inventory.item_name', 'asc')
                ->get()
                ->groupBy('category_name');


            // Fetch newly added items from master_kitchen_inventory that are NOT in location_wise_inventory
            $new_master_inventory_items = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('locations', 'master_kitchen_inventory.location_id', '=', 'locations.id')
            ->select(
                'master_kitchen_inventory.id as masterInventoryId',
                'master_kitchen_inventory.category',
                'master_kitchen_inventory.item_name',
                'master_kitchen_inventory.unit',
                'master_kitchen_inventory.price',
                'master_kitchen_inventory.quantity as masterQuantity',
                DB::raw('NULL as quantity'), // New items won't have quantity yet
                'category.category_name',
                'units.unit_name',
                'locations.location'
            )
            ->where('master_kitchen_inventory.location_id', $location_selected_id)
            ->where('master_kitchen_inventory.is_deleted', '0')
            ->whereNotIn('master_kitchen_inventory.id', function ($query) use ($location_selected_id) {
                $query->select('inventory_id')
                    ->from('location_wise_inventory')
                    ->where('location_id', $location_selected_id);
            })
            ->orderBy('category.category_name', 'asc')
            ->orderBy('master_kitchen_inventory.item_name', 'asc')
            ->get()
            ->groupBy('category_name');        

            
        if(!empty($data_location_wise_inventory_new) && count($data_location_wise_inventory_new) > 0)
        {

            foreach ($new_master_inventory_items as $category => $items) {
                if (isset($data_location_wise_inventory_new[$category])) {
                    $data_location_wise_inventory_new[$category] = $data_location_wise_inventory_new[$category]->merge($items);
                } else {
                    $data_location_wise_inventory_new[$category] = $items;
                }
            }
            
            $InventoryData['data_location_wise_inventory'] = $data_location_wise_inventory_new;
            $InventoryData['DataType'] = 'LocationWiseData';
                // $InventoryData['data_location_wise_inventory']=$data_location_wise_inventory_new;
                // $InventoryData['DataType']='LocationWiseData';
            // dd($InventoryData);
        }else{
            $data_location_wise_inventory = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
			->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
			->leftJoin('locations', 'master_kitchen_inventory.location_id', '=', 'locations.id')
			->select(
				'master_kitchen_inventory.id',
				'master_kitchen_inventory.category',
				'master_kitchen_inventory.item_name',
				'master_kitchen_inventory.unit',
				'master_kitchen_inventory.price',
				// 'master_kitchen_inventory.quantity',
                'master_kitchen_inventory.quantity as masterQuantity',
				'master_kitchen_inventory.created_at',
				'category.category_name',
				'units.unit_name',
				'locations.location'
			)
			->where('master_kitchen_inventory.location_id', $location_selected_id)
			->where('master_kitchen_inventory.is_deleted', '0')
			->orderBy('category.category_name', 'asc') // Order by category name first
			->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
			->get()
            // dd($data_location);
			->groupBy('category_name');
            $InventoryData['data_location_wise_inventory']=$data_location_wise_inventory;
            $InventoryData['DataType']='MasterData';
            // dd($InventoryData);

            }
        }    
        // dd($data_location_wise_inventory);
        return view('admin.kitchen-inventory', compact('all_kitchen_inventory','InventoryData'));
    }

    public function getSubmitedShopppingListAdmin(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');

        if($location_selected_name !=''){

            $data_location_wise_inventory = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
            ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->select(
                'location_wise_inventory.id',
                'master_kitchen_inventory.category',
                'master_kitchen_inventory.item_name',
                'master_kitchen_inventory.unit',
                'master_kitchen_inventory.price',
                'location_wise_inventory.quantity',
                'location_wise_inventory.created_at',
                'location_wise_inventory.id as locationWiseId',
                'category.category_name',
                'units.unit_name',
                'locations.location'
            )
            ->where('master_kitchen_inventory.location_id', $location_selected_id)
            ->where('master_kitchen_inventory.is_deleted', '0')
            ->whereDate('location_wise_inventory.created_at', now()->toDateString())
            // ->where('location_wise_inventory.approved_by', '2')
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');

        }    
        return view('admin.kitchen-inventory-submited', compact('data_location_wise_inventory'));
    }

    public function updateShoppingListManager(Request $request) 
    {
        // Define the validation rules
        $rules = [
            'user_name' => 'required|exists:users_data,user_name', // Check if the user_name exists in the users_data table
            'password' => 'required',  // Make sure the password field is required
        ];

        // Define custom validation messages
        $messages = [   
            'user_name.required' => 'Please Enter user_name.',
            'user_name.exists' => 'The provided user_name does not exist.',
            'password.required' => 'Please Enter Password.',
        ];

        // Start validation process
        $validation = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validation->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validation);
        }

        try {
            // Fetch user details from the database
            $get_user = UsersData::where('user_name', $request['user_name'])->first();
            // dd($get_user['password']);
            if ($get_user) {
                // The username exists, now verify the password
                $password = $request->password;

                // Decrypt the password stored in the database
                // $decryptedPassword = Crypt::decryptString($get_user->password);
                $decryptedPassword =$get_user['password'];

                // Compare the decrypted password with the input password
                if ($password == $decryptedPassword) {
                    // Store the user data in session
                    $request->session()->put('user_name', $get_user['user_name']);
                    $request->session()->put('login_id', $get_user['id']);
                    $request->session()->put('user_role', $get_user['user_role']);
                    $request->session()->put('location_for_user', $get_user['location']);
                    // dd($request->session()->get('login_id'));
                    // Return a successful login redirect
                    // dd("dsdfasfsafgsa");
                    $request->session()->regenerate();
                    return redirect(route('/dashboard'));  // Change to your dashboard route
                   
                } else {
                    // Invalid password

                    return redirect('/')
                        ->withInput()
                        ->withErrors(['password' => 'These credentials do not match our records.']);
                }
            } else {
                // Invalid username
                return redirect('/')
                    ->withInput()
                    ->withErrors(['user_name' => 'These credentials do not match our records.']);
            }

        } catch (Exception $e) {
            // If there's an exception, redirect to the feedback page with the error message
            return redirect('feedback-suggestions')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }


    public function getLocationSelectedAdmin(Request $request) 
    {
        $request->session()->put('location_selected', $request->location_selected);
        $final_location  = Locations::where('id',session('location_selected'))->first();
        $request->session()->put('location_selected_name', $final_location->location);
        $request->session()->put('location_selected_id', $final_location->id);
        return \Redirect::back();

    }

//     public function updateKitchenInventoryByAdmin(Request $request)
// {
//     // Ensure arrays are received
//     $inventoryIds = $request->input('master_inventory_id');
//     $quantities = $request->input('quantity');
//     $location_selected_id = session()->get('location_selected_id');

//     // Loop through and update each inventory item
//     foreach ($inventoryIds as $index => $inventoryId) {
//         LocationWiseInventory::where('id', $inventoryId)
//         ->where('location_id', $location_selected_id)
//         // ->where('location_id', $location_selected_id)
//         ->whereDate('created_at', now()->toDateString())
//         ->update([
//             'quantity' => $quantities[$index],
//             'approved_by' => '2'
//         ]);
//     }

//     $msg = "Kitchen Inventory Updated Successfully";
//     $status = "success";

//     session()->flash('alert_status', $status);
//     session()->flash('alert_msg', $msg);
//     return \Redirect::back();
//     return redirect('get-submited-shopping-list-admin');
    
//     // return response()->json(['message' => 'Inventory updated successfully!'], 200);
// }

public function updateKitchenInventoryByAdmin(Request $request) {
    $rules = [
        'quantity' => 'required',
    ];
    $messages = [
        'quantity.required' => 'First item_name is required.'
    ];
    try {
        $validation = Validator::make($request->all(), $rules, $messages);
        if ($validation->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validation);
        }

        $register_user = $this->service->updateKitchenInventoryByAdmin($request);

        if ($register_user) {
            $msg = $register_user['msg'];
            $status = $register_user['status'];
            $pdfBase64 = $register_user['pdfBase64']; // Get the base64 PDF from service

            session()->flash('alert_status', $status);
            session()->flash('alert_msg', $msg);

            if ($status == 'success') {
                return view('download_redirect', compact('pdfBase64'));
            } else {
                return redirect('list-items')->withInput();
            }
        }
    } catch (Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with(['msg' => $e->getMessage(), 'status' => 'error']);
    }
}

public function addKitchenInventoryByAdmin(Request $request)
    {

        try {

            $rules = [
                'quantity' => 'required'
            ];
            $messages = [
            'quantity.required' => 'Quantity is required.'
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('get-shopping-list-manager')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addKitchenInventoryByAdmin($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
                    $status = $add_role['status'];
                    $pdfBase64 = $add_role['pdfBase64'];

                     // Store SweetAlert data in session for flashing
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        // return redirect('dashboard');
                        return view('download_redirect', compact('pdfBase64'));
                    } else {
                        return redirect('get-shopping-list-manager')->withInput();
                    }
                }

            }
        } catch (Exception $e) {
            return redirect('get-shopping-list-manager')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function SearchUpdateKitchenInventory(Request $request)
    {
        $query = $request->input('query');
        $sess_user_id = session()->get('login_id');
        $location_selected_id = session()->get('location_selected_id');
        
        if (empty($location_selected_id)) {
            return response()->json(['error' => 'Location not selected'], 400);
        }
        
        // Fetch existing inventory for the selected location
        $data_location_wise_inventory = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
            ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->select(
                'location_wise_inventory.id',
                'master_kitchen_inventory.category',
                'master_kitchen_inventory.item_name',
                'master_kitchen_inventory.unit',
                'master_kitchen_inventory.price',
                'master_kitchen_inventory.quantity as masterQuantity',
                'location_wise_inventory.quantity',
                'location_wise_inventory.created_at',
                'location_wise_inventory.id as locationWiseId',
                'location_wise_inventory.inventory_id as masterInventoryId',
                'category.category_name',
                'units.unit_name',
                'locations.location'
            )
            ->where('master_kitchen_inventory.location_id', $location_selected_id)
            ->where('master_kitchen_inventory.is_deleted', '0')
            ->whereDate('location_wise_inventory.created_at', now()->toDateString())
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('master_kitchen_inventory.item_name', 'like', "%$query%")
                        ->orWhere('category.category_name', 'like', "%$query%")
                        ->orWhere('units.unit_name', 'like', "%$query%");
                });
            })
            ->orderBy('category.category_name', 'asc')
            ->orderBy('master_kitchen_inventory.item_name', 'asc')
            ->get()
            ->groupBy('category_name');
    
        // Fetch newly added items that are not in location-wise inventory
        $new_master_inventory_items = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('locations', 'master_kitchen_inventory.location_id', '=', 'locations.id')
            ->select(
                'master_kitchen_inventory.id as masterInventoryId',
                'master_kitchen_inventory.category',
                'master_kitchen_inventory.item_name',
                'master_kitchen_inventory.unit',
                'master_kitchen_inventory.price',
                'master_kitchen_inventory.quantity as masterQuantity',
                DB::raw('NULL as quantity'),
                'category.category_name',
                'units.unit_name',
                'locations.location'
            )
            ->where('master_kitchen_inventory.location_id', $location_selected_id)
            ->where('master_kitchen_inventory.is_deleted', '0')
            ->whereNotIn('master_kitchen_inventory.id', function ($query) use ($location_selected_id) {
                $query->select('inventory_id')
                    ->from('location_wise_inventory')
                    ->where('location_id', $location_selected_id);
            })
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('master_kitchen_inventory.item_name', 'like', "%$query%")
                        ->orWhere('category.category_name', 'like', "%$query%")
                        ->orWhere('units.unit_name', 'like', "%$query%");
                });
            })
            ->orderBy('category.category_name', 'asc')
            ->orderBy('master_kitchen_inventory.item_name', 'asc')
            ->get()
            ->groupBy('category_name');
        
        // Merge new items into existing inventory data
        foreach ($new_master_inventory_items as $category => $items) {
            if (isset($data_location_wise_inventory[$category])) {
                $data_location_wise_inventory[$category] = $data_location_wise_inventory[$category]->merge($items);
            } else {
                $data_location_wise_inventory[$category] = $items;
            }
        }
        
        $InventoryData = [
            'data_location_wise_inventory' => $data_location_wise_inventory,
            'DataType' => count($data_location_wise_inventory) > 0 ? 'LocationWiseData' : 'MasterData',
        ];
        
        return view('admin.update-kitchen-inventory-search-result', compact('InventoryData'))->render();
    }
    


}
