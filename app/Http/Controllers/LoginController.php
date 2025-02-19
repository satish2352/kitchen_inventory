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

        // Start validation process
        $validation = Validator::make( $request->all(), $rules, $messages );

        // If validation fails, return back with errors
        if ( $validation->fails() ) {
            return redirect( '/' )
            ->withInput()
            ->withErrors( $validation );
        }

        try {
            // Fetch user details from the database
            $get_user = UsersData::where( 'email', $request[ 'email' ] )->first();
            // dd( $get_user[ 'password' ] );
            if ( $get_user ) {
                // The username exists, now verify the password
                $password = $request->password;

                $isApproved = $get_user[ 'is_approved' ];

                // Decrypt the password stored in the database
                // $decryptedPassword = Crypt::decryptString( $get_user->password );
                $decryptedPassword = $get_user[ 'password' ];
                $added_by = $get_user[ 'added_by' ];

                if ( $added_by != '1' ) {
                    if ( $isApproved == '1' ) {

                        // Compare the decrypted password with the input password
                        if ( $password == $decryptedPassword ) {
                            // Store the user data in session

                            $request->session()->put( 'email', $get_user[ 'email' ] );
                            $request->session()->put( 'login_id', $get_user[ 'id' ] );
                            $request->session()->put( 'user_role', $get_user[ 'user_role' ] );
                            $request->session()->put( 'user_name', $get_user[ 'name' ] );
                            $request->session()->put( 'locations_all', $get_user[ 'location' ] );
                            // if ( $get_user[ 'user_role' ] != 1 ) {

                            if ( $get_user[ 'user_role' ] != 1 ) {
                                if ( count( explode( ',', $get_user[ 'location' ] ) )  > 1 ) {
                                    $final_location  = Locations::whereIn( 'id', explode( ',', $get_user[ 'location' ] ) )->get()->toArray();
                                    $request->session()->put( 'location_for_user', $final_location );
                                } else {

                                    $request->session()->put( 'location_selected', rtrim( $get_user[ 'location' ], ',' ) );
                                    $final_location  = Locations::where( 'id', session( 'location_selected' ) )->first();
                                    $request->session()->put( 'location_selected_name', $final_location->location );
                                    $request->session()->put( 'location_selected_id', $final_location->id );
                                }
                            } else {
                                $request->session()->put( 'location_selected_name', '' );
                                $request->session()->put( 'location_selected_id', '' );
                            }

                            // }

                            // dd( session( 'location_for_user' ) );
                            // Return a successful login redirect
                            // dd( 'dsdfasfsafgsa' );

                            // $msg = 'Logged In Successfully';
                            // $status = 'success';

                            // session()->flash( 'alert_status', $status );
                            // session()->flash( 'alert_msg', $msg );

                            $request->session()->regenerate();
                            return redirect( route( '/dashboard' ) );
                            // Change to your dashboard route

                        } else {
                            // Invalid password

                            return redirect( '/' )
                            ->withInput()
                            ->withErrors( [ 'password' => 'You Entered Wrong Password' ] );
                        }

                    } else {
                        // Invalid password

                        return redirect( '/' )
                        ->withInput()
                        ->withErrors( [ 'password' => 'This User Is Not Approved' ] );
                    }
                } else {
                    if ( $password == $decryptedPassword ) {
                        // Store the user data in session
                        $request->session()->put( 'email', $get_user[ 'email' ] );
                        $request->session()->put( 'login_id', $get_user[ 'id' ] );
                        $request->session()->put( 'user_role', $get_user[ 'user_role' ] );
                        $request->session()->put( 'user_name', $get_user[ 'name' ] );
                        $request->session()->put( 'locations_all', $get_user[ 'location' ] );
                        // if ( $get_user[ 'user_role' ] != 1 ) {

                        if ( $get_user[ 'user_role' ] != 1 ) {
                            if ( count( explode( ',', $get_user[ 'location' ] ) )  > 1 ) {
                                $final_location  = Locations::whereIn( 'id', explode( ',', $get_user[ 'location' ] ) )->get()->toArray();
                                $request->session()->put( 'location_for_user', $final_location );
                            } else {

                                $request->session()->put( 'location_selected', rtrim( $get_user[ 'location' ], ',' ) );
                                $final_location  = Locations::where( 'id', session( 'location_selected' ) )->first();
                                $request->session()->put( 'location_selected_name', $final_location->location );
                                $request->session()->put( 'location_selected_id', $final_location->id );
                            }
                        } else {
                            $request->session()->put( 'location_selected_name', '' );
                            $request->session()->put( 'location_selected_id', '' );
                        }

                        // }

                        // dd( session( 'location_for_user' ) );
                        // Return a successful login redirect
                        // dd( 'dsdfasfsafgsa' );

                        // $msg = 'Logged In Successfully';
                        // $status = 'success';

                        // session()->flash( 'alert_status', $status );
                        // session()->flash( 'alert_msg', $msg );

                        $request->session()->regenerate();
                        return redirect( route( '/dashboard' ) );
                        // Change to your dashboard route

                    } else {
                        // Invalid password

                        return redirect( '/' )
                        ->withInput()
                        ->withErrors( [ 'password' => 'You Entered Wrong Password' ] );
                    }
                }

            } else {
                // Invalid username
                return redirect( '/' )
                ->withInput()
                ->withErrors( [ 'user_name' => 'These credentials do not match our records.' ] );
            }

        } catch ( Exception $e ) {
            // If there's an exception, redirect to the feedback page with the error message
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
    }
