<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Zone;
use App\Models\City;
use App\Models\Citieslists; //Model
use App\Models\State; //Model
use Validator;
use DB;
use App\Imports\ZoneImport;
use Maatwebsite\Excel\Facades\Excel;
 
use App\Services\ZoneExcelImport;
class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if(!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_zone'))){
			return view('errors.unauthorised');
		}
		if($request->ajax()){
			$zones = DB::table('zones');
			$zones = $zones->join('citylists','citylists.id','=','zones.city_id');
			$zones = $zones->select('zones.id','zones.zone','zones.city_id','citylists.city');
			if($request->input('search.value')!=''){
				$zones = $zones->where(function($query) use($request){
					$query->orWhere('zones.zone','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$zones = $zones->orderBy('zones.id','desc');
			$zones = $zones->paginate($request->input('length'));
			$returnzones = $data = [];
			$returnzones['draw'] = $request->input('draw');
			$returnzones['recordsTotal'] = $zones->total();
			$returnzones['recordsFiltered'] = $zones->total();
			foreach($zones as $zone){
				$data[] = [
					$zone->zone,
					$zone->city,
					'<a href="/developer/zone/update/'.$zone->id.'"><i class="fa fa-refresh" aria-hidden="true"></i></a> | <a href="javascript:zoneController.delete('.$zone->id.')"><i class="fa fa-trash" aria-hidden="true"></i></a>'
				];
			}
			$returnzones['data'] = $data;
			return response()->json($returnzones);
		}
        return view('admin.zone.zone');
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if(!($request->user()->current_user_can('administrator') ||  $request->user()->current_user_can('add_zone'))){
			return view('errors.unauthorised');
		}
		$city = Citieslists::where('city','LIKE',$request->input('city_id'))->first();
		 
		$validator = Validator::make($request->all(),[
			'zone'=>'required|unique:zones,zone,NULL,id,city_id,'.$city->id,
			'city_id'=>'required',
		]);
		
		if($validator->fails()){
			$errorsBag = $validator->getMessageBag()->toArray();
			$errors = [];
			foreach($errorsBag as $error){
				$errors[] = implode("<br/>",$error);
			}
			$errors = implode("<br/>",$errors);
			return response()->json([
				"statusCode"=>0,
				"data"=>[
					"responseCode"=>200,
					"payload"=>"",
					"message"=>$errors
				]
			],200);
		}
		
		$zone = new Zone;
		$zone->zone = $request->input('zone');
		$city = Citieslists::where('city','LIKE',$request->input('city_id'))->first();
		$zone->city_id = $city->id;
		if($zone->save()){
			return response()->json([
				"statusCode"=>1,
				"data"=>[
					"responseCode"=>200,
					"payload"=>"",
					"message"=>"Zone added successfully !!"
				]
			],200);
		}else{
			return response()->json([
				"statusCode"=>0,
				"data"=>[
					"responseCode"=>400,
					"payload"=>"",
					"message"=>"Zone not added !!"
				]
			],200);
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
		if(!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_zone'))){
			return view('errors.unauthorised');
		}
		try{
			
			$edit_data= Zone::findOrFail($id);
			 $citylists= Citieslists::all();
			if($edit_data){
				return view('admin.zone.zone_update',['edit_data'=>$edit_data,'citylists'=>$citylists]);
			}
		}catch(\Exception $e){
			return "Zone not found !!";
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
        if(!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_zone'))){
			return view('errors.unauthorised');
		}
		$validator = Validator::make($request->all(),[
			'zone'=>'required|unique:zones,zone,'.$id.',id',			 
			'cityid'=>'required',
		]);
		
		if($validator->fails()){
            return redirect('developer/zone/update/'.$id)
                        ->withErrors($validator)
                        ->withInput();
		}
		
		try{
			$zone = Zone::findOrFail($id);	
 		
			if($zone){
				$zone->zone = $request->input('zone');
				$zone->city_id = $request->input('cityid');
				if($zone->save()){
				 
					return redirect('/developer/zone')->with('success_msg','Zone updated successfully !');
					 
				}else{
					return redirect()->back()->with('danger','Zone not updated !!');
				}
			}
		}catch(\Exception $e){
			return "Zone not found !!";
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
               
		if(!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_zone'))){
			return view('errors.unauthorised');
		}
		try{
			$zone = Zone::findorFail($id);
			if($zone->delete()){
				return response()->json([
					"statusCode"=>1,
					"data"=>[
						"responseCode"=>200,
						"payload"=>"",
						"message"=>"Zone deleted successfully !!"
					]
				],200);
			}else{
				return response()->json([
					"statusCode"=>0,
					"data"=>[
						"responseCode"=>400,
						"payload"=>"",
						"message"=>"Zone not deleted !!"
					]
				],200);
			}
		}catch(\Exception $e){
			return response()->json([
				"statusCode"=>0,
				"data"=>[
					"responseCode"=>404,
					"payload"=>"",
					"message"=>$e->getMessage(),
				]
			],200);
		}
    }
	
    /**
     * Return the zones(id,name) associated to the specified city id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JSON Payload
     */
    public function getState(Request $request, $state_id)
    {	
		$id = $state_id;
		$cities = Citieslists::where('state_id','LIKE',$state_id)->get();
	 
		if($cities){
			return response()->json([
				"statusCode"=>1,
				"data"=>[
					"responseCode"=>200,
					"payload"=>$cities,
					"message"=>"Populated the zone dropdown successfully !!"
				]
			],200);
		}else{
			return response()->json([
				"statusCode"=>0,
				"data"=>[
					"responseCode"=>404,
					"payload"=>"",
					"message"=>"Zones not found associated to the selected city !!"
				]
			],200);			
		}
    }
    /**
     * Return the zones(id,name) associated to the specified city id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JSON Payload
     */
    public function getZones(Request $request, $city_id)
    {	
		$id = $city_id;
		 
	
		$zones = Zone::where('city_id',$city_id)->get();
		if($zones){
			return response()->json([
				"statusCode"=>1,
				"data"=>[
					"responseCode"=>200,
					"payload"=>$zones,
					"message"=>"Populated the zone dropdown successfully !!"
				]
			],200);
		}else{
			return response()->json([
				"statusCode"=>0,
				"data"=>[
					"responseCode"=>404,
					"payload"=>"",
					"message"=>"Zones not found associated to the selected city !!"
				]
			],200);			
		}
    }

public function createBulkUploadZone(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('lead_bulk_upload'))) {
			return view('errors.unauthorised');
		}
		return view('admin.bulkupload.bulk_zone');
	}

	 
	public function importExcelZone(Request $request)
	{
		// $request->validate([
		// 	'upload_file' => 'required|mimes:xlsx,xls,csv'
		// ]);
	//   dd($request->all());
		Excel::import(new ZoneExcelImport, $request->file('upload_file'));

		$request->session()->flash('success_msg', 'Zone upload successfully!!');
		return redirect('developer/bulkupload/zone');

		// return back()->with('success', 'Zone & City imported successfully');
	}



}
