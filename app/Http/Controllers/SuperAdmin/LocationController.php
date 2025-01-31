<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\LocationServices;
use App\Models\ {
    Locations
};
use Validator;
use session;
use Config;

class LocationController extends Controller {

    public function __construct()
    {
        $this->service = new LocationServices();
    }

    public function index()
    {
        $locations = $this->service->index();
        // dd($projects);
        return view('location',compact('locations'));
    }

    public function addLocation(Request $request)
    {

        try {

            $rules = [
                'location_name' => 'required|unique:locations|regex:/^[a-zA-Z\s]+$/u|max:255',
                'role' => 'required'
            ];
            $messages = [
                'location_name.required' => 'Please  enter location name.',
                'location_name.regex' => 'Please  enter text only.',
                'location_name.max' => 'Please  enter text length upto 255 character only.',
                'location_name.unique' => 'Title already exist.',

                'role.required' => 'Please Select Role.'
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('list-locations')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addLocation($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
                    $status = $add_role['status'];
                    if ($status == 'success') {
                        return redirect('list-locations')->with(compact('msg', 'status'));
                    } else {
                        return redirect('list-locations')->withInput()->with(compact('msg', 'status'));
                    }
                }

            }
        } catch (Exception $e) {
            return redirect('list-locations')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function editLocation(Request $request){
        $location_data = $this->service->editLocation($request);
        return view('admin.pages.projects.edit-projects',compact('location_data','dynamic_district'));
    }

    public function updateLocation(Request $request){
        $rules = [
            'location_name' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
            'role' => 'required'
        ];
        $messages = [
            'location_name.required' => 'Please  enter location name.',
            'location_name.regex' => 'Please  enter text only.',
            'location_name.max' => 'Please  enter text length upto 255 character only.',
            'role.required' => 'Please Select Role.'
        ];
        try {
            $validation = Validator::make($request->all(),$rules, $messages);
            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateLocation($request);

                if($register_user)
                {
                
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];
                    if($status=='success') {
                        return redirect('list-locations')->with(compact('msg','status'));
                    }
                    else {
                        return redirect('list-locations')->withInput()->with(compact('msg','status'));
                    }
                }  
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }

    }

    public function deleteLocation(Request $request){
        try {
            $delete = $this->service->deleteLocation($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
                $status = $delete['status'];
                if ($status == 'success') {
                    return redirect('list-locations')->with(compact('msg', 'status'));
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