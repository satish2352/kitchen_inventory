<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
// For decryption
use App\Models\ {
    UsersData,
    Locations
}
;
use Session;
use Cookie;

class LoginController extends Controller {
    public function __construct() {
        // Constructor code here if necessary
    }

    public function index( Request $request )  {
        return view( 'login' );
    }

    public function submitLogin( Request $request )  {
        // Define the validation rules
        $rules = [
            'email' => 'required|exists:users_data,email|email', // Check if the user_name exists in the users_data table
            'password' => 'required',  // Make sure the password field is required
        ];

        // Define custom validation messages
        $messages = [
            'email.required' => 'Please Enter email id.',
            'email.exists' => 'The provided email does not exist.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'Please Enter Password.',
        ];

        $validation = Validator::make( $request->all(), $rules, $messages );

        if ( $validation->fails() ) {
            return redirect( '/' )
            ->withInput()
            ->withErrors( $validation );
        }

        try {
            $get_user = UsersData::where( 'email', $request[ 'email' ] )->first();
            if ( $get_user ) {
                $password = $request->password;
                $isApproved = $get_user[ 'is_approved' ];
                $decryptedPassword = $get_user[ 'password' ];
                $added_by = $get_user[ 'added_by' ];

                if ( $password == $decryptedPassword ) {
                    $request->session()->put( 'email', $get_user[ 'email' ] );
                    $request->session()->put( 'login_id', $get_user[ 'id' ] );
                    $request->session()->put( 'user_role', $get_user[ 'user_role' ] );
                    $request->session()->put( 'user_name', $get_user[ 'name' ] );
                    $request->session()->put( 'locations_all', $get_user[ 'location' ] );

                    if ( $get_user[ 'user_role' ] != 1 ) {
                        if ( count( explode( ',', $get_user[ 'location' ] ) )  > 1 ) {
                            $final_location  = Locations::whereIn( 'id', explode( ',', $get_user[ 'location' ] ) )
                            ->where('is_deleted', 0)
                            ->get()->toArray();
                            $request->session()->put( 'location_for_user', $final_location );
                        } else {

                            $request->session()->put( 'location_selected', rtrim( $get_user[ 'location' ], ',' ) );
                            $final_location  = Locations::where( 'id', session( 'location_selected' ) )
                            ->where('is_deleted', 0)
                            ->first();
                            $request->session()->put( 'location_selected_name', $final_location->location );
                            $request->session()->put( 'location_selected_id', $final_location->id );
                        }
                    } else {
                        $request->session()->put( 'location_selected_name', '' );
                        $request->session()->put( 'location_selected_id', '' );
                    }

                    $request->session()->regenerate();
                    return redirect( route( '/dashboard' ) );

                } else {
                    return redirect( '/' )
                    ->withInput()
                    ->withErrors( [ 'password' => 'You Entered Wrong Password' ] );
                }

            } else {
                return redirect( '/' )
                ->withInput()
                ->withErrors( [ 'user_name' => 'These credentials do not match our records.' ] );
            }

        } catch ( Exception $e ) {
            return redirect('feedback-suggestions')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function logout(Request $request)
    {
        // dd("sadfsadfs");
        $request->session()->forget('login_id');
        $request->session()->forget('user_name');

        $request->session()->flush();

        return redirect('/' );
    }

    public function change_password_get()
    {
        return view('change-password');
    }



    public function change_password_post(Request $request)
    {
        UsersData::where( 'id', '=',  session()->get( 'login_id'))->update([
            'password'=>$request['confirm_password']
        ]);

        $request->session()->forget('login_id');
        $request->session()->forget('user_name');

        $request->session()->flush();

        return redirect('/' )->with(['success' => 'Password chnage successfully please login again to use service ']);

    }

    public function getLocationSelectedAdmin(Request $request)
    {
        try {
            $request->session()->put('location_selected', $request->location_selected);
            $final_location = Locations::where('id', session('location_selected'))->where('is_deleted', '0')->first();
            $request->session()->put('location_selected_name', $final_location->location);
            $request->session()->put('location_selected_id', $final_location->id);
            return \Redirect::back();
        } catch (\Exception $e) {
           info($e->getMessage());
        }
    }
}

   
