<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

use App\Models\RolesAndCapabilities;

class RolesAndCapabilitiesController extends Controller
{
	private $rolesAndCaps = [
		'add_admin' => 'Add Admin',
		'update_admin' => 'Update Admin',
		'delete_admin' => 'Delete Admin',
		'list_admin' => 'List Admin',
		'add_gb_associate' => 'Add GB Associate',
		'update_gb_associate' => 'Update  GB Associate',
		'delete_gb_associate' => 'Delete  GB Associate',
		'list_gb_associate' => 'List  GB Associate',
		'add_client' => 'Add Client',
		'update_client' => 'Update Client',
		'delete_client' => 'Delete Client',
		'list_client' => 'List Client'
	];
	protected $success_msg = '';

	// CONSTRUCTOR
	// ***********
	public function __construct()
	{

	}

	// INDEX
	// *****
	public function index(Request $request)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}
		if (Auth::check() && Auth::user()->role == 'administrator') {
			$roles_caps = RolesAndCapabilities::all();
		} else if (Auth::check() && Auth::user()->role == 'admin') {
			$roles_caps = RolesAndCapabilities::where('role', 'gb_associate')->get();
		}

		return view('admin.roles-caps', ['rolesCaps' => $roles_caps, 'rolesAndCaps' => $this->rolesAndCaps]);
	}

	// UPDATE
	// ******
	public function update(Request $request, $id)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}

		$role_id = base64_decode($id);
		if ($request->has('submit')) {
			DB::table('roles_caps')->where('id', $role_id)->update(['capabilities' => serialize($request->input('role_capabilities'))]);

			$results = RolesAndCapabilities::find($role_id);
			if ($results) {
				$this->success_msg .= 'Updated successfully';
				$request->session()->flash('success_msg', $this->success_msg);
			}
			return view('admin.roles-caps-update', ['rolesCaps' => $results, 'rolesAndCaps' => $this->rolesAndCaps]);
		} else {

			$results = RolesAndCapabilities::find($role_id);
			return view('admin.roles-caps-update', ['rolesCaps' => $results, 'rolesAndCaps' => $this->rolesAndCaps]);
		}
	}
}
