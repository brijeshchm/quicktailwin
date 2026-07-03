<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use DB; 
use App\Models\Contacts; //Model
 
class ContactsController extends Controller
{
	 

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$data['title'] = "Email List";
        $data['header'] = "Email List";
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
	 
		return view('admin.contacts.index', ['search' => $search,'data' => $data,]);

	}

	  



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Hsttp\Response
	 */
	public function view(Request $request, $id)
	{
		$data['title'] = "Edit Classified Profile";
        $data['header'] = "Edit Classified Profile";
		$edit_data = Contacts::findOrFail(base64_decode($id));
        return view('admin.contacts.index', ['data' => $data, 'edit_data' => $edit_data]);

	}

	public function getContactsPagination(Request $request)
	{
		if ($request->ajax()) {

			$contacts = Contacts::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$contacts = $contacts->where(function ($query) use ($request) {
					$query->where('email', 'LIKE', '%' . $request->input('search.value') . '%')
						->where('name', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$contacts = $contacts->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $contacts->total();
			$returnLeads['recordsFiltered'] = $contacts->total();
			$returnLeads['recordCollection'] = [];
			foreach ($contacts as $form) {

				$action = '';
				$separator = '';
			 


				if ($form->id > 9) {
					$action .= '<a href="javascript:contactsController.delete(' . $form->id . ')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

		 

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$form->id'></th>",
					$form->name,				 
					$form->email,				 
					$form->mobile,				 
					$form->subject,				 
					$form->message,		 				 
					$action

				];
				$returnLeads['recordCollection'][] = $form->id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
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

 
		if ($request->ajax()) {
			if (!($request->user()->current_user_can('administrator') )) {
				return response()->json(['status' => 0, 'msg' => 'Unauthorised access'], 200);
			}
			Contacts::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'Form deleted succesfully!!']);
		}
	}
	 


	 
}
