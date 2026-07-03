<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use DB; 
use App\Models\Email; //Model
 
class EmailController extends Controller
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
	 
		return view('admin.email.index', ['search' => $search,'data' => $data,]);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function emailAdd()
	{
		$data['title'] = "Add Email";
		$data['header'] = "Add Email";
		return view('admin.email.index', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function emailSave(Request $request)
	{

		if (!($request->user()->current_user_can('administrator'))) {
			return view('errors.unauthorised');
		}

		$validator = Validator::make($request->all(), [
			'email' => 'required|unique:emails,email|min:3|max:25',			 
		]);

		if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


		$email = new Email;
		$email->name = $request->input('name');
		$email->email = $request->input('email');
		 
		if ($email->save()) {
				$status = 1;
				$msg = "Email submitted successfully!";

			} else {
				$status = 0;
				$msg = "Email could not be submitted, Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);

	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$data['title'] = "Edit Classified Profile";
        $data['header'] = "Edit Classified Profile";
		$edit_data = Email::findOrFail(base64_decode($id));
        return view('admin.email.index', ['data' => $data, 'edit_data' => $edit_data]);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function emailEditSave(Request $request,$id)
	{
		 
	 
	 
		  if ($request->ajax()) {
 			
            $validator = Validator::make($request->all(), [
                'email' => 'required|max:255|unique:emails,email,' . $id . ',id',

            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }
			try {
		 
			 $email = Email::findOrFail($id);
                $email->name = trim($request->input('name'));
                $email->email = trim($request->input('email'));
			   if ($email->save()) {
                    $status = 1;
                    $msg = "Email updated successfully!";

                } else {
                    $status = 0;
                    $msg = "Email could not be updated, Please try again!";
                }

                return response()->json(['status' => $status, 'msg' => $msg], 200);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
	}
		
	}



	public function getemailPagination(Request $request)
	{

		if ($request->ajax()) {

			$email = email::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$email = $email->where(function ($query) use ($request) {
					$query->where('email', 'LIKE', '%' . $request->input('search.value') . '%')
						->where('name', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$email = $email->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $email->total();
			$returnLeads['recordsFiltered'] = $email->total();
			$returnLeads['recordCollection'] = [];
			foreach ($email as $form) {

				$action = '';
				$separator = '';
				$action .= '<a href="/developer/email/edit/' . base64_encode($form->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($form->id > 9) {
					$action .= '<a href="javascript:emailController.delete(' . $form->id . ')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				$status="";
				if ($form->status == '1') {
					$status .= '<a href="javascript:emailController.status(' . $form->id . ',0)" title="occupation status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:emailController.status(' . $form->id . ',1)" title="occupation status" class="btn btn-danger" >Inactive</a>';
				}

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$form->id'></th>",
					$form->name,				 
					$form->email,				 
					$status,				 
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
			Email::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'Form deleted succesfully!!']);
		}
	}
	 


	/**
	 * Remove the specified resource from storage status.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function status(request $request, $id, $val)
	{


		if ($request->ajax()) {

			$email = Email::findOrFail($id);
			$email->status = $val;

			if ($email->save()) {
				$status = 1;
				$msg = "Email status updated successfully !";
			} else {
				$status = 0;
				$msg = "Email status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}
}
