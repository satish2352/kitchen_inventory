<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\ShoppingListServices;
use App\Models\
{   MasterKitchenInventory,
    Locations,
    LocationWiseInventory
};
    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShoppingListController extends Controller
{
    public function __construct()
    {
        $this->service = new ShoppingListServices();

    }

    public function getShopppingListSuperAdmin(Request $request)
    {
        try {
            $sess_user_id           = session()->get('login_id');
            $location_selected_name = session()->get('location_selected_name');
            $location_selected_id   = session()->get('location_selected_id');

            // Items,
            // $all_kitchen_inventory = Items::where('is_deleted', '0')
            //     ->select('*')
            //     ->get()
            $data_location_wise_inventory = [];

            $locationsData = Locations::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'location')
                ->orderBy('location', 'asc')
                ->get()
                ->toArray();

            if ($location_selected_name != '') {

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
                    ->orderBy('category.category_name', 'asc')             //     ->toArray();
                    ->orderBy('master_kitchen_inventory.item_name', 'asc') // Order by category name first
                    ->get()
                    ->groupBy('category_name');

            }
            return view('shopping-list', compact('locationsData', 'data_location_wise_inventory'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function getSubmitedShopppingListSuperAdmin(Request $request)
    {
        try {
            $sess_user_id                 = session()->get('login_id');
            $location_selected_name       = session()->get('location_selected_name');
            $location_selected_id         = session()->get('location_selected_id');
            $data_location_wise_inventory = [];
            $locationsData                = Locations::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'location')
                ->orderBy('location', 'asc')
                ->get()
                ->toArray();

            if ($location_selected_name != '') {

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
                        'location_wise_inventory.master_quantity',
                        'location_wise_inventory.master_price',
                        'location_wise_inventory.id as locationWiseId',
                        'category.category_name',
                        'units.unit_name',
                        'locations.location'
                    )
                    ->where('master_kitchen_inventory.location_id', $location_selected_id)
                    ->where('master_kitchen_inventory.is_deleted', '0')
                    ->whereDate('location_wise_inventory.created_at', now()->toDateString())
                    ->orderBy('category.category_name', 'asc')
                    ->orderBy('master_kitchen_inventory.priority', 'asc')
                    ->get()
                    ->groupBy('category_name');

            }
            return view('kitchen-inventory-submited', compact('locationsData', 'data_location_wise_inventory'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
    public function updateShoppingListManager(Request $request)
    {
        try {
            // Then order by item name
            $rules = [
                'user_name' => 'required|exists:users_data,user_name', // Define the validation rules
                'password'  => 'required',                             // Check if the user_name exists in the users_data table
            ];

            // Make sure the password field is required
            $messages = [
                'user_name.required' => 'Please Enter user_name.',
                'user_name.exists'   => 'The provided user_name does not exist.',
                'password.required'  => 'Please Enter Password.',
            ];

            // Define custom validation messages
            $validation = Validator::make($request->all(), $rules, $messages);

            // Start validation process
            if ($validation->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validation);
            }

            try {
                // If validation fails, return back with errors
                $get_user = UsersData::where('user_name', $request['user_name'])->first();
                // Fetch user details from the database
                if ($get_user) {
                    // dd($get_user['password']);
                    $password = $request->password;

                    // The username exists, now verify the password
                    // Decrypt the password stored in the database
                    $decryptedPassword = $get_user['password'];

                    // $decryptedPassword = Crypt::decryptString($get_user->password);
                    if ($password == $decryptedPassword) {
                        // Compare the decrypted password with the input password
                        $request->session()->put('user_name', $get_user['user_name']);
                        $request->session()->put('login_id', $get_user['id']);
                        $request->session()->put('user_role', $get_user['user_role']);
                        $request->session()->put('location_for_user', $get_user['location']);
                        // Store the user data in session
                        // dd($request->session()->get('login_id'));
                        // Return a successful login redirect
                        $request->session()->regenerate();
                        return redirect(route('/dashboard')); // dd("dsdfasfsafgsa");

                    } else {
                        // Change to your dashboard route

                        return redirect('/')
                            ->withInput()
                            ->withErrors(['password' => 'These credentials do not match our records.']);
                    }
                } else {
                    // Invalid password
                    return redirect('/')
                        ->withInput()
                        ->withErrors(['user_name' => 'These credentials do not match our records.']);
                }

            } catch (Exception $e) {
                // Invalid username
                return redirect('feedback-suggestions')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function getLocationSelectedAdmin(Request $request)
    {
        try {
            $request->session()->put('location_selected', $request->location_selected);
            $final_location = Locations::where('id', session('location_selected'))->first();
            $request->session()->put('location_selected_name', $final_location->location);
            $request->session()->put('location_selected_id', $final_location->id);
            return \Redirect::back();
        } catch (\Exception $e) {
            info($e->getMessage());
        }

    }

    public function getLocationWiseInventorySA(Request $request)
    {
        try {
            $sess_user_id           = session()->get('login_id');
            $location_selected_name = session()->get('location_selected_name');
            $location_selected_id   = session()->get('location_selected_id');

            $InventoryData = [];

            $locationsData = Locations::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'location')
                ->orderBy('location', 'asc')
                ->get()
                ->toArray();

            if ($location_selected_name != '') {

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

                // If there's an exception, redirect to the feedback page with the error message
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
                        DB::raw('NULL as quantity'), // Fetch newly added items from master_kitchen_inventory that are NOT in location_wise_inventory
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

                if (! empty($data_location_wise_inventory_new) && count($data_location_wise_inventory_new) > 0) {

                    foreach ($new_master_inventory_items as $category => $items) {
                        if (isset($data_location_wise_inventory_new[$category])) {
                            $data_location_wise_inventory_new[$category] = $data_location_wise_inventory_new[$category]->merge($items);
                        } else {
                            $data_location_wise_inventory_new[$category] = $items;
                        }
                    }

                    $InventoryData['data_location_wise_inventory'] = $data_location_wise_inventory_new;
                    $InventoryData['DataType']                     = 'LocationWiseData';
                } else {
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
                        ->orderBy('category.category_name', 'asc')             // New items won't have quantity yet
                        ->orderBy('master_kitchen_inventory.item_name', 'asc') // Order by category name first
                        ->get()
                        ->groupBy('category_name');
                    $InventoryData['data_location_wise_inventory'] = $data_location_wise_inventory;
                    $InventoryData['DataType']                     = 'MasterData';

                }
            }
            return view('kitchen-inventory', compact('InventoryData', 'locationsData'));

        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addKitchenInventoryBySuperAdmin(Request $request)
    {
        try {

            $rules = [
                'quantity' => 'required',
            ];
            $messages = [
                'quantity.required' => 'Quantity is required.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('get-shopping-list-manager')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addKitchenInventoryBySuperAdmin($request);
                if ($add_role) {
                    $msg       = $add_role['msg'];
                    $status    = $add_role['status'];
                    $pdfBase64 = $add_role['pdfBase64'];
                    dd($pdfBase64);
                    // Then order by item name
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        // Store SweetAlert data in session for flashing
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

    public function updateKitchenInventoryBySuperAdmin(Request $request)
    {
        try {
            $rules = [
                'quantity' => 'required',
            ];
            $messages = [
                'quantity.required' => 'First item_name is required.',
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
                    $msg       = $register_user['msg'];
                    $status    = $register_user['status'];
                    $pdfBase64 = $register_user['pdfBase64']; // return redirect('dashboard');

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
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }


    public function getInventory(Request $request)
    {
        try {
            $sess_user_id           = session()->get('login_id');
            $location_selected_name = session()->get('location_selected_name');
            $location_selected_id   = session()->get('location_selected_id');

            // }
            // $LocationId = $request->input('location_id');
            $LocationValData = $request->input('location_id');
            $DateValData     = $request->input('inventory_date');

            $data_location_wise_inventory = [];
            $locationsData                = Locations::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'location')
                ->orderBy('location', 'asc')
                ->get()
                ->toArray();

            // $InventoryDate = $request->input('inventory_date');

            $location_val_data = Locations::find($LocationValData);
            if (! empty($location_val_data)) {
                $LocationName = $location_val_data->location;
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
                ->orderBy('category.category_name', 'asc')             // if($location_selected_name !=''){
                ->orderBy('master_kitchen_inventory.item_name', 'asc') // Order by category name first
                ->get()
                ->groupBy('category_name');
// Then order by item name
            // dd($user_data);
            return view('kitchen-inventory-history', compact('locationsData', 'user_data', 'data_location_wise_inventory'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function getInventorySubmitHistory(Request $request)
    {
        try {
            $LocationValData = $request->input('location_id');
            $DateValData     = $request->input('inventory_date');

            $locationsData = Locations::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'location')
                ->orderBy('location', 'asc')
                ->get()
                ->toArray();

            $location_val_data = Locations::find($LocationValData);
            $LocationName      = $location_val_data->location;

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
                ->orderBy('category.category_name', 'asc')             // }
                ->orderBy('master_kitchen_inventory.item_name', 'asc') // Order by category name first
                ->get()
                ->groupBy('category_name');

// Then order by item name
            // dd($user_data);
// Get raw SQL query
// $sql = $query->toSql();
// $bindings = $query->getBindings();
            // dd($query);
            return view('kitchen-inventory-history', compact('locationsData', 'user_data', 'LocationName', 'DateValData'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function searchShoppingList(Request $request)
    {
        try {
            $query                = $request->input('query');
            $location_selected_id = session()->get('location_selected_id');
            // Return the user listing Blade with the search results (no full page reload)
            // Modify the query to search users based on name, email, or phone
            // $user_data = UsersData::where('name', 'like', "%$query%")
            //                  ->orWhere('email', 'like', "%$query%")
            //                  ->orWhere('phone', 'like', "%$query%")

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
                                                                   //                  ->get();
                ->orderBy('category.category_name', 'asc')             // ->where('location_wise_inventory.approved_by', '1')
                ->orderBy('master_kitchen_inventory.item_name', 'asc') // Order by category name first
                ->get()
                ->groupBy('category_name');

            // Then order by item name
            return view('shopping-list-search-results', compact('data_location_wise_inventory'))->render();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function SearchUpdateKitchenInventorySuperAdmin(Request $request)
    {
        try {
            $query                = $request->input('query');
            $sess_user_id         = session()->get('login_id');
            $location_selected_id = session()->get('location_selected_id');

            if (empty($location_selected_id)) {
                return response()->json(['error' => 'Location not selected'], 400);
            }

            // Return the user listing Blade with the search results (no full page reload)
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

            // Fetch existing inventory for the selected location
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

            // Fetch newly added items that are not in location-wise inventory
            foreach ($new_master_inventory_items as $category => $items) {
                if (isset($data_location_wise_inventory[$category])) {
                    $data_location_wise_inventory[$category] = $data_location_wise_inventory[$category]->merge($items);
                } else {
                    $data_location_wise_inventory[$category] = $items;
                }
            }

            $InventoryData = [
                'data_location_wise_inventory' => $data_location_wise_inventory,
                'DataType'                     => count($data_location_wise_inventory) > 0 ? 'LocationWiseData' : 'MasterData',
            ];

            return view('update-kitchen-inventory-search-result', compact('InventoryData'))->render();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
