<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Hash;
use Session;
use App\Models\Client\Client; //model

class ChangePasswordController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (Auth::guard('clients')->check()) {
			return view('client.changePassword');
		}
		return "Get login first";
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (Auth::guard('clients')->check()) {
			Validator::extend('old_pass', function ($attribute, $value, $parameters, $validator) {
				return Hash::check($value, current($parameters));
			});
			$validator = Validator::make($request->all(), [
				'old_pass' => 'required|old_pass:' . Auth::guard('clients')->user()->password,
				'password' => 'required|confirmed',
			], [
				'old_pass.required' => 'Old password required',
				'old_pass.old_pass' => 'Old password mismatch',
				'password' => 'New Password field is requried',
			]);
			if ($validator->fails()) {
				return redirect("/business-owners/changepassword")
					->withErrors($validator)
					->withInput();
			}
			$user = Auth::guard('clients')->user();
			$client = Client::find($user->id);
			$client->password = bcrypt($request->input('password'));
			if ($client->save()) {				 
				$request->session()->flash('success_msg', 'Password Updated Successfully');
				return redirect("/business-owners/changepassword");
			}
		} else {
			return "Don't cheat... Login first";
		}
	}
	/**
	 * Forgot Password
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function forgotPassword(Request $request)
	{
		if (!$request->ajax()) {
			return response()->json([], 400);
		}
		if ($request->has('action') && $request->input('action') == 'getFPF') {
			$html = '';
			$warningDiv = '<div class="alert alert-warning hide"></div>';
			$html .= '<div class="modal fade" id="pass-reset-modal" role="dialog">
				<div class="modal-dialog">
					<form onsubmit="return fp.getOTPF(this)">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="fa fa-fw fa-unlock-alt"></i> Enter the below details - Forgot Password</h4>
							</div>
							<div class="modal-body">
								' . $warningDiv . '
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" name="username" value="" />
								</div>
								<div class="form-group">
									<label>Primary Mobile</label>
									<input type="tel" class="form-control" name="mobile" value="" />
								</div>
								<div class="has-error">
									<span class="help-block">
										<strong>Note:</strong>
										<strong>Both Field(s) are Mandatory<strong><br>
									</span>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-default">Submit</button>
								<button type="button" class="btn btn-default" onclick="javascript:fp.close()">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>';
			return response()->json([$html], 200);
		}
		if ($request->has('action') && $request->input('action') == 'getOTPF') {
			$client = Client::where('username', 'LIKE', $request->input('username'))->first();
			if ($client === null) {
				return response()->json([
					"error" => [
						"status" => 404,
						"error" => "NOT_FOUND",
						"description" => "Requested resource not found.",
						"fields" => [
							"username" => "Client having username: '" . $request->input('username') . "' not found on the server."
						]
					]
				]);
			}
			if ($client->mobile != $request->input('mobile')) {
				return response()->json([
					"error" => [
						"status" => 422,
						"error" => "FIELD_MISMATCH",
						"description" => "Value mismatch.",
						"fields" => [
							"mobile" => "Client having username: '" . $request->input('username') . "' mobile mismatch."
						]
					]
				]);
			}
			$request->session()->put('user.mobile', $request->input('mobile'));
			$request->session()->put('user.username', $request->input('username'));
			$otp = mt_rand(100000, 999999);
			$request->session()->put('user.otp', $otp);
			sendSMS($request->session()->get('user.mobile'), $otp);
			$html = '';
			$warningDiv = '<div class="alert alert-warning hide"></div>';
			$html .= '<div class="modal fade" id="pr-otp-modal" role="dialog">
				<div class="modal-dialog">
					<form onsubmit="return fp.submitOTPF(this)">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="fa fa-fw fa-unlock-alt"></i> Enter OTP - Forgot Password</h4>
							</div>
							<div class="modal-body">
								' . $warningDiv . '
								<div class="form-group">
									<label>OTP</label>
									<input type="text" class="form-control" name="otp" value="" />
								</div>
								<div class="has-error">
									<span class="help-block">
										<strong>Note:</strong>
										<strong>OTP Field is Mandatory<strong><br>
									</span>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-default">Submit</button>
								<button type="button" class="btn btn-default" onclick="javascript:fp.closeotpf()">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>';
			return response()->json([$html], 200);
		}
		if ($request->has('action') && $request->input('action') == 'submitOTPF') {
			if ($request->session()->get('user.otp') != $request->input('otp')) {
				return response()->json([
					"error" => [
						"status" => 422,
						"error" => "INVALID_OTP",
						"description" => "OTP is invalid.",
						"fields" => [
							"otp" => "OTP is invalid."
						]
					]
				]);
			}
			$client = Client::where('username', 'LIKE', $request->session()->get('user.username'))->first();
			$pass = rand(000001, 999999);
			$client->password = bcrypt($pass);
			if ($client->save()) {
				sendSMS($request->session()->get('user.mobile'), 'Your new password is:' . $pass);
				$html = '';
				$warningDiv = '<div class="alert alert-warning hide"></div>';
				$html .= '<div class="modal fade" id="pr-conf-modal" role="dialog">
					<div class="modal-dialog">
						<form onsubmit="return fp.submitOTPF(this)">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title"><i class="fa fa-fw fa-unlock-alt"></i> Password reset successfully - Forgot Password</h4>
								</div>
								<div class="modal-body">
									<p>Your password reset successfully.<br>
									Now your password is:' . $pass . '
									</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" onclick="javascript:fp.closeconff()">Close</button>
								</div>
							</div>
						</form>
					</div>
				</div>';
				return response()->json([$html], 200);
			}
		}
	}
}
