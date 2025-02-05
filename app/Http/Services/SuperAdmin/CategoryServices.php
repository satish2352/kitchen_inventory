<?php
namespace App\Http\Services\SuperAdmin;

use App\Http\Repository\SuperAdmin\CategoryRepository;


use App\Models\
{ User };
use Carbon\Carbon;
use Config;
use Storage;

class CategoryServices
{

	protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct() {
        $this->repo = new CategoryRepository();
    }

    public function index() {
        $data_location = $this->repo->getCategoryList();
        // dd($data_location);
        return $data_location;
    }

    public function addCategory($request){
        try {

            // $chk_dup = $this->repo->addLocationCheck($request);
            // if(sizeof($chk_dup)>0)
            // {
            //     return ['status'=>'failed','msg'=>'The Category name has already been taken.'];
            // }
            // else
            // {
                $last_id = $this->repo->addCategory($request);
                // dd($last_id);
                if ($last_id) {
                    return ['status' => 'success', 'msg' => 'Category Added Successfully.'];
                } else {
                    return ['status' => 'error', 'msg' => 'Category get Not Added.'];
                }  
            // }

        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
            }      
    }

    public function editCategory($request) {
        $data_location = $this->repo->editCategory($request);
        // dd($data_location);
        return $data_location;
    }

    public function updateCategory($request) {
        $user_register_id = $this->repo->updateCategory($request);
        return ['status'=>'success','msg'=>'Category Updated Successfully.'];
    }

    public function deleteCategory($id){
        try {
            $delete = $this->repo->deleteCategory($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'Category Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Category Not Deleted.'];
            }  
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        } 
    }
}    