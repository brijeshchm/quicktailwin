<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use App\Models\Occupation;
class OccupationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$data['title'] = "Occupation";
		$data['header'] = "Occupation";
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		return view('admin.occupation.index', ['search' => $search, 'data' => $data]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function occupationAdd()
	{
		$data['title'] = "Add Occupation";
		$data['header'] = "Add Occupation";
		return view('admin.occupation.index', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function occupationSave(Request $request)
	{

		if ($request->ajax()) {

			$validator = Validator::make($request->all(), [
				'name' => 'required|unique:occupations,name|min:3|max:25',


			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}



			$occupation = new Occupation;
			$occupation->name = $request->input('name');
			$occupation->status = '1';
			if ($occupation->save()) {
				$status = 1;
				$msg = "Occupation submitted successfully!";

			} else {
				$status = 0;
				$msg = "Occupation could not be submitted, Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);

		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$edit_data = occupation::find(base64_decode($id));
		$data['title'] = "Add Occupation";
		$data['header'] = "Add Occupation";

		return view("admin.occupation.index", ['edit_data' => $edit_data, 'data' => $data]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function occupationEditSave(Request $request, $id)
	{
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [
				'name' => 'required|max:255|unique:occupations,name,' . $id . ',id',
			]);


			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$occupation = Occupation::find($id);
			$occupation->name = $request->input('name');
			$occupation->status = '1';

			if ($occupation->save()) {
				$status = 1;
				$msg = "occupation updated successfully!";

			} else {
				$status = 0;
				$msg = "occupation could not be updated, Please try again!";
			}

			return response()->json(['status' => $status, 'msg' => $msg], 200);

		}

	}


	public function getOccupationPagination(Request $request)
	{

		if ($request->ajax()) {

			$occupations = Occupation::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$occupations = $occupations->where(function ($query) use ($request) {
					$query->orWhere('name', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}


			$occupations = $occupations->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $occupations->total();
			$returnLeads['recordsFiltered'] = $occupations->total();
			$returnLeads['recordCollection'] = [];
			foreach ($occupations as $occupation) {

				$action = '';
				$status = '';

				$action .= '<a href="/developer/occupationEdit/edit/' . base64_encode($occupation->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($occupation->id > 9) {
					$action .= '<a href="javascript:occupationController.delete(' . $occupation->id . ')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				if ($occupation->status == '1') {
					$status .= '<a href="javascript:occupationController.status(' . $occupation->id . ',0)" title="occupation status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:occupationController.status(' . $occupation->id . ',1)" title="occupation status" class="btn btn-danger" >Inactive</a>';
				}

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$occupation->id'></th>",
					$occupation->name,
					$status,
					$action

				];
				$returnLeads['recordCollection'][] = $occupation->id;
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
	public function delete(Request $request, $id)
	{

		$occupation = Occupation::findOrFail($id);
		if ($occupation->delete()) {
			$status = 1;
			$msg = "occupation Deleted Successfully!";
		} else {
			$status = 0;
			$msg = "occupation could not be Deleted!";
		}
		return response()->json(['status' => $status, 'msg' => $msg], 200);
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

			$occupation = Occupation::findOrFail($id);
			$occupation->status = $val;

			if ($occupation->save()) {
				$status = 1;
				$msg = "Occupation status updated successfully !";
			} else {
				$status = 0;
				$msg = "Occupation status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}


}
