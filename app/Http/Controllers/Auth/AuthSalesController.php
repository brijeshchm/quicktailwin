<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller; 
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use DB;
use Hash;
use Mail;
use App\Models\Email;
use App\Models\Permission;
use App\Models\Capability;
class AuthSalesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
	protected $danger_msg = '';
	protected $success_msg = '';
    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/sales/dashboard';
	
    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
	protected $redirectAfterLogout = '/sales/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {         
		//$this->middleware('guest')->except('logout');
   
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		$messages = [
			'mobile.regex' => 'Mobile number cannot start with 0.',
			'first_name.regex' => 'First Name only take alphabets and spaces', 
			'last_name.regex' => 'Last Name only take alphabets and spaces' 
		];
        return Validator::make($data, [
            'user_name' => 'required|max:50|unique:users',
            'first_name' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
            'mobile' => 'required|numeric|digits:10|regex:/^[1-9]+/',
            'email' => 'required|email|max:50|unique:users',
            'sec_email' => 'email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'role' => 'required',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            //'name' => $data['name'],
            'user_name' => $data['user_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'sec_email' => $data['sec_email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);
    }
	
	 /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    { 
        return view('sales.login');
    }
	/**
     * Handle an authentication attempt
     *
     * @return Response
     */
	public function checklogin(Request $request)
	{	       
			 
		return view('sales.login');	
		
	}
	/*
     * Handle an authentication attempt
     *
     * @return Response
     */
	 
        /**
     * Handle an authentication attempt
     *
     * @return Response
     */
	public function getOTP(Request $request){
		if($request->session()->has('user.email') && $request->session()->has('user.password') && ($request->session()->has('user.mobile') || $request->session()->has('user.otp_to_email')))
			return response()->view('sales.otp');
		else
			return redirect()->intended('/sales/login');
	}
	 public function authenticate(Request $request)
	{
				 
		if(!empty(trim($request->input('email'))) && trim($request->input('password'))){	
 	
				$email = Email::all();
	 
			$user = User::where('email',$request->input('email'))->select('email','password','user_name','role','id','mobile','remember_token','first_name')->first();
				  
			if($user){
				if (Hash::check(trim($request->input('password')), $user->password)) {
					 
					$request->session()->put('user.email', $request->input('email'));
					$request->session()->put('user.password', $request->input('password'));
					$request->session()->put('user.remember_token', $user->remember_token);
					$request->session()->put('user.first_name', $user->first_name); 
					$request->session()->put('user.mobile', $user->mobile); 
				 			 		
					 
					$user = $request->session()->get('user');
		 
				 
			return view('sales.mobile',compact('email'));
					
					
					return $request->session()->all();
				}else{
					return redirect('/sales/check/login')->withErrors(['password'=>'Incorrect Password'])->withInput();
				}
			}else{
				//return 'email not found';
				return redirect('/sales/check/login')->withErrors(['generic_err'=>'Email ID/Password is incorrect'])->withInput();
			}
		}
		if($request->has('mobile') && $request->input('mobile') != ''){
			$request->session()->put('user.mobile', $request->input('mobile'));
			$otp = mt_rand(100000, 999999);
			$request->session()->put('user.otp', $otp);
			$message = "{$otp} is Lead Portal Verification Code for {$request->session()->get('user.name')}.";
	//	echo $request->session()->get('user.mobile');	 echo "<pre>";print_r($message);
			//$this->sendUandP($message);
		//	$send = sendSMS($request->session()->get('user.mobile'),$message);
 
			return redirect('/sales/login/otp');
			//return view('auth.otp',['otp'=>$otp]);
			//return $request->session()->all();
		}
		else if($request->has('otp_to_email') && $request->input('otp_to_email') != ''){
		    
		    $emailDetails = Email::where('email',$request->input('otp_to_email'))->first();
		    
		    
		    if(!empty($emailDetails)){
			// $request->session()->put('user.email', $request->input('otp_to_email'));
			$otp = mt_rand(100000, 999999);
			$request->session()->put('client.otp', $otp);
			$message = "{$otp} is Verification Code for {$request->session()->get('user.first_name')} from {$request->input('otp_to_email')}.";
			
			$headers = "From:otp@quickdials.com";
			
			// mail($request->input('otp_to_email'),$otp .' OTP ',$message,$headers);
	 

            $subject  = "{$otp} is QuickDials Verification Code for {$request->session()->get('user.email')}";
 
			Mail::send(
				'emails.sendotp_to_email',
				['otp' => $otp, 'name' => $request->session()->get('user.first_name')],
				function ($m) use ($request, $subject, $emailDetails) {
					$m->from(env('MAIL_USERNAME'), 'QuickDials');
					$m->to($emailDetails->email, "")->subject($subject);
				}
			);

			
			 
			return redirect('/sales/login/otp');
			
		}else{
			//return 'email not found';
				return redirect('/sales/check/login')->withErrors(['generic_err'=>'Wrong Email ID'])->withInput();
		}
		}
		
		if($request->has('otp')){
			if(($request->session()->get('client.otp')==$request->input('otp'))){
				$user = $request->session()->get('user');
                // dd($user);
				if (Auth::attempt(['email' => $user['email'], 'password' => $user['password']], $user['remember_token'])) {
					$request->session()->forget('user');
                    if (Auth::guard('sales')->attempt($user)) {
					return redirect()->intended('/sales/dashboard');
					}
					 
				}
			}else{
				return redirect('/sales/login/otp')->withErrors(['otp'=>'Invalid OTP'])->withInput();
			}
		}
		if($request->has('email')&&!$request->has('password')&&$request->has('lgn')){
			return redirect('/login')->withErrors(['password'=>'Password required'])->withInput();
		}
		if($request->has('password')&&!$request->has('email')&&$request->has('lgn')){
			return redirect('/sales/login')->withErrors(['email'=>'Email required'])->withInput();
		}
		if(!$request->has('password')&&!$request->has('email')&&$request->has('lgn')){
			return redirect('/sales/login')->withErrors(['email'=>'Email required','password'=>'Password required'])->withInput();
		}
		//return $request->input('email')."=>".$request->input('password')."=>".$request->input('remember');
	}
	

 
	


	public function logout(Request $request){
	 
		Auth::guard('sales')->logout();
		return redirect('/sales/login');    
	}

}