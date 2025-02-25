<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Services\SuperAdmin\LocationServices;
use Illuminate\Validation\Rule;

use App\Models\ {
    Locations
};
use Validator;
use session;
use Config;

class ChangePasswordController extends Controller {

    public function __construct()
    {
        // $this->service = new LocationServices();
    }

    public function index()
    {
        // $locations_data = $this->service->index();
        // dd($projects);
        return view('change-password');
    }

}