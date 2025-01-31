<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\UnitServices;
use App\Models\ {
    Locations,
    Category,
    Unit
};
use Validator;
use session;
use Config;

class UnitController extends Controller {

    public function __construct()
    {
        $this->service = new UnitServices();
    }

    public function index()
    {
        $unit_data = $this->service->index();
        // dd($projects);
        return view('manage-units',compact('unit_data'));
    }

    public function AddUnit(Request $request)
    {

        try {

            $rules = [
                'unit_name' => 'required|unique:units|max:255'
            ];
            $messages = [
                'unit_name.required' => 'Please  enter category_name name.',
                'unit_name.max' => 'Please  enter text length upto 255 character only.',
                'unit_name.unique' => 'Title already exist.'
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('list-units')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addUnit($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
                    $status = $add_role['status'];
                    if ($status == 'success') {
                        return redirect('list-units')->with(compact('msg', 'status'));
                    } else {
                        return redirect('list-units')->withInput()->with(compact('msg', 'status'));
                    }
                }

            }
        } catch (Exception $e) {
            return redirect('list-units')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function editUnit(Request $request){
        $unit_data = $this->service->editUnit($request);
        // Log::info('This is an informational message.',$unit_data);
        return response()->json(['unit_data' => $unit_data]);
    }

    public function updateUnit(Request $request){
        $rules = [
            'unit_name' => 'required|max:255',
        ];
        $messages = [
            'unit_name.required' => 'Please  enter location name.',
            'unit_name.max' => 'Please  enter text length upto 255 character only.'
        ];
        try {
            $validation = Validator::make($request->all(),$rules, $messages);
            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateUnit($request);

                if($register_user)
                {
                
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];
                    if($status=='success') {
                        return redirect('list-units')->with(compact('msg','status'));
                    }
                    else {
                        return redirect('list-units')->withInput()->with(compact('msg','status'));
                    }
                }  
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }

    }

    public function deleteUnit(Request $request){
        try {
            $delete = $this->service->deleteUnit($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
                $status = $delete['status'];
                if ($status == 'success') {
                    return redirect('list-category')->with(compact('msg', 'status'));
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