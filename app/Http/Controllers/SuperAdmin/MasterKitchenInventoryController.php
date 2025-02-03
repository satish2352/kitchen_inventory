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
    Items
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
        // dd($projects);
        return view('master-inventory',compact('user_data','unitData','categoryData'));
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

}