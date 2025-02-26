<?php
namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\UserRepository;

class UserServices
{
    protected $repo;

    /**
     * TopicService constructor.
     */
    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function index()
    {
        try {
            $data_users = $this->repo->getUsersList();
            // dd($data_users);
            return $data_users;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function addUser($request)
    {
        try {

            $last_id = $this->repo->addUser($request);
            if ($last_id) {
                return ['status' => 'success', 'msg' => 'User Added Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'User get Not Added.'];
            }
            // }
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }

    public function editUser($request)
    {
        try {
            $data_location = $this->repo->editUser($request);
            // dd($data_location);
            return $data_location;
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function updateUser($request)
    {
        try {
            $user_register_id = $this->repo->updateUser($request);
            return ['status' => 'success', 'msg' => 'User Updated Successfully.'];
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            $delete = $this->repo->deleteUser($id);
            if ($delete) {
                return ['status' => 'success', 'msg' => 'User Deleted Successfully.'];
            } else {
                return ['status' => 'error', 'msg' => 'User Not Deleted.'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }
    }
}
