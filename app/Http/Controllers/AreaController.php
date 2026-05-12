<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Area;
use App\Models\Citieslists; //Model

class AreaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_area'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {
			$areas = DB::table('areas');
			$areas = $areas->join('zones', 'zones.id', '=', 'areas.zone_id');
			$areas = $areas->join('citylists', 'citylists.id', '=', 'zones.city_id');
			$areas = $areas->select('areas.id', 'areas.area', 'areas.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');
			if ($request->input('search.value') != '') {
				$areas = $areas->where(function ($query) use ($request) {
					$query->orWhere('areas.area', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$areas = $areas->orderBy('areas.id', 'desc');
			$areas = $areas->paginate($request->input('length'));
			$returnareas = $data = [];
			$returnareas['draw'] = $request->input('draw');
			$returnareas['recordsTotal'] = $areas->total();
			$returnareas['recordsFiltered'] = $areas->total();
			foreach ($areas as $area) {
				$data[] = [
					$area->area,
					$area->zone,
					$area->city,
					'<a href="/developer/area/update/' . $area->id . '"><i class="fa fa-refresh" aria-hidden="true"></i></a> | <a href="javascript:areaController.delete(' . $area->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>'
				];
			}
			$returnareas['data'] = $data;
			return response()->json($returnareas);
		}
		return view('admin.area.area');
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('add_area'))) {
			return view('errors.unauthorised');
		}
		$validator = Validator::make($request->all(), [
			'area' => 'required|unique:areas,area,NULL,id,zone_id,' . $request->input('zone_id'),
			'zone_id' => 'required',
			'city_id' => 'required',
		]);

		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			$errors = [];
			foreach ($errorsBag as $error) {
				$errors[] = implode("<br/>", $error);
			}
			$errors = implode("<br/>", $errors);
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => $errors
				]
			], 200);
		}

		$area = new Area;
		$area->area = $request->input('area');
		$area->zone_id = $request->input('zone_id');
		if ($area->save()) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => "Area added successfully !!"
				]
			], 200);
		} else {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 400,
					"payload" => "",
					"message" => "Area not added !!"
				]
			], 200);
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
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_area'))) {
			return view('errors.unauthorised');
		}
		try {
			Area::findOrFail($id);
			$area = DB::table('areas');
			$area = $area->join('zones', 'zones.id', '=', 'areas.zone_id');
			$area = $area->join('citylists', 'citylists.id', '=', 'zones.city_id');
			$area = $area->select('areas.*', 'zones.zone', 'zones.city_id', 'citylists.city');
			$area = $area->where('areas.id', $id);
			$area = $area->first();
			if ($area) {
				return view('admin.area.area_update', ['area' => $area]);
			}
		} catch (\Exception $e) {
			return "Area not found !!";
		}
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
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_area'))) {
			return view('errors.unauthorised');
		}
		$validator = Validator::make($request->all(), [
			'area' => 'required|unique:areas,area,' . $id . ',id,zone_id,' . $request->input('zone_id'),
			'zone_id' => 'required',
			'city_id' => 'required',
		]);

		if ($validator->fails()) {
			return redirect('developer/area/update/' . $id)
				->withErrors($validator)
				->withInput();
		}

		try {
			$area = Area::findOrFail($id);
			if ($area) {
				$area->area = $request->area;
				$area->zone_id = $request->zone_id;
				if ($area->save()) {
					return redirect()->back()->with('success', 'Area updated successfully !!');
				} else {
					return redirect()->back()->with('danger', 'Area not updated !!');
				}
			}
		} catch (\Exception $e) {
			return "Area not found !!";
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
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_area'))) {
			return view('errors.unauthorised');
		}
		try {
			$area = Area::findorFail($id);
			if ($area->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Area deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Area not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Area not found !!"
				]
			], 200);
		}
	}

	/**
	 * Return the areas(id,name) associated to the specified zone id.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return JSON Payload
	 */
	public function getAreas(Request $request, $zone_id)
	{
		$id = $zone_id;
		$areas = Area::where('zone_id', $id)->select('id', 'area')->get();
		if ($areas) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => $areas,
					"message" => "Populated the area dropdown successfully !!"
				]
			], 200);
		} else {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Areas not found associated to the selected zone !!"
				]
			], 200);
		}
	}

	/**
	 * Return area_zone for the specified string
	 *
	 * @param  string q
	 * @param  string city
	 * @return \Illuminate\Http\Response
	 */
	public function getAjaxAreas(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {
		 
			if ($request->has('q')) {
				//$city = Citieslists::where('city', 'LIKE', $request->input('city'))->first();
			 
			$city = Citieslists::where('id',  $request->input('city'))->first();
				if ($city) {
				$zones = DB::table('zones')				 
					->where('city_id',$city->id)
					->where(function ($query) use ($request) {
						$q = $request->input('q');
						$query->where('zones.zone', 'LIKE', "%$q%")							 
							->orWhere('zones.pincode', 'LIKE', "%$q%");
					})
					->select('zones.id as zone_id', 'zones.zone','zones.pincode')
					->distinct()
					->get();

				}

			}else{
				$city = Citieslists::where('id',  $request->input('city'))->first();
				if ($city) {
					$zones = DB::table('zones')->select('zones.id as zone_id', 'zones.zone','zones.pincode');
					$zones = $zones->where('city_id', $city->id);
					$zones = $zones->get();
				}
			} 
		}
			return response()->json(['status' => 1, 'areas' => $zones]);

	}
	public function getAjaxAreas_old(Request $request)
	{


	
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {
			$areas = "";
			if ($request->has('q')) {

				$city = Citieslists::where('city', 'LIKE', $request->input('city'))->first();
				if ($city) {
					$areas = DB::table('areas');
					$areas = $areas->join('zones', 'zones.id', '=', 'areas.zone_id');
					$areas = $areas->join('citylists', 'citylists.id', '=', 'zones.city_id');
					$areas = $areas->select('areas.id', 'areas.area', 'areas.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');
					$areas = $areas->where('citylists.id', $city->id);
					$areas = $areas->where(function ($query) use ($request) {
						$query = $query->orWhere('areas.area', 'LIKE', '%' . $request->input('q') . '%');
						$query = $query->orWhere('zones.zone', 'LIKE', '%' . $request->input('q') . '%');
					});
					$areas = $areas->get();
				}

			} else {


				$city = Citieslists::where('city', 'LIKE', $request->input('city'))->first();
				if ($city) {
					$areas = DB::table('areas');
					$areas = $areas->join('zones', 'zones.id', '=', 'areas.zone_id');
					$areas = $areas->join('citylists', 'citylists.id', '=', 'zones.city_id');
					$areas = $areas->select('areas.id', 'areas.area', 'areas.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');
					$areas = $areas->where('citylists.id', $city->id);
					$areas = $areas->get();
				}

			}

		}
		return response()->json(['status' => 1, 'areas' => $areas]);

	}
}