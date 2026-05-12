<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use DB;

use App\Models\City; //Model
use App\Models\Citieslists; //Model
use App\Models\Zone;

class CitiesController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		$citiess = Citieslists::all();
		$states = Citieslists::select('state')->groupBy('state')->get();
		return view('admin.citylist.citieslist', ['allCities' => $citiess, 'search' => $search, 'states' => $states]);

	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('add_city'))) {
			return view('errors.unauthorised');
		}

		$validator = Validator::make($request->all(), [
			'city' => 'required|unique:citylists,city|min:3|max:25',
			'state' => 'required'
		]);

		if ($validator->fails()) {
			return redirect("developer/cities")
				->withErrors($validator)
				->withInput();
		}

		$city = new Citieslists;
		$city->city = $request->input('city');
		$city->state = $request->input('state');
		$city->latitude = $request->input('latitude');
		$city->longitude = $request->input('longitude');
		if ($city->save()) {
			$this->success_msg .= 'City added succesfully!';
			$request->session()->flash('success_msg', $this->success_msg);
		}
		return redirect("developer/cities");
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{

		if ($request->ajax()) {
			if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_city'))) {
				return response()->json(['status' => 0, 'msg' => 'Unauthorised access'], 200);
			}
			$city = Citieslists::find($id);
			$checked = '';

			$states = Citieslists::where('')->groupby('state')->get();
			$statesHTML = '';
			if (!empty($states)) {
				foreach ($states as $state) {

					if ($state->state == $city->state) {
						$statesHTML .= '<option value="' . $state->state . '" selected>' . $state->state . '</option>';
					} else {
						$statesHTML .= '<option value="' . $state->state . '">' . $state->state . '</option>';
					}
				}
			}
			$html = '<input type="hidden" name="_token" value="' . csrf_token() . '">			
			<input type="hidden" value="' . $city->id . '" name="id">
				 
				<label for="State">State:</label>	
				<select type="text" class="form-control" name="state" >
				<option value="">Select State</option> 
				 ' . $statesHTML . '								
				</select>			
				<label>Enter the city name:</label>
				<input type="text" name="city" class="form-control" value="' . $city->city . '">			
				<label>Enter Latitude:</label>
				<input type="text" name="latitude" class="form-control" value="' . $city->latitude . '">
				<label>Enter longitude:</label>
				<input type="text" name="longitude" class="form-control" value="' . $city->longitude . '">';



			return response()->json(['status' => 1, 'msg' => $html]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_city'))) {
			return view('errors.unauthorised');
		}


		if ($request->input('id') != '') {
			$validator = Validator::make($request->all(), [

				'city' => 'required|max:255|unique:citylists,city,' . $request->input('id') . ',id',
				'state' => 'required'
			]);

			if ($validator->fails()) {
				return redirect("developer/cities")
					->withErrors($validator)
					->withInput();
			}
			if ($request->input('id') != '') {
				$id = $request->input('id');
				$city = Citieslists::find($id);
				$city->city = $request->input('city');
				$city->state = $request->input('state');
				$city->latitude = $request->input('latitude');
				$city->longitude = $request->input('longitude');
				if ($city->save()) {
					$this->success_msg .= 'City updated succesfully!';
					$request->session()->flash('success_msg', $this->success_msg);
				}
				return redirect("developer/cities");
			}
		}
	}



	public function getCitiesPagination(Request $request)
	{

		if ($request->ajax()) {

			$cities = Citieslists::orderBy('city', 'desc');
			if ($request->input('search.value') != '') {

				$cities = $cities->where(function ($query) use ($request) {
					$query->orWhere('city', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('state', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$cities = $cities->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $cities->total();
			$returnLeads['recordsFiltered'] = $cities->total();
			$returnLeads['recordCollection'] = [];
			foreach ($cities as $city) {

				$action = '';
				$separator = '';
				$action .= $separator . '<a href="javascript:void(0)" onclick="javascript:updateCity(' . $city->id . ',this)"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a>';
				$separator = ' | ';


				if ($request->user()->current_user_can('administrator')) {

					$action .= $separator . '<a href="javascript:void(0)" onclick="javascript:deleteCity(' . $city->id . ',this)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>';
					$separator = ' | ';


				}

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$city->id'></th>",
					$city->city,
					$city->state,
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
	public function destroy(Request $request, $id)
	{
		if ($request->ajax()) {
			if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_city'))) {
				return response()->json(['status' => 0, 'msg' => 'Unauthorised access'], 200);
			}
			Citieslists::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'City deleted succesfully!!']);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getAjaxCities(Request $request)
	{

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {

			if ($request->has('q')) {
				$cities = DB::table('citylists')->select('id', 'city')->where('city', 'LIKE', '%' . $request->input('q') . '%')->get();
 
			} else {
				$cities = Citieslists::select('id', 'city')->get();

			}
			return response()->json(['status' => 1, 'cities' => $cities]);
		}
	}
	public function getAjaxLocation(Request $request)
	{

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {

			if ($request->has('q')) {
				$zones = DB::table('zones')
					->join('citylists', 'citylists.id', '=', 'zones.city_id')
					->where(function ($query) use ($request) {
						$q = $request->input('q');
						$searchKW = implode(' ', array_map(function($word) {
						return ucfirst($word);
						}, explode('-', $request->input('q'))));

						$query->where('zones.zone', 'LIKE', "%$q%")
							->orWhere('citylists.city','LIKE',"%$searchKW%")
							->orWhere('zones.pincode', 'LIKE', "%$q%");
					})
					->select('zones.id as zone_id', 'zones.zone', 'citylists.city', 'zones.pincode')
					->distinct()
					->get();

			} else {
				$cityList = [
					'hyderabad',
					'Patna',
					'gorakhpur',
					'Faridabad',
					'Delhi',
					'Noida',
					'Ghaziabad',
					'Mumbai',
					'Pune',
					'Meerut',
					'Bangalore',
					'indore',
					'kanpur',
					'Chennai',
					'kolkata',
					'coimbatore',
					'prayagraj'
				];

				$zones = DB::table('zones')
					->join('citylists', 'citylists.id', '=', 'zones.city_id')
					->select(
						'zones.id as zone_id',
						'zones.zone',
						'citylists.city',
						'zones.pincode'
					)
					->whereIn('citylists.city', $cityList)
					->groupBy('citylists.city')
					->get();

				//  dd($zones);


			}
			return response()->json(['status' => 1, 'zones' => $zones]);
		}
	}
	public function getAjaxService(Request $request)
	{

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');

		if ($request->wantsJson()) {

			$q = trim($request->input('q'));

			// Empty collection
			$keywords = collect();

			/* ------------------------
			   1. Keyword table search
			-------------------------*/
			if (!empty($q)) {
 
				$keywordData = DB::table('keyword')
					->where('keyword', 'LIKE', "%{$q}%")
					->select('keyword','slug')
					->distinct()
					->limit('40')
					->get();

			} else {

				$keywordList = [
					'Dentists',
					'PG Hostels',
					'AWS Training',
					'Data Science Training',
					'Workday Training',
					'SAP Training',
					'Python Training',
					'Nursing Services',
					'Computer Repair',
					'Government Agencies Lawyers',
					'Tours and Travels',
					'Real Estate Agent',
					'Language Training',
					'Spa Massages',
					'Study Abroad',
					'Wedding Organizers',
					'Electric Services',
					'Boarding Schools',
					'Web Designers',
					'CCTV Security',
					'Dance Class'
				];

				$keywordData = DB::table('keyword')
					->whereIn('keyword', $keywordList)
					->select('keyword','slug')
					->distinct()
					->limit(20)
					->get();
			}

			$keywords = $keywords->merge($keywordData);

			/* ------------------------
			   2. Client business_name search
			-------------------------*/
			if (!empty($q)) {

				$clientData = DB::table('clients')
					->where('business_name', 'LIKE', "%{$q}%")
					->select('business_name as keyword','business_slug as slug')
					->distinct()
					->limit(20)
					->get();

				$keywords = $keywords->merge($clientData);
			}

			/* ------------------------
			   3. Clean collection
			-------------------------*/
			$keywords = $keywords
				->unique('keyword')    
				->values();          
 
			return response()->json([
				'status' => true,
				'keywords' => $keywords
			]);
		}


	}



	public function getAjaxCity(Request $request)
	{
		$sid = $request->input('sid');
		$cid = $request->input('cid');
		$citys = DB::table('citylists')->where('state_id', $sid)->get();

		if ($citys) {
			echo '<option value="">Select City</option>';
			foreach ($citys as $city) {
				$selected = ($cid == $city->id) ? "selected" : '';

				echo '<option value="' . $city->id . '" ' . $selected . ' >' . $city->city . '</option>';

			}
		} else {
			echo '<option value="">No record found</option>';
		}
	}

	public function getAjaxZone(Request $request)
	{

		$cid = $request->input('city');
		$zid = $request->input('zone');
		$zones = DB::table('zones')->where('city_id', $cid)->get();

		if ($zones) {
			echo '<option value="">Select zone</option>';
			foreach ($zones as $zone) {
				$selected = ($zid == $zone->id) ? "selected" : '';

				echo '<option value="' . $zone->id . '" ' . $selected . ' >' . $zone->zone . '</option>';

			}
			echo '<option value="Other">Other</option>';
		} else {
			echo '<option value="">No record found</option>';
		}






	}
}
