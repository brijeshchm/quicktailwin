<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Capability;
use App\Models\Permission;
use Validator;
use DB;
class userController extends Controller
{
	public function getRegister()
	{

		if (Auth::check()) {
			if (Auth::user()->role == 'administrator' || Auth::user()->role == 'admin') {

				return view('auth.register');
			} else {
				return redirect('/developer/dashboard');
			}
		} else {
			return redirect('/developer/login');
		}
	}

	public function postRegister(Request $request)
	{

		if ($request->ajax()) {

			if (Auth::check()) {
				if (!$request->user()->current_user_can('administrator')) {
					return view('errors.unauthorised');
				}

				$validator = Validator::make($request->all(), [
					'email' => 'required|unique:users,email|min:3|max:225',
					'user_name' => 'required|unique:users,user_name|min:3|max:225',
					'first_name' => 'required',
					'mobile' => 'required',
					'role' => 'required',

				]);

				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}


				$user = $this->create($request->all());
				$user->last_name = $request->input('last_name');
				$user->save();

				if ($user) {

					$add_capbilities = array(
						'user_id' => $user->id,
						'capabilities' => serialize($request->input('capabilities')),
					);

					$capability = DB::table('role_capabilities')->insert($add_capbilities);

				}
				 
				if ($capability) {
					$status = 1;
					$msg = "User submitted successfully!";

				} else {
					$status = 0;
					$msg = "User could not be submitted, Please try again!";
				}

				return response()->json(['status' => $status, 'msg' => $msg], 200);


			} else {
				return redirect('/developer/login');
			}

		}
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
	public function getUsers(User $user)
	{

		if (Auth::user()->role == 'administrator') {
			$users = User::all();
			return view('admin.list-users', ['users' => $users]);
		} else if (Auth::user()->role == 'manager') {
			$users = User::where('id', Auth::user()->id)
				->get();
			return view('admin.list-users', ['users' => $users]);
		} else if (Auth::user()->role == 'SEO') {
			$users = User::where('role', 'SEO')
				->where('id', Auth::user()->id)
				->get();
			return view('admin.list-users', ['users' => $users]);
		} else if (Auth::user()->role == 'teleteam') {
			$users = User::where('role', 'teleteam')
				->where('id', Auth::user()->id)
				->get();
			return view('admin.list-users', ['users' => $users]);
		} else if (Auth::user()->role == 'salesmanager') {
			$users = User::where('role', 'salesmanager')
				->where('id', Auth::user()->id)
				->get();
			return view('admin.list-users', ['users' => $users]);
		}
		 else if (Auth::user()->role == 'seo_manager') {
			$users = User::where('role', 'seo_manager')
				->where('id', Auth::user()->id)
				->get();
			return view('admin.list-users', ['users' => $users]);
		}
	}

	public function updateUser(Request $request, User $user, $id)
	{
		$user_id = base64_decode($id);
		$user = User::find($user_id);
		$capabilities = Capability::where('user_id', $user->id)->first();

		$edit_data = Capability::where('user_id', $user->id)->first();
		$permissions = Permission::all();
		if (!empty($capabilities)) {
			if (isset($capabilities->capabilities) && !is_null($capabilities->capabilities)) {
				$capabilities = unserialize($capabilities->capabilities);
			}
		} else {
			$capabilities = [];
		}
		if (
			(Auth::user()->current_user_can('administrator') && ($user->current_user_can('manager') || $user->current_user_can('seo_manager')|| $user->current_user_can('SEO') || $user->current_user_can('salesmanager') || $user->current_user_can('teleteam') || $user->id == Auth::user()->id))
			||
			(Auth::user()->current_user_can('manager') && ($user->current_user_can('SEO') || $user->id == Auth::user()->id))
			||
			(Auth::user()->current_user_can('teleteam') && $user->id == Auth::user()->id)
		) {

			return view('admin.update-user', ['user' => $user, 'userCaps' => $capabilities, 'permissions' => $permissions, 'edit_data' => $edit_data]);
		}
		return view('errors.unauthorised');

	}

