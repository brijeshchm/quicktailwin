<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

//models
use App\Models\Keyword;
use App\Models\Permission;
use App\Models\User;
use App\Models\SeoKwdAssign;
use Auth;
use Session;
class SeoKwdAssignController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		 
		 
			$users = User::get();

			$keywords = Keyword::all();
			$get_seoKwdAssign = SeoKwdAssign::get();
			$users = User::get();
			$sourcePermissions = "";
			$destinationPermissions = "";

			$rolePermissions = [];

			if ($get_seoKwdAssign) {
			foreach ($get_seoKwdAssign as $seoKwdAssign) {
			if (!is_null($seoKwdAssign->kwd_assign)) {
			$decoded = json_decode($seoKwdAssign->kwd_assign, true);
			if (is_array($decoded)) {
			$rolePermissions = array_merge($rolePermissions, $decoded);
			}
			}
			}
			}

 
				foreach ($keywords as $keyword) {
					if (isset($rolePermissions) && !in_array($keyword->keyword, $rolePermissions)) {
						//$destinationPermissions .= "<option value=\"$keyword->keyword\" selected>$keyword->keyword</option>";
						$sourcePermissions .= "<option value=\"$keyword->keyword\">$keyword->keyword</option>";
					} else {
						

					}
				}
		 
		 





			return view('admin.seo-kwd-assign.index', ['keywords' => $sourcePermissions, 'users' => $users]);
		 
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{  
		 
			$validator = Validator::make($request->all(), [
				'seo_id' => 'required|unique:seo_kwd_assign',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				$errors = [];
				foreach ($errorsBag as $error) {
					$errors[] = implode("<br/>", $error);
				}
				$errors = implode("<br/>", $errors);
				return response()->json(['status' => 0, 'errors' => $errors], 200);
			}

			$seoKwdAssign = new SeoKwdAssign;
			$seoKwdAssign->seo_id = $request->input('seo_id');
			$seoKwdAssign->kwd_assign = json_encode($request->input('kwd_assign'));
			$seoKwdAssign->created_by = Auth::id();

			if ($seoKwdAssign->save()) {
				$request->session()->flash('alert-success', 'SEO kwd assign successful updated !!');
				return redirect(url('/developer/seo-kwd-assign'));

			} else {
				$request->session()->flash('alert-danger', 'SEO kwd assign not updated !!');
				return redirect(url('/developer/seo-kwd-assign'));

			}
		 
	}

	/**
	 * Get paginated permissions.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedSeoKwdAssign(Request $request)
	{
		 
			$seoKwdAssigns = SeoKwdAssign::orderBy('id', 'desc')->paginate($request->input('length'));
			$returnPermissions = [];
			$data = [];
			$returnPermissions['draw'] = $request->input('draw');
			$returnPermissions['recordsTotal'] = $seoKwdAssigns->total();
			$returnPermissions['recordsFiltered'] = $seoKwdAssigns->total();
			$users = User::select('users.id', 'users.first_name', 'users.last_name')->get();
			if ($users) {
				foreach ($users as $user) {
					$owner[$user->id] = $user->first_name . " " . $user->last_name;
				}
			}
			foreach ($seoKwdAssigns as $seoKwd) {
				$html = '';
				$kwd_assigns = json_decode($seoKwd->kwd_assign);

				$owner_name = '';
				if ($seoKwd->seo_id != null && isset($owner[$seoKwd->seo_id])) {
					$owner_name = $owner[$seoKwd->seo_id];

				} else if ($seoKwd->seo_id != null && isset($owner[$seoKwd->seo_id])) {
					$owner_name = $owner[$seoKwd->updated_by];
				}
				$i = 1;
				if (!empty($kwd_assigns)) {
					foreach ($kwd_assigns as $p) {
						$br = "";
						if ($i % 4 == 0)
							$br .= "<br>";
						$html .= "<span class='label label-default'>$p</span>&nbsp;&nbsp;" . $br;
						++$i;
					}
				}
				$data[] = [
					$owner_name,
					$html,
					'<a href="/developer/seo-kwd-assign/edit/' . $seoKwd->id . '" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>'
				];
			}
			$returnPermissions['data'] = $data;
			return response()->json($returnPermissions);
		 
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{  //dd($request->all());
		 
			$keywords = Keyword::all();
			$edit_seoKwdAssign = SeoKwdAssign::find($id);
			$users = User::get();
			$sourcePermissions = "";
			$destinationPermissions = "";
			$assignUserKeywords = [];

			$allAssignUserKeywords = [];
			$get_seoKwdAssign = SeoKwdAssign::get();
			if ($get_seoKwdAssign) {
			foreach ($get_seoKwdAssign as $seoKwdAssign) {
			if (!is_null($seoKwdAssign->kwd_assign)) {
			$decoded = json_decode($seoKwdAssign->kwd_assign, true);
			if (is_array($decoded)) {
			$allAssignUserKeywords = array_merge($allAssignUserKeywords, $decoded);
			}
			}
			}
			}

			foreach ($keywords as $keyword) {
					if (isset($allAssignUserKeywords) && !in_array($keyword->keyword, $allAssignUserKeywords)) {
						 
						$sourcePermissions .= "<option value=\"$keyword->keyword\">$keyword->keyword</option>";
					}  
				}

			 
				$assignUserKeywords = json_decode($edit_seoKwdAssign->kwd_assign);

				foreach ($keywords as $keyword) {
					if (isset($assignUserKeywords) && in_array($keyword->keyword, $assignUserKeywords)) {
						$destinationPermissions .= "<option value=\"$keyword->keyword\" selected>$keyword->keyword</option>";
					}  
				}
			 


			return view('admin.seo-kwd-assign.update', ['id' => $id, 'users' => $users, 'edit_seoKwdAssign' => $edit_seoKwdAssign, 'usersAssigns' => ['sourcePermissions' => $sourcePermissions, 'destinationPermissions' => $destinationPermissions]]);
		 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{			 
		 
			$validator = Validator::make($request->all(), [
				'seo_id' => 'required|unique:seo_kwd_assign,seo_id,' . $id
			]);
			if ($validator->fails()) {
				return redirect(url('/developer/seo-kwd-assign/edit/' . $id))
					->withErrors($validator)
					->withInput();
			}
			$rolePermission = SeoKwdAssign::find($id);
			$rolePermission->seo_id = $request->input('seo_id');
			$rolePermission->kwd_assign = json_encode($request->input('kwd_assign'));
			$rolePermission->updated_by = Auth::id();
		 
			if ($rolePermission->save()) {
				$request->session()->flash('alert-success', 'Permission successful updated !!');
				return redirect(url('/developer/seo-kwd-assign'));
			} else {
				$request->session()->flash('alert-danger', 'Permission not updated !!');
				return redirect(url('/developer/seo-kwd-assign/edit/' . $id));
			}
		 
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		if ($request->ajax() && ($request->user()->current_user_can('administrator'))) {
			try {
				$permission = SeoKwdAssign::findorFail($id);
				if ($permission->delete()) {
					return response()->json(['status' => 1], 200);
				} else {
					return response()->json(['status' => 0], 400);
				}
			} catch (\Exception $e) {
				return response()->json(['status' => 0, 'errors' => 'Permission not found'], 200);
			}
		} else {
			return "Unh Cheatin`";
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getRolePermissions(Request $request, $id)
	{
		 
			try {
				$seoKwdAssign = SeoKwdAssign::where('seo_id', $id)->first();
				$keywords = Keyword::all();
				$seoKwdAssigns = unserialize($seoKwdAssign->kwd_assign);
				$html = "";
				foreach ($keywords as $keyword) {
					if (in_array($keyword->keyword, $seoKwdAssigns)) {
						$html .= "<option value='$keyword->keyword' selected>$keyword->keyword</option>";
					} else {
						$html .= "<option value='$keyword->keyword'>$keyword->keyword</option>";
					}
				}
				return response()->json(['status' => 1, 'html' => $html], 200);
			} catch (\Exception $e) {
				return response()->json(['status' => 0, 'errors' => 'Permission not found'], 200);
			}
		 
	}






	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function assignSeoKeyword(Request $request)
	{
 
		 
			$users = User::get();

			$keywords = Keyword::all();
			$get_seoKwdAssign = SeoKwdAssign::get();
			$users = User::get();
			$sourcePermissions = "";
			$destinationPermissions = "";

			$rolePermissions = [];

			if ($get_seoKwdAssign) {
			foreach ($get_seoKwdAssign as $seoKwdAssign) {
			if (!is_null($seoKwdAssign->kwd_assign)) {
			$decoded = json_decode($seoKwdAssign->kwd_assign, true);
			if (is_array($decoded)) {
			$rolePermissions = array_merge($rolePermissions, $decoded);
			}
			}
			}
			}

 
				foreach ($keywords as $keyword) {
					if (isset($rolePermissions) && !in_array($keyword->keyword, $rolePermissions)) {
						//$destinationPermissions .= "<option value=\"$keyword->keyword\" selected>$keyword->keyword</option>";
						$sourcePermissions .= "<option value=\"$keyword->keyword\">$keyword->keyword</option>";
					} else {
						

					}
				}
		 
		 
			return view('admin.seo-kwd-assign.assign-kwd', ['keywords' => $sourcePermissions, 'users' => $users]);
	 
		 
	}


	/**
	 * Get paginated permissions.
	 *
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedAssignSeoKeyword(Request $request)
	{
		  
 
			$seoKwdAssigns = SeoKwdAssign::where('seo_id',Auth::id())->orderBy('id', 'desc')->paginate($request->input('length'));
			$returnPermissions = [];
			$data = [];
			$returnPermissions['draw'] = $request->input('draw');
			$returnPermissions['recordsTotal'] = $seoKwdAssigns->total();
			$returnPermissions['recordsFiltered'] = $seoKwdAssigns->total();
			$users = User::select('users.id', 'users.first_name', 'users.last_name')->get();
			if ($users) {
				foreach ($users as $user) {
					$owner[$user->id] = $user->first_name . " " . $user->last_name;
				}
			}
			foreach ($seoKwdAssigns as $seoKwd) {
				$html = '';
				$kwd_assigns = json_decode($seoKwd->kwd_assign);

				$owner_name = '';
				if ($seoKwd->seo_id != null && isset($owner[$seoKwd->seo_id])) {
					$owner_name = $owner[$seoKwd->seo_id];

				} else if ($seoKwd->seo_id != null && isset($owner[$seoKwd->seo_id])) {
					$owner_name = $owner[$seoKwd->updated_by];
				}
				$i = 1;
				if (!empty($kwd_assigns)) {
					foreach ($kwd_assigns as $p) {
						$br = "";
						if ($i % 4 == 0)
							$br .= "<br>";
						$html .= "<span class='label label-default'>$p</span>&nbsp;&nbsp;" . $br;
						++$i;
					}
				}
				$data[] = [
					 
					$html
				];
			}
			$returnPermissions['data'] = $data;
			return response()->json($returnPermissions);
	 
	}


}
