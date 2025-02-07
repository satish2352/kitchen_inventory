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
        $locations_data = $this->service->index();
        // dd($projects);
        return view('location',compact('locations_data'));
    }

    public function addLocation(Request $request)
    {

        try {

            $rules = [
                'location' => 'required|unique:locations|max:255',
                // 'role' => 'required'
            ];
            $messages = [
                'location.required' => 'Please  enter location name.',
                // 'location.regex' => 'Please  enter text only.',
                'location.max' => 'Please  enter text length upto 255 character only.',
                'location.unique' => 'Title already exist.',

                // 'role.required' => 'Please Select Role.'
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

                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        return redirect('list-locations');
                    } else {
                        return redirect('list-locations')->withInput();
                    }
                }

            }
        } catch (Exception $e) {
            return redirect('list-locations')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function editLocation(Request $request){
        $location_data = $this->service->editLocation($request);
        // Log::info('This is an informational message.',$location_data);
        return response()->json(['location_data' => $location_data]);
    }

    public function updateLocation(Request $request){
        $rules = [
            'location' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
            // 'role' => 'required'
        ];
        $messages = [
            'location.required' => 'Please  enter location name.',
            'location.regex' => 'Please  enter text only.',
            'location.max' => 'Please  enter text length upto 255 character only.',
            // 'role.required' => 'Please Select Role.'
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

                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if($status=='success') {
                        return redirect('list-locations');
                    }
                    else {
                        return redirect('list-locations')->withInput();
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
                session()->flash('alert_status', $status);
                session()->flash('alert_msg', $msg);
                if ($status == 'success') {
                    
                    return redirect('list-locations');
                } else {
                    return redirect()->back()
                        ->withInput();
                }
            }
        } catch (\Exception $e) {
            // return $e;
            session()->flash('alert_status', 'error');
            session()->flash('alert_msg', $e->getMessage());
    
            return redirect()->back();
        }
    }

    public function searchLocation(Request $request)
    {
        $query = $request->input('query');
        
        // Modify the query to search users based on name, email, or phone
        $locations_data = Locations::where('location', 'like', "%$query%")
                        ->get();

        // Return the user listing Blade with the search results (no full page reload)
        return view('location-search-results', compact('locations_data'))->render();
    }

}