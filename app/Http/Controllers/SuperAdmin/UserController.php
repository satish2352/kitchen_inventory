<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\UserServices;
use App\Models\{
    Locations,
    Category,
    Unit,
    User,
    UsersData
};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Config;
use session;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->service = new UserServices();
    }

    public function index()
    {
        $user_data = $this->service->index();

        $locationsData = Locations::where('is_active', '1')
            ->where('is_deleted', '0')
            ->select('id', 'location')
            ->orderBy('location', 'asc')
            ->paginate(10);

        return view('users', compact('user_data', 'locationsData'));
    }

    public function addUser(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'location' => 'required|array',
                'role' => 'required',
                // 'phone' => 'required|string|max:15',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users_data')->where(function ($query) {
                        return $query->where('is_deleted', 0);
                    }),
                ],
                'password' => 'required',
            ];

            $messages = [
                'name.required' => 'First Name is required.',
                'location.required' => 'Location is required.',
                'role.required' => 'Role is required.',
                // 'phone.required' => 'Contact Details are required.',
                'email.required' => 'Email is required.',
                'email.unique' => 'This email is already registered and active.',
                'password.required' => 'Password is required.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            if ($validation->fails()) {
                // Stop execution and return validation errors
                return response()->json([
                    'status' => 'error',
                    'errors' => $validation->errors()
                ], 422);
            }

            // Validation passed, insert into database
            $add_role = $this->service->addUser($request);

            if ($add_role) {
                $msg = $add_role['msg'];
                $status = $add_role['status'];
                session()->flash('alert_status', $status);
                session()->flash('alert_msg', $msg);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User added successfully!'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.'
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function editUser(Request $request)
    {
        $user_data = $this->service->editUser($request);
        // Log::info('This is an informational message.',$user_data);
        return response()->json(['user_data' => $user_data]);
    }

    public function updateUser(Request $request)
    {
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
            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateUser($request);

                if ($register_user) {
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        return redirect('list-users');
                    } else {
                        return redirect('list-users')->withInput();
                    }
                }
            }
        } catch (Exception $e) {
            session()->flash('alert_status', $status);
            session()->flash('alert_msg', $msg);
            return redirect()
                ->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            // dd($request);
            $delete = $this->service->deleteUser($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
                $status = $delete['status'];

                if ($status == 'success') {
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    return redirect('list-users');
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(compact('msg', 'status'));
                }
            }
        } catch (\Exception $e) {
            session()->flash('alert_status', 'error');
            session()->flash('alert_msg', $e->getMessage());

            return redirect()->back();
            // return $e;
        }
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');

        // Modify the query to search users based on name, email, or phone
        $user_data = UsersData::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone', 'like', "%$query%")
            ->get();

        // Return the user listing Blade with the search results (no full page reload)
        return view('users-search-results', compact('user_data'))->render();
    }

    public function getApproveUsers()
    {
        $user_data = $this->service->getApproveUsers();

        $locationsData = Locations::where('is_active', '1')
            ->where('is_deleted', '0')
            ->where('is_deleted', '0')
            ->select('id', 'location')
            ->orderBy('location', 'asc')
            // ->get()
            ->paginate(10);
        // ->toArray();
        // dd($projects);
        return view('approve-users', compact('user_data', 'locationsData'));
    }

    public function updateOne(Request $request)
    {
        try {
            $active_id = $request->activid;
            $result = $this->service->updateOne($active_id);

            $msg = $result['msg'];
            $status = $result['status'];
            session()->flash('alert_status', $status);
            session()->flash('alert_msg', $msg);
            return redirect('list-approve-users');
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function updateApproveUserAllData(Request $request)
    {
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
            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateApproveUserAllData($request);

                if ($register_user) {
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        return redirect('list-approve-users');
                    } else {
                        return redirect('list-approve-users')->withInput();
                    }
                }
            }
        } catch (Exception $e) {
            session()->flash('alert_status', $status);
            session()->flash('alert_msg', $msg);
            return redirect()
                ->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function deleteApproveUser(Request $request)
    {
        try {
            // dd($request);
            $delete = $this->service->deleteApproveUser($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
                $status = $delete['status'];

                if ($status == 'success') {
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    return redirect('list-approve-users');
                } else {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(compact('msg', 'status'));
                }
            }
        } catch (\Exception $e) {
            session()->flash('alert_status', 'error');
            session()->flash('alert_msg', $e->getMessage());

            return redirect()->back();
            // return $e;
        }
    }
}
