<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\UnitServices;
use App\Models\Unit;use Config;use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use session;

class UnitController extends Controller
{

    public function __construct()
    {
        $this->service = new UnitServices();
    }

    public function index()
    {
        try {
            $unit_data = $this->service->index();
            // dd($projects);
            return view('manage-units', compact('unit_data'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function AddUnit(Request $request)
    {
        try {
            $rules = [
                'unit_name' => [
                    'required',
                    'max:255',
                    Rule::unique('units')->where(function ($query) {
                        return $query->where('is_deleted', 0);
                    }),
                ],
            ];

            $messages = [
                'unit_name.required' => 'Please enter Unit Name.',
                'unit_name.max'      => 'Unit Name should not exceed 255 characters.',
                'unit_name.unique'   => 'Unit Name already exists.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            if ($validation->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validation->errors(),
                ], 422);
            }

            // Validation passed, insert into database
            $add_unit = $this->service->addUnit($request);

            if ($add_unit) {
                $msg    = $add_unit['msg'];
                $status = $add_unit['status'];
                session()->flash('alert_status', $status);
                session()->flash('alert_msg', $msg);
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Unit added successfully!',
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong.',
            ], 500);

        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function editUnit(Request $request)
    {
        try {
            $unit_data = $this->service->editUnit($request);
            // Log::info('This is an informational message.',$unit_data);
            return response()->json(['unit_data' => $unit_data]);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateUnit(Request $request)
    {
        try {
            $rules = [
                'unit_name' => 'required|max:255',
            ];
            $messages = [
                'unit_name.required' => 'Please  enter location name.',
                'unit_name.max'      => 'Please  enter text length upto 255 character only.',
            ];
            try {
                $validation = Validator::make($request->all(), $rules, $messages);
                if ($validation->fails()) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors($validation);
                } else {
                    $register_user = $this->service->updateUnit($request);

                    if ($register_user) {

                        $msg    = $register_user['msg'];
                        $status = $register_user['status'];

                        session()->flash('alert_status', $status);
                        session()->flash('alert_msg', $msg);
                        if ($status == 'success') {
                            return redirect('list-units');
                        } else {
                            return redirect('list-units')->withInput();
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

    public function deleteUnit(Request $request)
    {
        try {
            $delete = $this->service->deleteUnit($request->delete_id);
            if ($delete) {
                $msg    = $delete['msg'];
                $status = $delete['status'];

                session()->flash('alert_status', $status);
                session()->flash('alert_msg', $msg);
                if ($status == 'success') {
                    return redirect('list-units')->with(compact('msg', 'status'));
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->with(compact('msg', 'status'));
                }
            }
        } catch (\Exception $e) {
            // return $e;
            session()->flash('alert_status', 'error');
            session()->flash('alert_msg', $e->getMessage());

            return redirect()->back();
        }
    }

    public function searchUnit(Request $request)
    {
        try {
            $query = $request->input('query');

            // Modify the query to search users based on name, email, or phone
            $unit_data = Unit::where('unit_name', 'like', "%$query%")
                ->where('is_deleted', '0')
                ->get();

            // Return the user listing Blade with the search results (no full page reload)
            return view('unit-search-results', compact('unit_data'))->render();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

}
