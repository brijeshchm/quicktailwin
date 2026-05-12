<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use DB; 
use App\Models\FormType; //Model
 
class FormTypeController extends Controller
{
	 

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		 $data['title'] = "form type";
        $data['header'] = "form type";
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
	 
		return view('admin.form-type.index', ['search' => $search,'data' => $data,]);

	}

/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function formTypeAdd()
	{
		$data['title'] = "Add form type";
		$data['header'] = "Add form type";
		return view('admin.form-type.index', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function formTypeSave(Request $request)
	{

		if (!($request->user()->current_user_can('administrator'))) {
			return view('errors.unauthorised');
		}

		$validator = Validator::make($request->all(), [
			'form_type' => 'required|unique:form_types,form_type|min:3|max:25',			 
		]);

		if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


		$formType = new FormType;
		$formType->form_type = $request->input('form_type');
		 
		if ($formType->save()) {
				$status = 1;
				$msg = "formType submitted successfully!";

			} else {
				$status = 0;
				$msg = "formType could not be submitted, Please try again!";
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
		$edit_data = FormType::findOrFail(base64_decode($id));
        return view('admin.form-type.index', ['data' => $data, 'edit_data' => $edit_data]);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function formTypeEditSave(Request $request,$id)
	{
		 
	 
	 
		  if ($request->ajax()) {
 			
            $validator = Validator::make($request->all(), [
                'form_type' => 'required|max:255|unique:form_types,form_type,' . $id . ',id',

            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }
			try {
		 
			 $formType = FormType::findOrFail($id);
                $formType->form_type = trim($request->input('form_type'));
			   if ($formType->save()) {
                    $status = 1;
                    $msg = "form type updated successfully!";

                } else {
                    $status = 0;
                    $msg = "form type could not be updated, Please try again!";
                }

                return response()->json(['status' => $status, 'msg' => $msg], 200);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
	}
		
	}



	public function getFormTypePagination(Request $request)
	{

		if ($request->ajax()) {

			$formType = FormType::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$formType = $formType->where(function ($query) use ($request) {
					$query->where('form_type', 'LIKE', '%' . $request->input('search.value') . '%');
						 
				});
			}
			$formType = $formType->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $formType->total();
			$returnLeads['recordsFiltered'] = $formType->total();
			$returnLeads['recordCollection'] = [];
			foreach ($formType as $form) {

				$action = '';
				$separator = '';
				$action .= '<a href="/developer/form-type/edit/' . base64_encode($form->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($form->id > 9) {
					$action .= '<a href="javascript:formTypeController.delete(' . $form->id . ')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				$status="";
				if ($form->status == '1') {
					$status .= '<a href="javascript:formTypeController.status(' . $form->id . ',0)" title="occupation status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:formTypeController.status(' . $form->id . ',1)" title="occupation status" class="btn btn-danger" >Inactive</a>';
				}

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$form->id'></th>",
					$form->form_type,				 
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
			FormType::destroy($id);
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

			$formType = FormType::findOrFail($id);
			$formType->status = $val;

			if ($formType->save()) {
				$status = 1;
				$msg = "formType status updated successfully !";
			} else {
				$status = 0;
				$msg = "formType status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}
}
