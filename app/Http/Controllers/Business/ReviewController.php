<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
 

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use App\Models\Client\Comment;
use App\Models\Client\Client;
use App\Models\State;
use Illuminate\Support\Facades\Validator;
use DB;

class ReviewController extends Controller
{


	public function businessReview(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		$statesis = State::get();
		return view('business.business-review', ['search' => $search, 'client' => $client, 'statesis' => $statesis]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
 
		if ($request->ajax()) {

			$validator = Validator::make($request->all(), [
				'comment_author' => 'required|regex:/^[A-Za-z ]/',
				'comment_author_phone' => 'required|numeric',
				'comment_author_email' => 'required|email',
				'comment_content' => 'required',
				's_rating' => 'required|numeric|max:5|min:1',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => true, 'errors' => $errorsBag], 400);
			}
	 

		 
			$dd = DB::table('comments')
				->select(DB::raw("DATEDIFF(DATE(now()),(SELECT max(DATE(`created_at`)) FROM `comments` WHERE `comment_author_email`='" . $request->input('comment_author_email') . "' AND `comment_client_ID`=" . $request->currentClient . ")) as date"))
				->take(1)
				->get();

			if (!empty($dd)) {
				if ($dd[0]->date <= 30 && !is_null($dd[0]->date)) {			 
					return response()->json(["status" => false, "message" => "You cannot give review more than one in a month"],400);
				}
			}

			$comment = new Comment();
			$comment->comment_client_ID = $request->currentClient;
			$comment->comment_author = $request->input('comment_author');
			$comment->comment_author_phone = $request->input('comment_author_phone');
			$comment->comment_author_email = $request->input('comment_author_email');
			$comment->comment_content = $request->input('comment_content');
			$comment->rating = $request->input('s_rating');
			$comment->comment_author_IP = $request->ip();
			if ($comment->save()) {
				return response()->json(["status" => true, "message" => "Review successfully submitted."]);
			} else {
				return response()->json(["status" => 0, "message" => "Error occured."]);
			}
		}
		return response()->json(["status" => 0, "message" => "Client not found or invalid ajax request."]);
	}


 /**
	 * Return Paginated Assigned Keywords
	 *
	 * @param $request - Request class instance
	 * @param $id - ClientID
	 * @return JSON object containing payload
	 */
	 public function getBusinessReviewPagination(Request $request)
	 {
		 
		if ($request->ajax()) {
			$clientID = auth()->guard('clients')->user()->id;
			$leads = DB::table('comments');
			
			if ($request->input('search.value')!='') {

				$leads = $leads->where(function($query) use($request){
					$query->orWhere('comment_author','LIKE','%'.$request->input('search.value').'%')
						  ->orWhere('comment_author_email','LIKE','%'.$request->input('search.value').'%');						  
				});
			}
			$leads = $leads->orderBy('comment_ID','desc')
			->where('comment_client_ID',$clientID)
			->paginate($request->input('length'));
					   
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
	  		$returnLeads['recordCollection'] = [];
			foreach($leads as $lead){
			    
			  	$action = '';
				$separator = '';

				$action .= $separator . '<a href="javascript:reviewController.getReviewEdit(' . $lead->comment_ID . ')" title="Edit" class="btn btn-danger"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>';
				$separator = ' | ';
				
				
			    $action .= $separator . '<a href="javascript:reviewController.reviewDelete('.$lead->comment_ID.')" title="Delete" class="btn btn-danger"><i class="bi bi-trash" aria-hidden="true"></i></a>';	
					$separator = ' | ';
			
				if (!empty($lead->zone)) {
					$zonename= $lead->zone;
				} else {
					$zonename="";
					
				}
				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$lead->comment_ID'></th>",
					$lead->comment_author,
					$lead->comment_author_email,
					$lead->comment_author_phone,
					$lead->comment_content,				 
					$action,				 
				];
				$returnLeads['recordCollection'][] = $lead->comment_ID;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
			 
		}
	 }

	 /**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateReviewEdit(Request $request, $id)
	{
 
	 
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [

				'name' => 'required',
				'email' => 'required',
				'phone' => 'required',
				'remark' => 'required',

			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

		 
		$comments = Comment::where('comment_ID', $id)->first();
			// dd($comments);
			if (!empty($comments)) {			 
				$comments->comment_author = trim($request->input('name'));
				$comments->comment_author_email = trim($request->input('email'));
				$comments->comment_author_phone = trim($request->input('phone'));
				$comments->comment_content = htmlspecialchars(strip_tags(trim($request->input('remark'))));		 
			//  dd($comments);

			$comments->save();
				 
			return response()->json(['status' => 1], 200);
			}
			 
		}
	}



	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getReviewEdit(Request $request, $id)
	{

	// dd($id);
		if ($request->ajax()) {

		$comments = Comment::where('comment_ID',$id)->first();
 
			 

			$html = '<div class="row">
						<div class="x_content" style="padding:0">';
		 
			$html .= '<form class="form-label-left" method="post" onsubmit="return reviewController.saveEditReview(' . $id . ',this)">			 			  
								 
                <div class="row mb-3">
                
                <div class="col-md-4">
                <label for="" class="">Name :</label>
                <input type="text" name="name" class="form-control" value="' . $comments->comment_author . '" >
                
                </div>
                
				 <div class="col-md-4">
                <label for="" class="">Name :</label>
                <input type="text" name="email" class="form-control" value="' . $comments->comment_author_email . '" >
                
                </div>
                
				 <div class="col-md-4">
                <label for="" class="">Name :</label>
                <input type="text" name="phone" class="form-control" value="' . $comments->comment_author_phone . '" >
                
                </div>
                
                
                
                <div class="col-md-12">
                <label for="remark">Counsellor Remark <span class="required">*</span></label>
                <textarea name="remark" rows="4" class="form-control col-md-7 col-xs-12">'.$comments->comment_content.'</textarea>
                </div>
                </div>
                <div class="form-group" style="float:right;">
                <div class="col-md-11" style="float:right;">
                	<label style="visibility:hidden">Submit</label>
                	<button type="submit" class="btn btn-success btn-block" name="submit" value="Submit">Submit</button>
                </div>
                </div>
							</form>';

			$html .= '</div>
					</div>';

			return response()->json(['status' => 1, 'html' => $html], 200);
		}
	}
 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reviewDelete(Request $request, $id)
    { 

 
		$deleted = Comments::where('comment_ID', $id)->delete();
		// dd($comments);
		if (!empty($deleted)) {
		 			 
			 
				$status=true;							 
				$msg="Review Successfully!";	
		 
			
    	}else{
				$status=false;							 
				$msg="Review could not be Deleted!";

		}
			return response()->json(['status'=>$status,'msg'=>$msg],200); 

	}
	


}
