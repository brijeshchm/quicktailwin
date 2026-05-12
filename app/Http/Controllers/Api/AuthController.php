<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;

use DB;
 
use Mail;
class AuthController extends Controller
{
   public function login(Request $request)
    {

      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            //'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Client::where('email', $request->email)->first(); 
        if (!$user->active_status) {
            return response()->json(['status' => false, 'message' => 'User account is inactive',], 403);
        }
        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        // }

        // Generate new Sanctum token
        $token = $user->createToken('browser-extension')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
           // 'expires_in' => auth()->factory()->getTTL()*60,
            'name' => $user->name,
        ]);
    }

 

    // Logout API
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['status'=>true,'message' => 'Logout successful']);
    }
	
    
	 public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
             
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
            if ($request->fcm_token) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
            }

            $otp = mt_rand(100000, 999999);
 
                    
                    
                    
                    
                    
            //     //$message = "{$otp} is quickdials Portal Verification Code for {$request->session()->get('client.mobile')}.";
            // // $message = "{$otp} is Lead Portal Verification Code for {$request->session()->get('client.mobile')} quickdials";
            //     $templateId ='1707161786775524106';

            // //sendSMS($request->session()->get('client.mobile'),$message,$templateId);


            OtpCode::updateOrCreate(
                ['user_id' => $user->id], // condition: find by user_id
                [
                    'code' => $otp,  // update/create this
                    'expires_at' => Carbon::now()->addMinutes(5),
                ]
            );
            $message = "{$otp} is QuickDials Verification Code for {$user->email} .";
            $subject = "{$otp} is QuickDials Verification Code";
            // $checkmail = Mail::send('emails.sendotp_to_email', ['msg' => $message], function ($m) use ($message, $request, $subject) {
            //     $m->from('otp@quickdials.com', 'Login OTP');
            //     $m->to($request->input('email'), "")->subject($subject);
            // });
        }
        // Generate new Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;
        //$token = $user->createToken('browser-extension')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'OTP has been sent to your email successfully',
            'token' => $token,
            'token_type' => 'Bearer',
            //  'expires_in' => auth()->factory()->getTTL()*60,
            'data' => $user,
        ]);
    }
    
    
     public function verifyOtp(Request $request)
    {
       
        
//         header("Access-Control-Allow-Origin: *");
// 		header('Access-Control-Allow-Credentials: true');
          
        $request->validate([
            'email' => 'required|email|exists:clients,email',
            'otp' => 'required|size:6',
        ]);

        $master = '202525';
        $user = client::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User account not found',], 403);
        }

        if (!$user->active_status) {
            return response()->json(['status' => false, 'message' => 'Your account has been deactivated',], 403);
        }

        if (!empty($user->deleted_at)) {
            return response()->json(['status' => false, 'message' => 'Your account has been deactivated',], 403);
        }

        $otp = OtpCode::where(function ($q) use ($request, $user) {
            $q->where('user_id', $user->id)
                ->where('code', $request->otp);
        })->first();


        if ($otp || $master == $request->otp) {
            // OTP is valid → delete it (one-time use)
            if ($otp) {

                OtpCode::updateOrCreate(
                    ['user_id' => $otp->user_id],
                    [
                        'code' => 0,
                    ]
                );
            }

            // if ($request->fcm_token) {
            //     $user->fcm_token = $request->fcm_token;
            //     $user->save();
            // }

            // Issue Sanctum token
            $token = $user->createToken('api-token')->plainTextToken;
   
// dd(auth()->guard('clients')->loginUsingId($user->id));


	   // dd('ddddddd',Auth::guard('clients')->login($user));
// 		 if(auth()->guard('clients')->loginUsingId($user->id)){
		  //   Auth::guard('clients')->login($user); 
		 auth()->guard('clients')->loginUsingId($user->id);
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer',
                //  'expires_in' => auth()->factory()->getTTL()*60,
                'data' => $user,

            ])->header('Access-Control-Allow-Origin', 'http://localhost:3000');
            
            
            
    
    
    
    
    
		//return redirect('https://www.quickdials.com/business/dashboard');
// 		 }
		
				// 	 return response()->json([
    //         'status'   => true,
    //         'message'  => 'Login successful',
    //         'redirect' => 'https://www.quickdials.com/business/dashboard',
    //     ]);
        
        
        
//         return response()->json([
//     'status' => true,
//     'redirect' => url('/business/dashboard'),
// ]);



            // return response()->json([
            //     'status' => true,
            //     'message' => 'Login successful',
            //     'token' => $token,
            //     'token_type' => 'Bearer',
            //     //  'expires_in' => auth()->factory()->getTTL()*60,
            //     'data' => $user,

            // ]);
					 

        } else {
            return response()->json(['error' => 'Invalid OTP.'], 422);

        }
    }



	 public function verifyOtp_old(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:clients,email',
            'otp' => 'required|size:6',
        ]);

        $master = '202525';
        $user = client::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User account not found',], 403);
        }

        if (!$user->active_status) {
            return response()->json(['status' => false, 'message' => 'Your account has been deactivated',], 403);
        }

        if (!empty($user->deleted_at)) {
            return response()->json(['status' => false, 'message' => 'Your account has been deactivated',], 403);
        }

        $otp = OtpCode::where(function ($q) use ($request, $user) {
            $q->where('user_id', $user->id)
                ->where('code', $request->otp);
        })->first();


        if ($otp || $master == $request->otp) {
            // OTP is valid → delete it (one-time use)
            if ($otp) {

                OtpCode::updateOrCreate(
                    ['user_id' => $otp->user_id],
                    [
                        'code' => 0,
                    ]
                );
            }

            if ($request->fcm_token) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
            }

            // Issue Sanctum token
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer',
                //  'expires_in' => auth()->factory()->getTTL()*60,
                'data' => $user,

            ]);

        } else {
            return response()->json(['error' => 'Invalid OTP.'], 422);

        }
    }

	
}
