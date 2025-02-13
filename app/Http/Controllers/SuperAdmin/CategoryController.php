<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\SuperAdmin\CategoryServices;
use App\Models\ {
    Locations,
    Category
};
use Validator;
use session;
use Config;

class CategoryController extends Controller {

    public function __construct()
    {
        $this->service = new CategoryServices();
    }

    public function index()
    {
        $category_data = $this->service->index();
        // dd($projects);
        return view('category',compact('category_data'));
    }

    public function AddCategory(Request $request)
    {

       
        try {
            $rules = [
                'category_name' => 'required|unique:category|max:255'
            ];
            $messages = [
                'category_name.required' => 'Please enter category name.',
                'category_name.max' => 'Please enter text length up to 255 characters only.',
                'category_name.unique' => 'Category name already exists.'
            ];
    
            $validation = Validator::make($request->all(), $rules, $messages);
            
            if ($validation->fails()) {
                // Return validation errors as JSON
                return response()->json(['errors' => $validation->errors()], 422);
            } else {
                $add_role = $this->service->addCategory($request);
                if ($add_role) {
                    $msg = $add_role['msg'];
                    $status = $add_role['status'];
                    
                    if ($status == 'success') {
                        return response()->json(['status' => 'success', 'msg' => $msg]);
                    } else {
                        return response()->json(['status' => 'error', 'msg' => $msg]);
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }
    

    public function editCategory(Request $request){
        $category_data = $this->service->editCategory($request);
        // Log::info('This is an informational message.',$category_data);
        return response()->json(['category_data' => $category_data]);
    }

    public function updateCategory(Request $request){
        $rules = [
            'category_name' => 'required|max:255',
        ];
        $messages = [
            'location.required' => 'Please  enter location name.',
            'category_name.max' => 'Please  enter text length upto 255 character only.'
        ];
        try {
            $validation = Validator::make($request->all(),$rules, $messages);
            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation);
            } else {
                $register_user = $this->service->updateCategory($request);

                if($register_user)
                {
                
                    $msg = $register_user['msg'];
                    $status = $register_user['status'];
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    if($status=='success') {
                        return redirect('list-category');
                    }
                    else {
                        return redirect('list-category')->withInput();
                    }
                }  
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }

    }

    public function deleteCategory(Request $request){
        try {
            $delete = $this->service->deleteCategory($request->delete_id);
            if ($delete) {
                $msg = $delete['msg'];
                $status = $delete['status'];
                if ($status == 'success') {
                    session()->flash('alert_status', $status);
                    session()->flash('alert_msg', $msg);
                    return redirect('list-category');
                    // return redirect('list-category')->with(compact('msg', 'status'));
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

    public function searchCategory(Request $request)
{
    $query = $request->input('query');
    
    // Modify the query to search users based on name, email, or phone
    $category_data = Category::where('category_name', 'like', "%$query%")
                     ->get();

    // Return the user listing Blade with the search results (no full page reload)
    return view('category-search-results', compact('category_data'))->render();
}

}