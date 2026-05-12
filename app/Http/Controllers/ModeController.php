<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Modesdetails; 
 
class ModeController extends Controller
{
    /**
     * Create a new controller instance.
     *	
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {	
        return view('admin.mode.index');
    } 

/**
	* add services
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {	 
		if($request->isMethod('post') && $request->input('submit')=="Save")
		{
			 
			  $this->validate($request, [
					'mode'=>'required|unique:modesdetails,mode|max:200', 
					 					
					]);  
					
					
					$modesdetails = new Modesdetails;					
					$modesdetails->mode = $request->input('mode');
					$modesdetails->slug = generate_slug($request->input('mode'));
								 
						
					if($modesdetails->save()){
						return redirect('/developer/mode/modedetails')->with('success','Mode Details successfully added!');
					}else{
						return redirect('/developer/mode/modedetails')->with('failed','Mode Details not added!');
						
					}
				 
			
		}
        return view('admin.mode.index');
    }
	
	
	/**
	* Edit services
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {  
	 
		$data['button'] = "Update";
	 
		$data['edit_data']= Modesdetails::find($id);
		 
		if($request->isMethod('post') && $request->input('submit')=="Update")
		{		 
				$this->validate($request, [
					'mode'=>'required|max:32|unique:modesdetails,mode,'.$id,
				 
					 					
					]); 
			 
					$modesdetails = Modesdetails::find($id);						
					$modesdetails->mode = ucfirst($request->input('mode'));
					$modesdetails->slug = generate_slug($request->input('mode'));			 		
					 	
					if($modesdetails->save()){
						return redirect('/developer/mode/modedetails')->with('success','Mode Details successfully Update!');
					}else{
						return redirect('/developer/mode/edit/'.$id)->with('failed','Modes details  not Update!');
						
					}
		}
        return view('admin.mode.index',$data);
    }
	
	
	
	/**
	* Edit services
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaginationMode(Request $request)
    {    
        if($request->ajax()){
			
			$modesdetails = Modesdetails::orderBy('id','desc');
			if($request->input('search.value')!=''){
				$modesdetails = $modesdetails->where(function($query) use($request){
				$query->orWhere('mode','LIKE','%'.$request->input('search.value').'%');
			 
				});
			}
			$modesdetails = $modesdetails->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $modesdetails->total();
			$recordCollection['recordsFiltered'] = $modesdetails->total();
	 
			foreach($modesdetails as $mode){	 
				 
				$data[] = [
					$mode->mode,
					$mode->slug,				  					
					'<a href="/developer/mode/edit/'.$mode->id.'"><i class="fa fa-edit" aria-hidden="true"></i></a> | <a href="/developer/mode/delete/'.$mode->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>'
				];
			}
			$recordCollection['data'] = $data;
			return response()->json($recordCollection);
			
			
		}
    }
	
	
	 
	
	public function deleted(Request $request,$id){
		 
			
			$modesdetails = Modesdetails::findorFail($id);
				if($modesdetails->delete()){				 
					 
					return redirect('/developer/mode/modedetails')->with('success','Mode successfully deleted!');
				}else{
					return redirect('/developer/mode/modedetails')->with('failed','Mode not deleted!');
				}
		 
	}
	
	
 
	 
	 
	
	
	
	
	
	
	 
}
