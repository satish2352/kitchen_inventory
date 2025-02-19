<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\SuperAdmin\ShoppingListServices;
use Illuminate\Support\Facades\DB;

use App\Models\ {
    Items,
    Locations,
    LocationWiseInventory,
    MasterKitchenInventory,
    ActivityLog,
    InventoryHistory,
    UsersData
};
use Session;
use Cookie;

class ShoppingListController extends Controller
{
    public function __construct()
    {
        $this->service = new ShoppingListServices();

    }

    public function getShopppingListSuperAdmin(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');

        $all_kitchen_inventory = Items::where('is_deleted', '0')
            ->select('*')
            ->get()
            ->toArray();
        $data_location_wise_inventory=array();

        $locationsData = Locations::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->select('id','location')
                            ->orderBy('location', 'asc')
                            ->get()
                            ->toArray();

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
            ->where('location_wise_inventory.approved_by', '1')
            ->whereDate('location_wise_inventory.created_at', now()->toDateString())
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');

        }    
        return view('shopping-list', compact('locationsData','data_location_wise_inventory'));
    }

    public function getSubmitedShopppingListSuperAdmin(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');
        $data_location_wise_inventory=array();
        $locationsData = Locations::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->select('id','location')
                            ->orderBy('location', 'asc')
                            ->get()
                            ->toArray();

        if($location_selected_name !=''){

            $data_location_wise_inventory = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
            ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->select(
                'master_kitchen_inventory.id',
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
            // ->where('location_wise_inventory.approved_by', '1')
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');

        }    
        return view('kitchen-inventory-submited', compact('locationsData','data_location_wise_inventory'));
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

    public function getLocationWiseInventorySA(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');


        $userLocationData = UsersData::where('is_deleted', '0')
        ->where('is_approved', '1')
        ->where('id', $sess_user_id)
        ->pluck('location')
        ->toArray(); 

        $userLocation = [];
		$data_location=array();
        foreach ($userLocationData as $location) {
            $userLocation = array_merge($userLocation, explode(',', $location));
        }

        $all_kitchen_inventory = Items::where('is_deleted', '0')
            ->select('*')
            ->get()
            ->toArray();
        $InventoryData=array();

        $locationsData = Locations::where('is_active', '1')
                            ->where('is_deleted', '0')
			                ->whereIn('id', $userLocation)
                            ->select('id','location')
                            ->orderBy('location', 'asc')
                            ->get()
                            ->toArray();

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
        // dd($InventoryData);
        return view('kitchen-inventory', compact('all_kitchen_inventory','InventoryData','locationsData'));
    }

    public function addKitchenInventoryBySuperAdmin(Request $request)
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
                $add_role = $this->service->addKitchenInventoryBySuperAdmin($request);
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

    public function updateKitchenInventoryBySuperAdmin(Request $request) {
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
    
            $register_user = $this->service->updateKitchenInventoryBySuperAdmin($request);
    
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

    // public function getInventory(Request $request) 
    // {
    //     $sess_user_id = session()->get('login_id');
    //     $location_selected_name = session()->get('location_selected_name');
    //     $location_selected_id = session()->get('location_selected_id');
    //     $LocationId = $request->input('location_id');
    //     $InventoryDate = $request->input('inventory_date');

    //     $data_location_wise_inventory=array();
    //     $locationsData = Locations::where('is_active', '1')
    //                         ->where('is_deleted', '0')
    //                         ->select('id','location')
    //                         ->orderBy('location', 'asc')
    //                         ->get()
    //                         ->toArray();

    //     // if($location_selected_name !=''){

    //         $data_location_wise_inventory = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
    //         ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
    //         ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
    //         ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
    //         ->select(
    //             'master_kitchen_inventory.id',
    //             'master_kitchen_inventory.category',
    //             'master_kitchen_inventory.item_name',
    //             'master_kitchen_inventory.unit',
    //             'master_kitchen_inventory.price',
    //             'location_wise_inventory.quantity',
    //             'location_wise_inventory.created_at',
    //             'location_wise_inventory.id as locationWiseId',
    //             'category.category_name',
    //             'units.unit_name',
    //             'locations.location'
    //         )
    //         // ->where('master_kitchen_inventory.location_id', $location_selected_id)
    //         ->where('master_kitchen_inventory.is_deleted', '0')
    //         ->whereDate('location_wise_inventory.created_at', now()->toDateString())
    //         // ->where('location_wise_inventory.approved_by', '1')
    //         ->orderBy('category.category_name', 'asc') // Order by category name first
    //         ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
    //         ->get()
    //         ->groupBy('category_name');

    //     // }    
    //     return view('kitchen-inventory-history', compact('locationsData','data_location_wise_inventory'));
    // }

    public function getInventory(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');

        // $LocationId = $request->input('location_id');
        // $InventoryDate = $request->input('inventory_date');
        $LocationValData = $request->input('location_id');
        $DateValData = $request->input('inventory_date');
        

        $data_location_wise_inventory=array();
        $locationsData = Locations::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->select('id','location')
                            ->orderBy('location', 'asc')
                            ->get()
                            ->toArray();

        // if($location_selected_name !=''){

        $location_val_data = Locations::find($LocationValData);
        if(!empty($location_val_data))
        {
        $LocationName=$location_val_data->location;
        }
        
        $user_data = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
        ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
        ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
        ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
        ->select(
            'master_kitchen_inventory.id',
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
        ->where('location_wise_inventory.location_id', $LocationValData)
    ->whereDate('location_wise_inventory.created_at', $DateValData)
        ->where('master_kitchen_inventory.is_deleted', '0')
        ->orderBy('category.category_name', 'asc') // Order by category name first
        ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
        ->get()
        ->groupBy('category_name');
// dd($user_data);
        // }    
        return view('kitchen-inventory-history', compact('locationsData','user_data','data_location_wise_inventory'));
    }

    public function getInventorySubmitHistory(Request $request)
    {
        $LocationValData = $request->input('location_id');
        $DateValData = $request->input('inventory_date');

        $locationsData = Locations::where('is_active', '1')
        ->where('is_deleted', '0')
        ->select('id','location')
        ->orderBy('location', 'asc')
        ->get()
        ->toArray();
        

        $location_val_data = Locations::find($LocationValData);
        $LocationName=$location_val_data->location;

        $user_data = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
        ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
        ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
        ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
        ->select(
            'master_kitchen_inventory.id',
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
        ->where('location_wise_inventory.location_id', $LocationValData)
        ->whereDate('location_wise_inventory.created_at', $DateValData)
        ->where('master_kitchen_inventory.is_deleted', '0')
        ->orderBy('category.category_name', 'asc') // Order by category name first
        ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
        ->get()
        ->groupBy('category_name');

// dd($user_data);
        // Get raw SQL query
// $sql = $query->toSql();
// $bindings = $query->getBindings();
// dd($query);
        // Return the user listing Blade with the search results (no full page reload)
        return view('kitchen-inventory-history', compact('locationsData','user_data','LocationName','DateValData'))    ;
    }

    public function searchShoppingList(Request $request)
    {
        $query = $request->input('query');
        $location_selected_id = session()->get('location_selected_id');
        // Modify the query to search users based on name, email, or phone
        // $user_data = UsersData::where('name', 'like', "%$query%")
        //                  ->orWhere('email', 'like', "%$query%")
        //                  ->orWhere('phone', 'like', "%$query%")
        //                  ->get();

        $data_location_wise_inventory = LocationWiseInventory::leftJoin('locations', 'location_wise_inventory.location_id', '=', 'locations.id')
            ->leftJoin('master_kitchen_inventory', 'location_wise_inventory.inventory_id', '=', 'master_kitchen_inventory.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->select(
                'master_kitchen_inventory.id',
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
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->orWhere('master_kitchen_inventory.item_name', 'like', "%$query%")
                    ->orWhere('category.category_name', 'like', "%$query%")
                    ->orWhere('locations.location', 'like', "%$query%");
                });
            })
            // ->where('location_wise_inventory.approved_by', '1')
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');
    
        // Return the user listing Blade with the search results (no full page reload)
        return view('shopping-list-search-results', compact('data_location_wise_inventory'))->render();
    }

    public function SearchUpdateKitchenInventorySuperAdmin(Request $request)
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
        
        return view('update-kitchen-inventory-search-result', compact('InventoryData'))->render();
    }
} 