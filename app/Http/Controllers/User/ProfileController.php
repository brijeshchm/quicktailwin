<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client; //model
use Validator; 
use DB;
use Mail; 
use Exception;
use App\Models\AssigneddArea;
use App\Models\AssignedZone; 
use App\Models\Guest; 
 
use Auth;
use App\Traits\HandlesImageUploads;
class ProfileController extends Controller
{

     
	 public function dashbord()
    {
          $user = Auth::guard('guest')->user();

     
      
        return view('user.dashboard', compact('user'));
    }
	 public function edit()
    {
         $user = Auth::guard('guest')->user();
       
        return view('user.profile.personal-details', compact('user'));
    }

    
    public function autosave(Request $request)
{
    $user = Auth::guard('guest')->user();

    if (!$user) {
        return response()->json([
            'success'  => false,
            'message'  => 'Session expired.',
            'redirect' => route('home'),
        ], 401);
    }

    // ✅ Whitelist
    $allowed = [
        'title', 'first_name', 'last_name', 'dob',
        'city', 'area', 'pincode', 'mobile', 'email',
    ];

    $field = $request->input('field');
    $value = $request->input('value');

    if (!in_array($field, $allowed, true)) {
        return response()->json([
            'success' => false,
            'message' => 'This field cannot be saved.',
        ], 422);
    }

    // ✅ Validation
    $rules = [
        'title'      => ['required', 'in:Mr,Ms,Mrs,Dr'],
        'first_name' => ['required', 'string', 'max:50'],
        'last_name'  => ['nullable', 'string', 'max:50'],
        'dob'        => ['nullable', 'date', 'before:' . now()->subYears(10)->format('Y-m-d')],
        'city'       => ['nullable', 'string', 'max:100'],
        'area'       => ['nullable', 'string', 'max:100'],
        'pincode'    => ['nullable', 'regex:/^\d{6}$/'],
        'mobile'     => ['nullable', 'regex:/^[6-9]\d{9}$/'],
        'email'      => ['nullable', 'email', 'max:255', 'unique:guests,email,' . $user->id],
    ];

    $messages = [
        'pincode.regex' => 'Pincode must be exactly 6 digits.',
        'mobile.regex'  => 'Enter a valid 10-digit mobile number.',
        'email.email'   => 'Enter a valid email address.',
        'email.unique'  => 'This email is already in use.',
        'dob.before'    => 'You must be at least 10 years old.',
    ];

    $validator = Validator::make([$field => $value], [$field => $rules[$field]], $messages);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'field'   => $field,
            'message' => $validator->errors()->first($field),
        ], 422);
    }

    // ✅ Save the field (null if empty)
    $cleanValue = $value === '' ? null : $value;
    $user->update([$field => $cleanValue]);

    // 🔑 SYNC DERIVED FIELDS — name & business_name
    if ($field === 'first_name' || $field === 'last_name') {

        // Build full name from latest values
        $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));

        $derived = ['name' => $fullName ?: null];

        // business_name = first_name (only when first_name itself changes)
        if ($field === 'first_name') {
            $derived['business_name'] = $cleanValue;
        }

        $user->update($derived);
    }

    // Update progress
    $user->update(['profile_progress' => $user->calculateProgress()]);

    return response()->json([
        'success'       => true,
        'field'         => $field,
        'progress'      => $user->profile_progress,
        'name'          => $user->name,
        'business_name' => $user->business_name,
        'saved_at'      => now()->format('h:i A'),
    ]);
}

   use HandlesImageUploads; // 👈 add this

    /**
     * Auto-save AVATAR
     */
    public function autosaveAvatar(Request $request)
    {

    // dd($request->all());
        $user = Auth::guard('guest')->user();

        if (!$user) {
            return response()->json([
                'success'  => false,
                'message'  => 'Session expired.',
                'redirect' => route('home'),
            ], 401);
        }

        // ✅ Validate file
        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2MB
        ], [
            'avatar.image' => 'Please upload a valid image.',
            'avatar.mimes' => 'Only JPG, PNG, or WEBP allowed.',
            'avatar.max'   => 'Image must be under 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('avatar'),
            ], 422);
        }

        // ✅ Define destination
        $filePath = 'uploads/avatars';
        $destinationPath = public_path($filePath);

        // ✅ Delete OLD avatar first (cleanup)
        $this->deleteImageFile($user->avatar, $filePath);

        // ✅ Save with resize (400x400 for avatar)
        $filename = $this->saveImageSmart(
            $request->file('avatar'),
            $destinationPath,
            400,    // width
            400,    // height
            85      // quality
        );

        if (!$filename) {
            return response()->json([
                'success' => false,
                'message' => 'Image processing failed. Try a different file.',
            ], 500);
        }
 
        // ✅ Save filename to DB
        $user->update([
            'avatar'           => $filePath.'/'.$filename,
            'profile_progress' => $user->calculateProgress(),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Photo updated',
            'url'      => asset('uploads/avatars/' . $filename),
            'progress' => $user->profile_progress,
        ]);
    }

 

    /**
     * Send OTP to mobile
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|regex:/^\d{10}$/']);

        $otp = rand(100000, 999999);
        cache()->put("otp_{$request->mobile}", $otp, now()->addMinutes(5));

        // TODO: Integrate SMS gateway (MSG91, Twilio, Fast2SMS, etc.)
        // SmsService::send($request->mobile, "Your OTP: {$otp}");

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully',
            // ⚠️ Remove this in production
            'debug_otp' => app()->environment('local') ? $otp : null,
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^\d{10}$/',
            'otp'    => 'required|digits:6',
            'field'  => 'required|in:mobile',
        ]);

        $cachedOtp = cache()->get("otp_{$request->mobile}");

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 422);
        }

        $client = Auth::guard('clients')->user();
        $client->update([
            $request->field => $request->mobile,
            "{$request->field}_verified" => true,
        ]);

        cache()->forget("otp_{$request->mobile}");

        return response()->json([
            'success' => true,
            'message' => 'Mobile verified successfully',
        ]);
    }
	
	
   public function userLogout()
	{  
		Auth::guard('guest')->logout();
		return redirect('business-owners');
	}
	
	
}
