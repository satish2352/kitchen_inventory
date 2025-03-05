<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UsersData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ {
    Locations,
};
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function __construct()
    {
        // Constructor code here if necessary
    }

    public function index(Request $request)
    {
        try {
            return view('login');
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function submitLogin(Request $request)
    {
        try {
            // Define the validation rules
            $rules = [
                'email'    => 'required|exists:users_data,email|email', // Check if the user_name exists in the users_data table
                'password' => 'required',                               // Make sure the password field is required
            ];

            // Define custom validation messages
            $messages = [
                'email.required'    => 'Please Enter email id.',
                'email.exists'      => 'The provided email does not exist.',
                'email.email'       => 'Please provide a valid email address.',
                'password.required' => 'Please Enter Password.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            if ($validation->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validation);
            }

            try {
                $get_user = UsersData::where('email', $request['email'])->first();
                if ($get_user) {
                    $password          = $request->password;
                    $isApproved        = $get_user['is_approved'];
                    $decryptedPassword = $get_user['password'];
                    $added_by          = $get_user['added_by'];

                    if ($password == $decryptedPassword) {
                        $request->session()->put('email', $get_user['email']);
                        $request->session()->put('login_id', $get_user['id']);
                        $request->session()->put('user_role', $get_user['user_role']);
                        $request->session()->put('user_name', $get_user['name']);
                        $request->session()->put('locations_all', $get_user['location']);

                        if ($get_user['user_role'] != 1) {
                            if (count(explode(',', $get_user['location'])) > 1) {
                                $final_location = Locations::whereIn('id', explode(',', $get_user['location']))
                                    ->where('is_deleted', 0)
                                    ->get()->toArray();
                                $request->session()->put('location_for_user', $final_location);
                            } else {

                                $request->session()->put('location_selected', rtrim($get_user['location'], ','));
                                $final_location = Locations::where('id', session('location_selected'))
                                    ->where('is_deleted', 0)
                                    ->first();
                                $request->session()->put('location_selected_name', $final_location->location);
                                $request->session()->put('location_selected_id', $final_location->id);
                            }
                        } else {
                            $request->session()->put('location_selected_name', '');
                            $request->session()->put('location_selected_id', '');
                        }

                        $request->session()->regenerate();
                        return redirect(route('/dashboard'));

                    } else {
                        return redirect('/')
                            ->withInput()
                            ->withErrors(['password' => 'You Entered Wrong Password']);
                    }

                } else {
                    return redirect('/')
                        ->withInput()
                        ->withErrors(['user_name' => 'These credentials do not match our records.']);
                }

            } catch (Exception $e) {
                return redirect('feedback-suggestions')->withInput()->with(['msg' => $e->getMessage(), 'status' => 'error']);
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            // dd("sadfsadfs");
            $request->session()->forget('login_id');
            $request->session()->forget('user_name');

            $request->session()->flush();

            return redirect('/');
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function change_password_get()
    {
        try {
            return view('change-password');
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function change_password_post(Request $request)
    {
        try {
            UsersData::where('id', '=', session()->get('login_id'))->update([
                'password' => $request['confirm_password'],
            ]);

            $request->session()->forget('login_id');
            $request->session()->forget('user_name');

            $request->session()->flush();

            return redirect('/')->with(['success' => 'Password chnage successfully please login again to use service ']);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
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

    // Forget Password
    public function forget_password(Request $request)
    {
        try {
            return view('forgot_password_login');
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function send_otp(Request $request)
    {
        try {

            $rules = [
                'forgot_email'    => 'required|exists:users_data,email|email', // Check if the user_name exists in the users_data table
            ];

            // Define custom validation messages
            $messages = [
                'forgot_email.required'    => 'Please Enter email id.',
                'forgot_email.email'       => 'Please provide a valid email address.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);


            $email = $request['forgot_email'];
            $get_user = UsersData::where('email', $email)->first();
            if ($get_user) {
                $otp_password_reset = rand(10,100000); 
                UsersData::where('email', $email)->update([
                    "otp_password_reset"=> $otp_password_reset
                ]);

                $email_data = [
					'email' => $request['forgot_email'],				
					'otp_password_reset' => $otp_password_reset,
	
				];
				$toEmail = $request['forgot_email'];
				$senderSubject = 'Buffalo Boss OTP Details' . date('d-m-Y H:i:s');
				$fromEmail = env('MAIL_USERNAME');
				Mail::send('forget_password_otp_mail', ['email_data' => $email_data], function ($message) use ($toEmail, $fromEmail, $senderSubject) {
					$message->to($toEmail)->subject($senderSubject);
					$message->from($fromEmail, ' Buffalo Boss');
				});
                return view('send_otp_login',compact('otp_password_reset', 'email'))->with(['success' => 'Password sent on registred mail']);
            } else {
                return redirect('/')->with(['success' => 'Email address not found for password reset']);
            }
            return view('send_otp_login',compact('otp_password_reset', 'email'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function reset_password(Request $request)
    {
        try {
            // dd($request); otp_genrated
            $rules = [
                'email'    => 'required|exists:users_data,email|email', // Check if the user_name exists in the users_data table
            ];

            $messages = [
                'email.required'    => 'Please Enter email id.',
                'email.email'       => 'Please provide a valid email address.',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);

            $get_user = UsersData::where('email', $request['email'])->first();
            if ($get_user) {
                $password_reset = $this->generatePassword(); 
                UsersData::where('email', $request['email'])->update([
                    "password"=> $password_reset
                ]);

                $email_data = [
					'email' => $request['email'],				
					'password' => $password_reset,
	
				];
				$toEmail = $request['email'];
				$senderSubject = 'Credentials for the Buffalo Boss login' . date('d-m-Y H:i:s');
				$fromEmail = env('MAIL_USERNAME');
				Mail::send('user_added_mail', ['email_data' => $email_data], function ($message) use ($toEmail, $fromEmail, $senderSubject) {
					$message->to($toEmail)->subject($senderSubject);
					$message->from($fromEmail, ' Buffalo Boss');
				});

                return redirect('/')->with(['success' => 'Password change successfully please check email for password !!']);
            } else {
                return redirect('/')->with(['success' => 'Something went wrong']);
            }
            return view('send_otp_login',compact('otp_password_reset'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    function generatePassword($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }
}
