<?php
namespace App\Http\Services\SuperAdmin;

use App\Http\Repository\SuperAdmin\UnitRepository;

class UnitServices
{

    protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct()
    {
        $this->repo = new UnitRepository();
    }

    public function index()
    {
        try {
            $data_location = $this->repo->getUnitList();
            // dd($data_location);
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addUnit($request)
    {
        try {

            // $chk_dup = $this->repo->addLocationCheck($request);
            // if(sizeof($chk_dup)>0)
            // {
            //     return ['status'=>'failed','msg'=>'The Unit name has already been taken.'];
            // }
            // else
            // {
            $last_id = $this->repo->addUnit($request);
            // dd($last_id);
            if ($last_id) {
                return ['status' => 'success', 'msg' => 'Unit Added Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Unit get Not Added.'];
            }
            // }

        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    public function editUnit($request)
    {
        try {
            $data_location = $this->repo->editUnit($request);
            // dd($data_location);
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateUnit($request)
    {
        try {
            $user_register_id = $this->repo->updateUnit($request);
            return ['status' => 'success', 'msg' => 'Unit Updated Successfully.'];
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function deleteUnit($id)
    {
        try {
            $delete = $this->repo->deleteUnit($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'Unit Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'Unit Not Deleted.'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }
}
