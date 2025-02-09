<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\Manager\ShoppingListServices;
use App\Models\ {
    Items,
    Locations,
    LocationWiseInventory,
    MasterKitchenInventory,
    ActivityLog,
    InventoryHistory
};
use Session;
use Cookie;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ShoppingListController extends Controller
{
    public function __construct()
    {
        $this->service = new ShoppingListServices();

    }

    public function getLocationWiseInventory(Request $request) 
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
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');


        if(!empty($data_location_wise_inventory_new) && count($data_location_wise_inventory_new) > 0)
        {
            $InventoryData['data_location_wise_inventory']=$data_location_wise_inventory_new;
            $InventoryData['DataType']='LocationWiseData';
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
				'master_kitchen_inventory.quantity',
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
        
        return view('manager.kitchen-inventory', compact('all_kitchen_inventory','InventoryData'));
    }


    public function getLocationSelected(Request $request) 
    {
        $request->session()->put('location_selected', $request->location_selected);
        $final_location  = Locations::where('id',session('location_selected'))->first();
        $request->session()->put('location_selected_name', $final_location->location);
        $request->session()->put('location_selected_id', $final_location->id);
        return \Redirect::back();

    }

public function updateKitchenInventoryByManager(Request $request) {
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

        $register_user = $this->service->updateKitchenInventoryByManager($request);

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


public function addKitchenInventoryByManager(Request $request)
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
                $add_role = $this->service->addKitchenInventoryByManager($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
                    $status = $add_role['status'];
                    $pdfBase64 = $add_role['pdfBase64'];
                    // dd();

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

    public function getInventoryHistoryManager(Request $request) 
    {
        $sess_user_id = session()->get('login_id');
        $location_selected_name = session()->get('location_selected_name');
        $location_selected_id = session()->get('location_selected_id');

        if($location_selected_name !=''){

            $data_location_wise_inventory = InventoryHistory::leftJoin('locations', 'inventory_history.location_id', '=', 'locations.id')
            ->leftJoin('master_kitchen_inventory', 'inventory_history.inventory_id', '=', 'master_kitchen_inventory.id')
            ->leftJoin('units', 'master_kitchen_inventory.unit', '=', 'units.id')
            ->leftJoin('category', 'master_kitchen_inventory.category', '=', 'category.id')
            ->select(
                'inventory_history.id',
                'master_kitchen_inventory.category',
                'master_kitchen_inventory.item_name',
                'master_kitchen_inventory.unit',
                'master_kitchen_inventory.price',
                'inventory_history.quantity',
                'inventory_history.created_at',
                'inventory_history.id as locationWiseId',
                'category.category_name',
                'units.unit_name',
                'locations.location'
            )
            ->where('master_kitchen_inventory.location_id', $location_selected_id)
            ->where('master_kitchen_inventory.is_deleted', '0')
            ->where('inventory_history.approved_by', '3')
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');

        }    
        return view('manager.inventory-history', compact('data_inventory_history'));
    }

    public function getSubmitedShopppingListManager(Request $request) 
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
            // ->where('location_wise_inventory.approved_by', '3')
            ->orderBy('category.category_name', 'asc') // Order by category name first
            ->orderBy('master_kitchen_inventory.item_name', 'asc') // Then order by item name
            ->get()
            ->groupBy('category_name');

        }    
        return view('manager.kitchen-inventory-submited', compact('data_location_wise_inventory'));
    }
}
