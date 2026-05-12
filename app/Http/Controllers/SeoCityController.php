<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use App\Models\City;
class SeoCityController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$data['title'] = "seoCity";
		$data['header'] = "seoCity";
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		return view('admin.city.index', ['search' => $search, 'data' => $data]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function seoCityAdd()
	{
		$data['title'] = "Add seoCity";
		$data['header'] = "Add seoCity";
		return view('admin.city.index', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function seoCitySave(Request $request)
	{

		if ($request->ajax()) {

			$validator = Validator::make($request->all(), [
				'city' => 'required|unique:cities,city|min:3|max:25',


			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}



			$city = new City;
			$city->city = $request->input('city');
			$city->popular = '1';
			if ($city->save()) {
				$status = 1;
				$msg = "seoCity submitted successfully!";

			} else {
				$status = 0;
				$msg = "seoCity could not be submitted, Please try again!";
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
		$edit_data = City::find(base64_decode($id));
		$data['title'] = "Add seoCity";
		$data['header'] = "Add seoCity";

		return view("admin.city.index", ['edit_data' => $edit_data, 'data' => $data]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function seoCityEditSave(Request $request, $id)
	{
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [
				'city' => 'required|max:255|unique:cities,city,' . $id . ',id',
			]);


			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$city = City::find($id);
			$city->city = $request->input('city');
			$city->popular = '1';

			if ($city->save()) {
				$status = 1;
				$msg = "City updated successfully!";

			} else {
				$status = 0;
				$msg = "City could not be updated, Please try again!";
			}

			return response()->json(['status' => $status, 'msg' => $msg], 200);

		}

	}


	public function getSeoCityPagination(Request $request)
	{

		if ($request->ajax()) {

			$citys = City::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$citys = $citys->where(function ($query) use ($request) {
					$query->orWhere('city', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}


			$citys = $citys->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $citys->total();
			$returnLeads['recordsFiltered'] = $citys->total();
			$returnLeads['recordCollection'] = [];
			foreach ($citys as $city) {

				$action = '';
				$status = '';

				$action .= '<a href="/developer/seoCity/edit/' . base64_encode($city->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($city->id > 9) {
					$action .= '<a href="javascript:seoCityController.delete(' . $city->id . ')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				if ($city->popular == '1') {
					$status .= '<a href="javascript:seoCityController.status(' . $city->id . ',0)" title="occupation status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:seoCityController.status(' . $city->id . ',1)" title="occupation status" class="btn btn-danger" >Inactive</a>';
				}

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$city->id'></th>",
					$city->city,
					$status,
					$action

				];
				$returnLeads['recordCollection'][] = $city->id;
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
		$city = City::findOrFail($id);
		if ($city->delete()) {
			$status = 1;
			$msg = "city Deleted Successfully!";
		} else {
			$status = 0;
			$msg = "city could not be Deleted!";
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

			$city = City::findOrFail($id);
			$city->popular = $val;

			if ($city->save()) {
				$status = 1;
				$msg = "City status updated successfully !";
			} else {
				$status = 0;
				$msg = "City status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}


}
