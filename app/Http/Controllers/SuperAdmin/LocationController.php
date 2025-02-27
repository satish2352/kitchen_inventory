<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\LocationServices;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\{
    Locations
};

class LocationController extends Controller
{

    public function __construct()
    {
        $this->service = new LocationServices();
    }

    public function index()
    {
        try {
            $locations_data = $this->service->index();
            // dd($projects);
            return view('location', compact('locations_data'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addLocation(Request $request)
    {
        try {
            $rules = [
                'location' => [
                    'required',
                    'max:255',
                    Rule::unique('locations')->where(function ($query) {
                        return $query->where('is_deleted', 0); // Only check uniqueness for non-deleted locations
                    }),
                ],
            ];

            $messages = [
                'location.required' => 'Please enter location name.',
                'location.max'      => 'Please enter text length up to 255 characters only.',
                'location.unique'   => 'Location already exists.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            if ($validation->fails()) {
                // Return validation errors as a JSON response
                return response()->json(['errors' => $validation->errors()], 422);
            } else {
                // Assuming this is where you save the location
                $add_role = $this->service->addLocation($request);
                if ($add_role) {
                    $msg    = $add_role['msg'];
                    $status = $add_role['status'];

                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        return response()->json(['status' => 'success']);
                    } else {
                        return response()->json(['status' => 'error']);
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function editLocation(Request $request)
    {
        try {
            $location_data = $this->service->editLocation($request);
            // Log::info('This is an informational message.',$location_data);
            return response()->json(['location_data' => $location_data]);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateLocation(Request $request)
    {
        try {
            $rules = [
                'location' => 'required|regex:/^[a-zA-Z\s]+$/u|max:255',
                // 'role' => 'required'
            ];
            $messages = [
                'location.required' => 'Please  enter location name.',
                'location.regex'    => 'Please  enter text only.',
                'location.max'      => 'Please  enter text length upto 255 character only.',
                // 'role.required' => 'Please Select Role.'
            ];
            try {
                $validation = Validator::make($request->all(), $rules, $messages);
                if ($validation->fails()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors($validation);
                } else {
                    $register_user = $this->service->updateLocation($request);

                    if ($register_user) {

                        $msg    = $register_user['msg'];
                        $status = $register_user['status'];

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
                return redirect()->back()
                    ->withInput()
                    ->with(['msg' => $e->getMessage(), 'status' => 'error']);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }

    }

    public function deleteLocation(Request $request)
    {
        try {
            $delete = $this->service->deleteLocation($request->delete_id);
            if ($delete) {
                $msg    = $delete['msg'];
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
        try {
            $query = $request->input('query');

            // Search locations with pagination (10 items per page)
            $locations_data = Locations::where('location', 'like', "%$query%")
                ->where('is_deleted', 0)
                ->paginate(10);

            // Return the updated view with search results and pagination
            return view('location-search-results', compact('locations_data'))->render();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

}
