<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\ItemsServices;
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

class ItemsController extends Controller {

    public function __construct()
    {
        $this->service = new ItemsServices();
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
                'quantity' => 'required',
                'unit' => 'required',
                'price' => 'required'
            ];
            $messages = [

                // Custom validation messages
            'item_name.required' => 'First item_name is required.',
            'item_name.string' => 'First item_name must be a string.',
            'item_name.max' => 'First item_name should not exceed 255 characters.',
            
            'category.required' => 'Location is required.',
            'quantity.required' => 'Role is required.',

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
                    if ($status == 'success') {
                        return redirect('list-items')->with(compact('msg', 'status'));
                    } else {
                        return redirect('list-items')->withInput()->with(compact('msg', 'status'));
                    }
                }

            }
        } catch (Exception $e) {
            return redirect('list-items')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function editUser(Request $request){
        $user_data = $this->service->editUser($request);
        // Log::info('This is an informational message.',$user_data);
        return response()->json(['user_data' => $user_data]);
    }

    public function updateUser(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required',
            'role' => 'required',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'password' => 'required',
        ];
        $messages = [

            // Custom validation messages
        'name.required' => 'First Name is required.',
        'name.string' => 'First Name must be a string.',
        'name.max' => 'First Name should not exceed 255 characters.',
        
        'location.required' => 'Location is required.',
        'role.required' => 'Role is required.',

        'phone.required' => 'Contact Details are required.',
        'phone.string' => 'Contact Details must be a string.',
        'phone.max' => 'Contact Details should not exceed 15 characters.',
        
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be a valid email address.',
        'email.max' => 'Email should not exceed 255 characters.',

        'password.required' => 'Please  enter category_name name.',
        ];
        try {
            $validation = Validator::make($request->all(),$rules, $messages);
            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateUser($request);

                if($register_user)
                {
                
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];
                    if($status=='success') {
                        return redirect('list-users')->with(compact('msg','status'));
                    }
                    else {
                        return redirect('list-users')->withInput()->with(compact('msg','status'));
                    }
                }  
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }

    }

    public function deleteUser(Request $request){
        try {
            // dd($request);
            $delete = $this->service->deleteUser($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
                $status = $delete['status'];
                if ($status == 'success') {
                    return redirect('list-users')->with(compact('msg', 'status'));
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with(compact('msg', 'status'));
                }
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

}