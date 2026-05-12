<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client;
use Validator; 
use DB;
use App\Models\Zone; 
use App\Models\Keyword;
use App\Models\Citieslists;
 
use App\Models\KeywordSellCount;
use App\Models\Client\AssignedKWDS;
class BusinessKeywordController extends Controller
{
	protected $danger_message = '';
	protected $success_message = '';
	protected $warning_message = '';
	protected $info_message = '';
	protected $redirectTo = '/business-owners';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function assignKeywordDelete(Request $request, $id)
	{
		if (!Auth::guard('sanctum')->check()) {
			return response()->json([
				'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

		$assignedKWDS = AssignedKWDS::findOrFail($id);
		if ($assignedKWDS->delete()) {
			$data['status'] = true;
			$data['message'] = "Assigned Keyword delete Successfully!";
		} else {
			$data['status'] =false;
			$data['message'] = "Assigned Keyword could not be Deleted!";
		}
		echo json_encode($data);	
		 
	}


	/**
	 * Return Paginated Assigned Keywords
	 *
	 * @param $request - Request class instance
	 * @param $id - ClientID
	 * @return JSON object containing payload
	 */
	public function getPaginatedAssignedKeywords(Request $request)
	{		 
		 	if (!Auth::guard('sanctum')->check()) {
			return response()->json([
				'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

			$clientID = auth()->guard('clients')->user()->id;
			$leads = DB::table('assigned_kwds')
			//	->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->select('assigned_kwds.*','parent_category.parent_category', 'child_category.child_category', 'keyword.keyword','keyword.slug')
				->orderBy('assigned_kwds.created_at', 'desc')
				->where('assigned_kwds.client_id', $clientID)
				->paginate($request->input('length'));

			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();

			foreach ($leads as $lead) {

				$action = '<a href="javascript:businessController.assignKeywordDelete(' . $lead->id . ')" title="Delete" class="btn btn-danger"><i class="bi bi-trash" aria-hidden="true"></i></a>';
				$zone = Zone::where('id', $lead->zone_id)->first();
				if (!empty($zone)) {
					$zonename = $zone->zone;
				} else {
					$zonename = "";

				}
				$data[] = [
					$lead->keyword,
					$lead->parent_category,
					$lead->child_category,
					// $lead->city,
					$action
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		
	}

	public function keywords(Request $request)
	{
		if (!Auth::guard('sanctum')->check()) {
			return response()->json([
				'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		$data['citylist'] = Citieslists::get();
		$data['keywordlist'] = Keyword::select('id', 'keyword', 'child_category_id', 'parent_category_id', 'city_id')->get();
		$data['clientID'] = $user->id;		 
		echo json_encode($data);	
	}

	public function saveKeywordAssign(Request $request, $id)
	{

		if (!Auth::guard('sanctum')->check()) {
		return response()->json([
			'status' => false,
				'message' => 'Unauthenticated: Token is missing or invalid',
				'error' => 'token_missing_or_invalid'
			], 401);
		}

		$user = auth('sanctum')->user();
		if (!$user) {
			return response()->json([
				'status' => false,
				'message' => 'Unauthenticated: Token is missing or invalid',
				'error' => 'token_missing_or_invalid'
			], 401);
		}
		$client = Client::withTrashed()->where('id', $user->id)->first();


			$validator = Validator::make($request->all(), [
				//'city' => 'required',
				//'keyword' => 'required',
			//	'zone_id' => 'required',
				'keyword' => 'required|unique:assigned_kwds,kw_id,NULL,id,client_id,' . $client->id . ',kw_id,' . $request->input('keyword'),

			 	

			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => true, 'errors' => $errorsBag], 400);
			}
		 


			
			$data = [];
			$keyw = Keyword::find($request->input('keyword'));

			if (!empty($keyw)) {

				$assignvalidation = AssignedKWDS::where('parent_cat_id', $keyw->parent_category_id)->where('child_cat_id', $keyw->child_category_id)->where('kw_id', $keyw->id)->where('client_id', $client->id)->get()->count();

				if ($assignvalidation == 0) {

					$assignedKWDS = new AssignedKWDS;
					$assignedKWDS->client_id = $client->id;
				//	$assignedKWDS->city_id = $request->input('city');
				//	$assignedKWDS->zone_id = $request->input('zone_id');
					$assignedKWDS->parent_cat_id = $keyw->parent_category_id;
					$assignedKWDS->child_cat_id = $keyw->child_category_id;
					$assignedKWDS->kw_id = $keyw->id;
					$assignedKWDS->sold_on_position = 'diamond';
					$keyword = Keyword::find($keyw->id);
					$keywordSellCount = KeywordSellCount::where('slug', 'diamond')->first();
					if (!empty($keywordSellCount)) {
						if ($keyword->category === 'Category 1') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat1_price;
						} else if ($keyword->category === 'Category 2') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat2_price;
						} else if ($keyword->category === 'Category 3') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat3_price;
						} elseif ($keyword->category === 'Category 4') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat4_price;
						} elseif ($keyword->category === 'Category 5') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat5_price;
						}elseif ($keyword->category === 'Category 6') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat6_price;
						}elseif ($keyword->category === 'Category 7') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat7_price;
						}elseif ($keyword->category === 'Category 8') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat8_price;
						}elseif ($keyword->category === 'Category 9') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat9_price;
						}elseif ($keyword->category === 'Category 10') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat10_price;
						} else {
							$assignedKWDS->sold_on_price = '220';
						}
					}

					if ($assignedKWDS->save()) {
						$keyword->diamond_pos_sold = $keyword->diamond_pos_sold + 1;
					}


					if ($keyword->save()) {
						$data['status'] = true;
						$data['message'] = "Keyword Assign add successfully !";
					} else {
						$data['status'] = false;
						$data['message'] = "Keyword Assign could not be successfully, Please try again !";
					}
				} else {
					$data['status'] = false;
					$data['message'] = "Already exist Keyword, Please try again !";
				}


			} else {
				$data['status'] = false;
				$data['message'] = "Keyword not found, Please try again !";
			}		 
		echo json_encode($data);	
	}
}
