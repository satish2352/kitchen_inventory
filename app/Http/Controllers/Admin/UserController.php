<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Admin\UserServices;
use App\Models\ {
    Locations,
    Category,
    Unit,
    User,
    UsersData
};
use Validator;
use session;
use Config;

class UserController extends Controller {

    public function __construct()
    {
        $this->service = new UserServices();
    }

    public function index()
    {
        $user_data = $this->service->index();
        $sess_user_id = session()->get('login_id');
        // Extract location IDs from users
        $locationIds = UsersData::whereNotNull('location')
        ->where('id', $sess_user_id)
        ->pluck('location')
        ->toArray();
// dd($locationIds);
        // Flatten and get unique location IDs
        $locationIds = collect($locationIds)
            ->map(fn($ids) => explode(',', $ids))
            ->flatten()
            ->unique()
            ->toArray();

        // Get only associated locations
        $locationsData = Locations::whereIn('id', $locationIds)
        ->where('is_active', '1')
        ->where('is_deleted', '0')
        ->select('id', 'location')
        ->orderBy('location', 'asc')
        ->get()
        ->toArray();

        
        // $locationsData = Locations::where('is_active', '1')
        //                     ->where('is_deleted', '0')
        //                     ->select('id','location')
        //                     ->orderBy('location', 'asc')
        //                     ->get()
        //                     ->toArray();
        // dd($locationsData);
        // dd($projects);
        return view('admin.users',compact('user_data','locationsData'));
    }

    public function addUser(Request $request)
    {

        try {

            $rules = [
                'name' => 'required|string|max:255',
                'location' => 'required|array',
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
            'location.array' => 'Invalid location format.',
            'role.required' => 'Role is required.',

            'phone.required' => 'Contact Details are required.',
            'phone.string' => 'Contact Details must be a string.',
            'phone.max' => 'Contact Details should not exceed 15 characters.',
            
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email should not exceed 255 characters.',

            'password.required' => 'Please  enter category_name name.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return redirect('list-admin-users')
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $add_role = $this->service->addUser($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
                    $status = $add_role['status'];
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if ($status == 'success') {
                        return redirect('list-admin-users');
                    } else {
                        return redirect('list-admin-users')->withInput();
                    }
                }

            }
        } catch (Exception $e) {
            return redirect('list-admin-users')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
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
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if($status=='success') {
                        return redirect('list-admin-users');
                    }
                    else {
                        return redirect('list-admin-users')->withInput();
                    }
                }  
            }

        } catch (Exception $e) {
            session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
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
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    return redirect('list-admin-users');
                } else {
                    return redirect()->back()
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
    return view('admin.users-search-results', compact('user_data'))->render();
}


}