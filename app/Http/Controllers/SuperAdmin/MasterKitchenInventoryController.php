<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\MasterKitchenInventoryServices;
use App\Models\ {
    Category,
    Locations,
    MasterKitchenInventory,
    Unit,
    UsersData
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterKitchenInventoryController extends Controller
{
    public function __construct()
    {
        $this->service = new MasterKitchenInventoryServices();
    }

    public function index()
    {
        try {
            $sess_user_id = session()->get('login_id');
            $user_data    = $this->service->index();

            $categoryData = Category::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'category_name')
                ->get()
                ->toArray();

            $unitData = Unit::where('is_active', '1')
                ->where('is_deleted', '0')
                ->select('id', 'unit_name')
                ->get()
                ->toArray();

            $role = session()->get('user_role');
            if($role == 2) {
                $all_locations = explode(',', session()->get('locations_all'));
                $locationsData = Locations::where('is_active', '1');
                $locationsData =  $locationsData->whereIn('id', $all_locations);
                $locationsData =  $locationsData->where('is_deleted', '0')
                                        ->select('id', 'location')
                                        ->orderBy('location', 'asc')
                                        ->get()
                                        ->toArray();

            } else {
                $locationsData = Locations::where('is_active', '1')
                                ->where('is_deleted', '0')
                                ->select('id', 'location')
                                ->orderBy('location', 'asc')
                                ->get()
                                ->toArray();

            }
          

            return view('master-inventory', compact('user_data', 'unitData', 'categoryData', 'locationsData'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addItem(Request $request)
    {
        try {
            $rules = [
                'item_name' => 'required|string|max:255',
                'category'  => 'required',
                // 'quantity' => 'required',
                'unit'      => 'required',
                'price'     => 'required',
            ];
            $messages = [
                // Custom validation messages
                'item_name.required' => 'First item_name is required.',
                'item_name.string'   => 'First item_name must be a string.',
                'item_name.max'      => 'First item_name should not exceed 255 characters.',
                'category.required'  => 'Location is required.',
                // 'quantity.required' => 'Role is required.',
                'unit.required'      => 'Contact Details are required.',
                'price.required'     => 'Email is required.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('list-items')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addItem($request);
                if ($add_role) {
                    $msg    = $add_role['msg'];
                    $status = $add_role['status'];

                    // Store SweetAlert data in session for flashing
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        return redirect('list-items');
                    } else {
                        return redirect('list-items')->withInput();
                    }
                }
            }
        } catch (Exception $e) {
            return redirect('list-items')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function editItem(Request $request)
    {
        try {
            $user_data = $this->service->editItem($request);
            // Log::info('This is an informational message.',$user_data);
            return response()->json(['user_data' => $user_data]);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateItem(Request $request)
    {
        try {
            $rules = [
                'item_name' => 'required|string|max:255',
                'category'  => 'required',
                // 'quantity' => 'required',
                'unit'      => 'required',
                'price'     => 'required',
            ];
            $messages = [
                // Custom validation messages
                'item_name.required' => 'First item_name is required.',
                'item_name.string'   => 'First item_name must be a string.',
                'item_name.max'      => 'First item_name should not exceed 255 characters.',
                'category.required'  => 'Location is required.',
                // 'quantity.required' => 'Role is required.',
                'unit.required'      => 'Contact Details are required.',
                'price.required'     => 'Email is required.',
            ];
            try {
                $validation = Validator::make($request->all(), $rules, $messages);
                if ($validation->fails()) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validation);
                } else {
                    $register_user = $this->service->updateItem($request);

                    if ($register_user) {
                        $msg    = $register_user['msg'];
                        $status = $register_user['status'];

                        // Store SweetAlert data in session for flashing
                        session()->flash('alert_status', $status);
                        session()->flash('alert_msg', $msg);
                        if ($status == 'success') {
                            return redirect('list-items');
                        } else {
                            return redirect('list-items')->withInput();
                        }
                    }
                }
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(['msg' => $e->getMessage(), 'status' => 'error']);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function deleteItem(Request $request)
    {
        try {
            // dd($request);
            $delete = $this->service->deleteItem($request->delete_id);
            if ($delete) {
                $msg    = $delete['msg'];
                $status = $delete['status'];

                // Store SweetAlert data in session
                session()->flash('alert_status', $status);
                session()->flash('alert_msg', $msg);

                return redirect('list-items');

                // if ($status == 'success') {
                //     return redirect('list-items')->with(compact('msg', 'status'));
                // } else {
                //     return redirect()->back()
                //         ->withInput()
                //         ->with(compact('msg', 'status'));
                // }
            }
        } catch (\Exception $e) {
            session()->flash('alert_status', 'error');
            session()->flash('alert_msg', $e->getMessage());

            return redirect()->back();
            // return $e;
        }
    }

    public function searchMasterKitchenInventory(Request $request)
    {
        try {
            $query = $request->input('query');

            $user_data = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
                ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
                ->select(
                    'master_kitchen_inventory.id',
                    'master_kitchen_inventory.category',
                    'master_kitchen_inventory.item_name',
                    'master_kitchen_inventory.unit',
                    'master_kitchen_inventory.price',
                    'master_kitchen_inventory.quantity',
                    'master_kitchen_inventory.created_at',
                    'category.category_name',
                    'units.unit_name'
                )
                ->where('master_kitchen_inventory.location_id', session()->get('location_selected_id'))
                ->where('master_kitchen_inventory.is_deleted', '0')
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($subQuery) use ($query) {
                        $subQuery
                            ->where('master_kitchen_inventory.item_name', 'like', "%$query%")
                            ->orWhere('category.category_name', 'like', "%$query%")
                            ->orWhere('units.unit_name', 'like', "%$query%");
                    });
                })
                ->orderBy('category.category_name', 'asc')             // Order by category name first
                ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
                ->get()
                ->groupBy('category_name'); // Group items by category name

            // Return the user listing Blade with the search results (no full page reload)
            return view('master-kitchen-inventory-search-results', compact('user_data'))->render();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function copyMasterInventory(Request $request)
    {
        try {
            $rules = [
                'from_location_id' => 'required',
                'to_location_id'   => 'required',
            ];
            $messages = [
                'from_location_id.required' => 'From location is required.',
                'to_location_id.required'   => 'To location is required.',
            ];

            try {
                $validation = Validator::make($request->all(), $rules, $messages);
                if ($validation->fails()) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors($validation);
                }

                $register_user = $this->service->copyMasterInventory($request);

                session()->flash('alert_status', $register_user['status']);
                session()->flash('alert_msg', $register_user['msg']);

                if ($register_user['status'] === 'success') {
                    return redirect('list-items');
                } else {
                    return redirect()->back()->withInput();
                }
            } catch (Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(['msg' => $e->getMessage(), 'status' => 'error']);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
