<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\MasterKitchenInventoryServices;
use App\Models\ {
    Locations,
    Category,
    Unit,
    User,
    Items,
    MasterKitchenInventory
};
use Validator;
use session;
use Config;

class MasterKitchenInventoryController extends Controller {

    public function __construct()
    {
        $this->service = new MasterKitchenInventoryServices();
    }

    public function index()
    {
        $user_data = $this->service->index();

        $categoryData = Category::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->select('id','category_name')
                            ->get()
                            ->toArray();

        $unitData = Unit::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->select('id','unit_name')
                            ->get()
                            ->toArray();

        $locationsData = Locations::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->select('id','location')
                            ->orderBy('location', 'asc')
                            ->get()
                            ->toArray();
        // dd($projects);
        return view('master-inventory',compact('user_data','unitData','categoryData','locationsData'));
    }

    public function addItem(Request $request)
    {

        try {

            $rules = [
                'item_name' => 'required|string|max:255',
                'category' => 'required',
                // 'quantity' => 'required',
                'unit' => 'required',
                'price' => 'required'
            ];
            $messages = [

                // Custom validation messages
            'item_name.required' => 'First item_name is required.',
            'item_name.string' => 'First item_name must be a string.',
            'item_name.max' => 'First item_name should not exceed 255 characters.',
            
            'category.required' => 'Location is required.',
            // 'quantity.required' => 'Role is required.',

            'unit.required' => 'Contact Details are required.',
            
            'price.required' => 'Email is required.'
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('list-items')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addItem($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
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

    public function editItem(Request $request){
        $user_data = $this->service->editItem($request);
        // Log::info('This is an informational message.',$user_data);
        return response()->json(['user_data' => $user_data]);
    }

    public function updateItem(Request $request){
        $rules = [
            'item_name' => 'required|string|max:255',
            'category' => 'required',
            // 'quantity' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ];
        $messages = [

            // Custom validation messages
            'item_name.required' => 'First item_name is required.',
            'item_name.string' => 'First item_name must be a string.',
            'item_name.max' => 'First item_name should not exceed 255 characters.',
            
            'category.required' => 'Location is required.',
            // 'quantity.required' => 'Role is required.',

            'unit.required' => 'Contact Details are required.',
            
            'price.required' => 'Email is required.'
        ];
        try {
            $validation = Validator::make($request->all(),$rules, $messages);
            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateItem($request);

                if($register_user)
                {
                
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];

                     // Store SweetAlert data in session for flashing
                session()->flash('alert_status', $status);
                session()->flash('alert_msg', $msg);
                    if($status=='success') {
                        return redirect('list-items');
                    }
                    else {
                        return redirect('list-items')->withInput();
                    }
                }  
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }

    }

    public function deleteItem(Request $request){
        try {
            // dd($request);
            $delete = $this->service->deleteItem($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
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
        $query = $request->input('query');
        
        // Modify the query to search users based on name, email, or phone
        // $unit_data = Unit::where('unit_name', 'like', "%$query%")
        //                     ->where('is_deleted', '0')
        //                 ->get();

    $user_data = MasterKitchenInventory::leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
        ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
        ->select(
            'master_kitchen_inventory.id',
            'master_kitchen_inventory.category',
            'master_kitchen_inventory.item_name',
            'master_kitchen_inventory.unit',
            'master_kitchen_inventory.price',
            'master_kitchen_inventory.created_at',
            'category.category_name',
            'units.unit_name'
        )
        ->where('master_kitchen_inventory.is_deleted', '0')
        ->when($query, function ($q) use ($query) {
            $q->where(function ($subQuery) use ($query) {
                $subQuery->where('master_kitchen_inventory.item_name', 'like', "%$query%")
                    ->orWhere('category.category_name', 'like', "%$query%")
                    ->orWhere('units.unit_name', 'like', "%$query%");
            });
        })
        ->orderBy('category.category_name', 'asc') // Order by category name first
        ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
        ->get()
        ->groupBy('category_name'); // Group items by category name

        // Return the user listing Blade with the search results (no full page reload)
        return view('master-kitchen-inventory-search-results', compact('user_data'))->render();
    }

}