	public function updateThisUser(Request $request, $id)
	{
		$user_id = base64_decode($id);
		$user = User::find($user_id);
		$messages = [
			'mobile.regex' => 'Mobile number cannot start with 0.',
			'first_name.regex' => 'First Name only take alphabets and spaces',
			'last_name.regex' => 'Last Name only take alphabets and spaces'
		];
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
			'last_name' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
			'mobile' => 'required|numeric|digits:10|regex:/^[1-9]+/',
			'role' => 'required',
			'password' => 'confirmed'
		], $messages);

		if ($validator->fails()) {
			return redirect("developer/update-user/$id")
				->withErrors($validator)
				->withInput();
		}

		$user->first_name = $request->input('first_name');
		$user->last_name = $request->input('last_name');
		$user->mobile = $request->input('mobile');
		$user->sec_email = $request->input('sec_email');

		if ((Auth::user()->current_user_can('administrator')) && ($user->current_user_can('manager') || $user->current_user_can('seo_manager') || $user->id != Auth::user()->id)) {
			if (!empty($request->input('role'))) {
				$user->role = $request->input('role');
			}
		}
		if ("" != $request->input('password')) {
			$user->password = bcrypt($request->input('password'));
		}
		$user->save();

		if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager') || $user->current_user_can('seo_manager')) {



			$capabilities = Capability::where('user_id', $user->id)->first();
			if (!empty($capabilities)) {
				$update_capbilities = array(
					'capabilities' => serialize($request->input('capabilities')),
				);

				$capability = Capability::where('user_id', $user_id)->update($update_capbilities);
			} else {
				$add_capbilities = array(
					'user_id' => $user->id,
					'capabilities' => serialize($request->input('capabilities')),
				);

				$capability = DB::table('role_capabilities')->insert($add_capbilities);

			}



		}

		$request->session()->flash('alert-success', 'User was successful updated!');
		return redirect("developer/update-user/$id");
	}

	public function deleteUser(Request $request, $id)
	{
		$user_id = base64_decode($id);
		$user = User::find($user_id);


		if ($user) {
			if ($request->user()->current_user_can('administrator')) {
				if ($user->id == $request->user()->id) {
					$request->session()->flash('danger', 'You cannot delete yourself...');
					return redirect("developer/list-users");
				} else {
					$user->delete();
					$delete = DB::table('role_capabilities')->where('user_id', $user_id)->delete();
					$request->session()->flash('success', 'User successfully deleted...');
					return redirect("developer/list-users");
				}
			} else if ($request->user()->current_user_can('manager')) {
				if ($user->id == $request->user()->id) {
					$request->session()->flash('danger', 'You cannot delete yourself...');
					return redirect("developer/list-users");
				} else if ($user->current_user_can('administrator')) {
					$request->session()->flash('danger', 'You cannot delete administrator...');
					return redirect("developer/list-users");
				} else if ($user->current_user_can('manager')) {
					$request->session()->flash('danger', 'You cannot delete other manager...');
					return redirect("developer/list-users");
				} else {
					$user->delete();
					$delete = DB::table('role_capabilities')->where('user_id', $user_id)->delete();
					$request->session()->flash('success', 'User successfully deleted...');
					return redirect("developer/list-users");
				}
			} else {
				return view('errors.unauthorised');
			}
		} else {
			$request->session()->flash('danger', 'User not found...');
			return redirect("developer/list-users");
		}



		// if($user_id == Auth::user()->id){
		// $request->session()->flash('danger', 'Cannot delete itself!');
		// return redirect("developer/list-users");			
		// }
		// else if($user->role == 'administrator'){
		// $request->session()->flash('danger', 'Cannot delete superadmin!');
		// return redirect("developer/list-users");			
		// }
		// else{
		// User::find($user_id)->delete();
		// $request->session()->flash('success', 'User was successfully deleted!');
		// return redirect("developer/list-users");			
		// }
	}


}
