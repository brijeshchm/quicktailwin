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
 
use App\Models\Permission;
use App\Models\Capability;
class AuthController extends Controller
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
    protected $redirectTo = '/developer/dashboard';
	
    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
	protected $redirectAfterLogout = '/business-owners';

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
        return view('auth.login');
    }
	
	/**
     * Handle an authentication attempt
     *
     * @return Response
     */
	 
	 
	public function authenticate(Request $request)
	{
 
		 
		if(!empty(trim($request->input('email'))) && trim($request->input('password'))){
 
		if($request->has('email')&& $request->has('password')){
 
			$user = User::where('email',$request->input('email'))->select('email','password','user_name','role','id','remember_token')->first();
				  $remember=1;
			if ($user) {
				if (Hash::check(trim($request->input('password')), $user->password)) {
				 
					$request->session()->put('user.email', $request->input('email'));
					$request->session()->put('user.password',$request->input('password'));
					$request->session()->put('user.remember', $user->remember_token);
					$request->session()->put('user.user_name', $user->user_name); 
					$request->session()->put('user.role', $user->role); 
					 		
					$users = $request->session()->get('user');
					 $credentials = $request->only('email', 'password');
			 
			
					if (Auth::guard('developer')->attempt($credentials)) {
					return redirect()->intended('/developer/dashboard');
					}
			
				}else{
					return redirect('/developer/login')->withErrors(['password'=>'Incorrect Password'])->withInput();
				}
			}else{
			 
				return redirect('/developer/login')->withErrors(['generic_err'=>'Email ID/Password is incorrect'])->withInput();
			}
		}
		}
		 
		
		if($request->has('email')&& !$request->has('password')&&$request->has('lgn')){
		 
			return redirect('/developer/login')->withErrors(['password'=>'Password required'])->withInput();
		}
		if($request->has('password')&& !$request->has('email')&& $request->has('lgn')){
				 
			return redirect('/developer/login')->withErrors(['email'=>'Email required'])->withInput();
		}
		if($request->has('password')&& $request->has('email')&& $request->has('lgn')){
				 
			return redirect('/developer/login')->withErrors(['email'=>'Email required','password'=>'Password required'])->withInput();
		}
		 
	}
	
	


	public function logout(Request $request){
	 
		Auth::guard('developer')->logout();
		return redirect('/developer/login');    
	}

}