<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use DB;
use Excel;
use Auth;
use App\Models\City;
use App\Models\Citieslists;
use App\Models\ChildCategory;
use App\Models\ParentCategory;
use App\Models\Keyword;
use App\Models\SeoLog;
use App\Models\KeywordSellCount;
use App\Services\SeoLogService;
use App\Services\VersionsServices;


class KeywordController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';

	protected $seoLog;
	protected $versions;

	public function __construct(SeoLogService $seoLog, VersionsServices $versions)
	{
		$this->seoLog = $seoLog;
		$this->versions = $versions;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_keyword'))) {
			return view('errors.unauthorised');
		}


		$cities = Citieslists::all();
		$parentCategories = ParentCategory::all();
		$childCategories = ChildCategory::all();
		$keywords = Keyword::all();
		$keywordSellCounts = KeywordSellCount::where('status', '1')->where('slug', 'diamond')->first();

		$fCities = Citieslists::all();
		$fParentCategories = DB::table('keyword')
			->join('parent_category', 'parent_category.id', '=', 'keyword.parent_category_id')
			->select('parent_category.id', 'parent_category.parent_category')
			->distinct()
			->get();
		$fChildCategories = DB::table('keyword')
			->join('child_category', 'child_category.id', '=', 'keyword.child_category_id')
			->select('child_category.id', 'child_category.child_category')
			->distinct()
			->get();
		$fCategories = DB::table('keyword')
			->select('keyword.category')
			->distinct()
			->get();
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		return view('admin/keyword', [
			'cities' => $cities,
			'parent_categories' => $parentCategories,
			'childCategories' => $childCategories,
			'keywords' => $keywords,
			'fCities' => $fCities,
			'fParentCategories' => $fParentCategories,
			'fChildCategories' => $fChildCategories,
			'fCategories' => $fCategories,
			'search' => $search,
			'keywordSellCounts' => $keywordSellCounts
		]);
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('add_keyword'))) {
			return view('errors.unauthorised');
		}
		$validator = Validator::make($request->all(), [

			'keyword' => 'required|max:255|unique:keyword,keyword',
			'child_category_id' => 'required',
			'parent_category_id' => 'required'
		]);

		if ($validator->fails()) {
			return redirect("developer/keyword")
				->withErrors($validator)
				->withInput();
		}
		if ($request->input('category') == 'Category X') {
			$validator = Validator::make($request->all(), [
				'premium_price' => 'required|numeric',
				'platinum_price' => 'required|numeric',
				'royal_price' => 'required|numeric',
				'king_price' => 'required|numeric',
				'preferred_price' => 'required|numeric'
			]);
			if ($validator->fails()) {
				return redirect("developer/keyword")
					->withErrors($validator)
					->withInput();
			}
		}

		$keyword = new Keyword;
		$keyword->keyword = $request->input('keyword');
		$keyword->slug = generate_slug($request->input('keyword'));
		$keyword->parent_category_id = $request->input('parent_category_id');
		$keyword->child_category_id = $request->input('child_category_id');
		$keyword->category = $request->input('category');
		$keyword->premium_price = $request->input('premium_price') ? 0 : "";
		$keyword->platinum_price = $request->input('platinum_price') ? 0 : "";
		$keyword->royal_price = $request->input('royal_price') ? 0 : "";
		$keyword->king_price = $request->input('king_price') ? 0 : "";
		$keyword->preferred_price = $request->input('preferred_price') ? 0 : "";
		$keyword->ratingvalue = '4.5';
		$keyword->ratingcount = rand(000, 199);

		if ($keyword->isDirty()) {
			$originalValues = $keyword->getOriginal();
			$changes = [];
			foreach ($keyword->getDirty() as $field => $newValue) {

				$changes[$field] = json_encode([
					'old' => $originalValues[$field] ?? null,
					'new' => $newValue,
				]);
				$versionData['version'] = $keyword->id;
				$versionData['created_by'] = Auth::id();
				$versionData['table'] = "keyword";
				$versionData['attributes'] = $keyword->keyword;
				$versionData['description'] = json_encode($changes);
			}
			$this->seoLog->createSeoLog($versionData);
		}

		$keyword->save();
		$this->success_msg .= 'Keyword added succesfully!';
		$request->session()->flash('success_msg', $this->success_msg);
		return redirect("developer/keyword");
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{


		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_keyword'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {
			$keyword = Keyword::find($id);
			$child_category = $this->getChildCategoriesHelper($request, $keyword->parent_category_id);
			$request->session()->put('keywordToUpdate', $keyword->id);
			$keywordSellCounts = KeywordSellCount::where('status', '1')->get();
			return response()->json(['status' => 1, 'keyword' => $keyword, 'child_category' => $child_category, 'keyword_id' => $id, 'keywordSellCounts' => $keywordSellCounts]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function viewKW_Details(Request $request, $id)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {

			$kwDetails = DB::table('keyword')

				->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
				->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
				->select('keyword.*', 'parent_category.parent_category', 'child_category.child_category')
				->where('keyword.id', $id)
				->first();

			// BUCKET ALGORITHM
			// ****************
			$clientsList = DB::table('clients')

				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('zones', 'assigned_kwds.zone_id', '=', 'zones.id')
				->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
				->select('clients.*', 'citylists.*', 'zones.*', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword_sell_count.cat1_price', 'keyword_sell_count.cat2_price', 'keyword_sell_count.cat3_price', 'keyword.premium_price', 'keyword.platinum_price', 'keyword.king_price', 'keyword.royal_price', 'keyword.preferred_price', 'keyword.slug')
				->where('keyword.id', '=', $id)
				->whereNull('clients.deleted_at')
				->where('clients.leads_remaining', '>', '0')
				->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					")
				->get();


			// BUCKET CALCULATION
			// ******************
			$zonevals = [];
			if ($clientsList) {
				foreach ($clientsList as $clientszone) {
					array_push($zonevals, $clientszone->zone);

				}

			}

			$final_array = [];
			$temp_array = [];
			$zonebucketlist = array_count_values($zonevals);

			$k = 0;



			$max = $mCount = 5;
			$i = 0;
			$totalClients = count($clientsList);
			$buckets = [];
			$bucketsZone = [];
			foreach ($clientsList as $client) {
				if ($mCount == 0) {
					$j = $i;
					$buckets[++$j] = $buckets[$i++];
					$buckets[$j]['diamond'] = [];

					$bucketsZone[$i]['zone' . substr($client->city, 0, 1) . substr($client->zone, 0, 1)][] = [];

					$mCount = $max - (count($buckets[$j], 1) - 5);
					$mCount = $max - (count($bucketsZone[$j], 1) - 5);
				}
				/* if($client->sold_on_position=='platinum'){

					$buckets[$i]['platinum'][] = $client->id;
					//$bucketsZone[$i]['zone'][substr($client->city,0,1)][substr($client->zone,0,1)]['zone'][] = $client->id;
					$bucketsZone[$k]['zone'][] = $client->id;
				} */

				if ($client->sold_on_position == 'platinum') {

					$buckets[$i]['platinum'][] = $client->id;
					//$final_array[$key][$buckets]['zone'] = $client->id;
					//$bucketsZone[$i]['zone'][substr($client->city,0,1)][substr($client->zone,0,1)][] = $client->id;
					//$bucketsZone[$i]['zone'][] = $client->id;
					$bucketsZone[$i]['zone' . substr($client->city, 0, 1) . substr($client->zone, 0, 1)][] = $client->id;
					//$bucketsZone[$i]['zone'][] = $client->id;
					//$bucketsZone[$k]['zone'][] = $client->id;
				}
				if ($client->sold_on_position == 'diamond') {
					$buckets[$i]['diamond'][] = $client->id;
					//$final_array[$key][$buckets]['zone'] = $client->id;
					//$bucketsZone[$i]['zone'][substr($client->city,0,1)][substr($client->zone,0,1)][] = $client->id;
					//$bucketsZone[$i]['zone'][] = $client->id;
					$bucketsZone[$i]['zone' . substr($client->city, 0, 1) . substr($client->zone, 0, 1)][] = $client->id;
					//$bucketsZone[$i]['zone'][] = $client->id;
					//$bucketsZone[$i]['zone'.substr($client->city,0,1).substr($client->zone,0,1)][][] = $client->id;
					//$bucketsZone[$k]['zone'][] = $client->id;
				}

				--$mCount;
			}





			/// }
			// }
			//return $buckets;
			$searchBucketCityZone = [];
			if (!empty($clientsList)) {
				$searchBucketCityZone = "<a href='javascript:searchBucketCityZone($id)'>Bucket City Zone</a>";
			}
			$html = "";
			$i = 0;
			$bkts = [];
			foreach ($buckets as $bucket) {
				++$i;
				$bkts[] = "<a href='javascript:showBucket($id,$i)'>Bucket $i</a>";
			}
			$bkts = implode(', ', $bkts);
			// BUCKET CALCULATION
			// ******************

			return response()->json(['status' => 1, 'kwDetails' => $kwDetails, 'bkts' => $bkts, 'searchBucketCityZone' => $searchBucketCityZone]);
		}
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function showBucketViewCityZone(Request $request, $kwid, $cityid, $zoneid)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {

			$kwDetails = DB::table('keyword')
				//->join('citylists','keyword.city_id','=','citylists.id')
				->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
				->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
				->select('keyword.*', 'parent_category.parent_category', 'child_category.child_category')
				->where('keyword.id', $kwid)
				->first();

			// BUCKET ALGORITHM
			// ****************
			$clientsList = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('zones', 'assigned_kwds.zone_id', '=', 'zones.id')
				->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
				->select('clients.id as clientid', 'clients.username', 'clients.business_slug', 'clients.business_name', 'clients.client_type', 'citylists.id as cityid', 'citylists.city as cityname', 'zones.id as zoneid', 'zones.zone as zonename', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword.keyword', 'keyword.slug')
				->where('keyword.id', '=', $kwid)
				->where('citylists.id', '=', $cityid)
				->where('zones.id', '=', $zoneid)
				->whereNull('clients.deleted_at')
				->where('clients.leads_remaining', '>', '0')
				->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					")

				->get();
			$max = $mCount = 5;
			$i = 0;
			$totalClients = count($clientsList);
			$buckets = [];
			$bucketsZone = [];
			foreach ($clientsList as $client) {
				if ($mCount == 0) {
					$j = $i;
					$buckets[++$j] = $buckets[$i++];
					$buckets[$j]['diamond'] = [];

					$mCount = $max - (count($buckets[$j], 1) - 5);

				}

				if ($client->sold_on_position == 'platinum') {
					$buckets[$i]['platinum'][] = $client->clientid;
				}
				if ($client->sold_on_position == 'diamond') {
					$buckets[$i]['diamond'][] = $client->clientid;
				}

				--$mCount;
			}

			$html = "";
			$i = 0;
			$bkts = [];
			foreach ($buckets as $bucket) {
				++$i;
				$bkts[] = "<a href='javascript:showBucketcz($kwid,$cityid,$zoneid,$i)'>Bucket $i</a>";
			}
			$bkts = implode(', ', $bkts);

			$html = '<div id="assignkey-bucket-modal" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<form onsubmit="javascript:searchBucketCityZone()">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-fw fa-pencil-square-o"></i> Client Bucket</h4>
									</div>
									<div class="modal-body">
										<div class="container col-md-12">
										<div class="row">
										<table class="table table-bordered table-striped table-hover"><tr style="background:#337AB7;color:#FFF;"><th>Item</th><th>Value</th></tr>
										<tr><td>Buckets</td><td>' . $bkts . '</td></tr>					 
										</table>
									 
										</div>
										</div>
										<div class="clearfix"></div>
									</div>
									 
								</div>
							</form>
						</div>
					</div>';
			return response()->json(['status' => 1, 'kwDetails' => $kwDetails, 'bkts' => $html]);
		}
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editIcon(Request $request, $id)
	{
		$edit_data = Keyword::find($id);
		return view("admin.editIcon", ['edit_data' => $edit_data]);

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateIcon(Request $request, $id)
	{
		$keyword = Keyword::find($id);

		// if ($request->hasFile('icon')) {
		// 	$image = [];
		// 	$filePath = getFolderCourseStructure();
		// 	$file = $request->file('icon');
		// 	$filename = $file->getClientOriginalName();
		// 	$destinationPath = public_path($filePath);
		// 	$nameArr = explode('.', $filename);
		// 	$ext = array_pop($nameArr);
		// 	$name = implode('_', $nameArr);
		// 	if (file_exists($destinationPath . '/' . $filename)) {
		// 		$filename = $name . "_" . time() . '.' . $ext;
		// 	}
		// 	$file->move($destinationPath, $filename);

		// 	$image = array(
		// 		'name' => $filename,
		// 		'alt' => $filename,
		// 		'src' => $filePath . "/" . $filename
		// 	);
		// 	$keyword->icon = $image;
		// } else {

		// 	$keyword->icon = $keyword->icon;
		// }

		if ($request->hasFile('icon')) {
			$filePath = getFolderCourseStructure();
			$destinationPath = public_path($filePath);
			$filename = $this->saveImageSmart(
				$request->file('icon'),
				$destinationPath,
				150,
				150
			);

			$image = array(
				'name' => $filename,
				'alt' => $filename,
				'src' => $filePath . "/" . $filename
			);
			$keyword->icon = json_encode($image);
		} else {
			$keyword->icon = $keyword->icon;
		}


		if ($keyword->save()) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => "keyword updated successfully."
				]
			], 200);
		} else {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 400,
					"payload" => "",
					"message" => "keyword not updated."
				]
			], 200);
		}
	}

	public function deleteIcon($id)
	{
		$delet_data = Keyword::findOrFail($id);
		if ($delet_data->icon != '') {
			$image = json_decode($delet_data->icon);
			$thumbnail = $image->src;
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}
		$edit_data = array('icon' => "", );
		$del = Keyword::where('id', $id)->update($edit_data);
		return redirect('developer/keyword/editIcon/' . $id)->with("success", "Keyword Icons deleted successfully.");

	}



	private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
	{
		$ext = strtolower($file->getClientOriginalExtension());
		$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$name = str_replace(' ', '_', $name);
		$filename = time();

		// ✅ SVG → Save directly
		if ($ext === 'svg') {
			$finalName = $filename . '.svg';
			$file->move($destinationPath, $finalName);
			return $finalName;
		}

		// ✅ Raster → Convert to WEBP
		$imagePath = $file->getPathname();

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				$src = imagecreatefromjpeg($imagePath);
				break;
			case 'png':
				$src = imagecreatefrompng($imagePath);
				imagepalettetotruecolor($src);
				imagealphablending($src, true);
				imagesavealpha($src, true);
				break;
			case 'webp':
				$src = imagecreatefromwebp($imagePath);
				break;
			default:
				throw new \Exception('Unsupported image type');
		}

		$width = $width ?? imagesx($src);
		$height = $height ?? imagesy($src);

		$dst = imagecreatetruecolor($width, $height);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		imagecopyresampled(
			$dst,
			$src,
			0,
			0,
			0,
			0,
			$width,
			$height,
			imagesx($src),
			imagesy($src)
		);

		$finalName = $filename . '.webp';
		imagewebp($dst, $destinationPath . '/' . $finalName, 80);

		imagedestroy($src);
		imagedestroy($dst);

		return $finalName;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function showBucketcz(Request $request, $kwid, $cityid, $zoneid, $bucket_id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_keyword'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {
			$clientsList = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('zones', 'assigned_kwds.zone_id', '=', 'zones.id')
				->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
				->select('clients.id as clientid', 'clients.username', 'clients.business_slug', 'clients.business_name', 'clients.client_type', 'citylists.id as cityid', 'citylists.city as cityname', 'zones.id as zoneid', 'zones.zone as zonename', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword.keyword', 'keyword.slug')
				->where('keyword.id', '=', $kwid)
				->where('citylists.id', '=', $cityid)
				->where('zones.id', '=', $zoneid)
				->whereNull('clients.deleted_at')
				->where('clients.leads_remaining', '>', '0')
				->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					")
				->get();
			// BUCKET CALCULATION
			// ******************
			$max = $mCount = 5;
			$i = 0;
			$totalClients = count($clientsList);
			$buckets = [];
			foreach ($clientsList as $client) {
				if ($mCount == 0) {
					$j = $i;
					$buckets[++$j] = $buckets[$i++];
					$buckets[$j]['diamond'] = [];
					$mCount = $max - (count($buckets[$j], 1) - 5);
				}
				if ($client->sold_on_position == 'platinum') {
					$buckets[$i]['platinum'][] = $client;
				}
				if ($client->sold_on_position == 'diamond') {
					$buckets[$i]['diamond'][] = $client;
				}

				--$mCount;
			}

			$bucket_id = $bucket_id - 1;
			$modalBody = '
				
				<table class="table table-bordered table-striped table-hover"><tr style="background:#337AB7;color:#FFF;"><th>Client Name</th><th>Keyword Position</th><th>City</th></tr>';
			foreach ($buckets[$bucket_id] as $position => $clients) {
				foreach ($clients as $client) {
					$modalBody .= '<tr><td><a href="/developer/clients/update/' . $client->username . '">' . $client->business_name . '</a></td><td>' . $client->sold_on_position . '</td><td>' . $client->cityname . '</td></tr>';
				}
			}
			$modalBody .= '</table>';
			$html = '<div id="assignkey-bucket-modal-show" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<form onsubmit="javascript:searchBucketCityZone()">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-fw fa-pencil-square-o"></i> List of Bucket</h4>
									</div>
									<div class="modal-body">
										<div class="container col-md-12">
										<div class="row">
										<table class="table table-bordered table-striped table-hover"><tr style="background:#337AB7;color:#FFF;"></tr>
										<tr><td>Buckets</td><td>' . $modalBody . '</td></tr>					 
										</table>
									 
										</div>
										</div>
										<div class="clearfix"></div>
									</div>
									 
								</div>
							</form>
						</div>
					</div>';

			// BUCKET CALCULATION
			// ******************

			return response()->json(['status' => 1, 'message' => $html]);
		}
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function viewBucket_Details(Request $request, $kw_id, $bucket_id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_keyword'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {

			// BUCKET ALGORITHM
			// ****************
			$clientsList = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('zones', 'assigned_kwds.zone_id', '=', 'zones.id')
				->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
				->select('clients.*', 'citylists.*', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword_sell_count.cat1_price', 'keyword_sell_count.cat2_price', 'keyword_sell_count.cat3_price', 'keyword.premium_price', 'keyword.platinum_price', 'keyword.king_price', 'keyword.royal_price', 'keyword.preferred_price')
				->where('keyword.id', '=', $kw_id)
				->whereNull('clients.deleted_at')
				->where('clients.leads_remaining', '>', '0')
				->orderby(DB::raw('(CASE `assigned_kwds`.`sold_on_position` WHEN \'platinum\' THEN 1 WHEN \'diamond\' THEN 2 END)'), 'asc')
				//->orderby('comment_count','desc')
				//->tosql();
				->get();

			// BUCKET CALCULATION
			// ******************
			$max = $mCount = 5;
			$i = 0;
			$totalClients = count($clientsList);
			$buckets = [];
			foreach ($clientsList as $client) {
				if ($mCount == 0) {
					$j = $i;
					$buckets[++$j] = $buckets[$i++];
					$buckets[$j]['diamond'] = [];
					$mCount = $max - (count($buckets[$j], 1) - 5);
				}
				if ($client->sold_on_position == 'platinum') {
					$buckets[$i]['platinum'][] = $client;
				}
				if ($client->sold_on_position == 'diamond') {
					$buckets[$i]['diamond'][] = $client;
				}

				--$mCount;
			}

			$bucket_id = $bucket_id - 1;
			$modalBody = '<table class="table table-bordered table-striped table-hover"><tr style="background:#337AB7;color:#FFF;"><th>Client Name</th><th>Keyword Position</th><th>City</th></tr>';
			foreach ($buckets[$bucket_id] as $position => $clients) {
				foreach ($clients as $client) {
					$modalBody .= '<tr><td><a href="/developer/clients/update/' . $client->username . '">' . $client->business_name . '</a></td><td>' . $client->sold_on_position . '</td><td>' . $client->city . '</td></tr>';
				}
			}
			$modalBody .= '</table>';
			// BUCKET CALCULATION
			// ******************

			return response()->json(['status' => 1, 'modalBody' => $modalBody]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function bucketCityZone(Request $request, $kw_id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_keyword'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {
			// BUCKET ALGORITHM
			// ****************
			$clientsList = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('zones', 'assigned_kwds.zone_id', '=', 'zones.id')
				->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
				->select('clients.id as clientid', 'clients.username', 'clients.business_slug', 'clients.business_name', 'clients.client_type', 'citylists.id as cityid', 'citylists.city as cityname', 'zones.id as zoneid', 'zones.zone as zonename', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword.keyword', 'keyword.slug')
				->where('keyword.id', '=', $kw_id)
				->whereNull('clients.deleted_at')
				->where('clients.leads_remaining', '>', '0')
				->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					")
				->get();

			$cityvals = [];
			$cityname = [];
			if ($clientsList) {
				foreach ($clientsList as $clientscity) {
					array_push($cityvals, $clientscity->cityid);
					array_push($cityname, $clientscity->cityname);

				}
			}
			$cityclientvals = array_unique($cityvals);
			$cityclientname = array_unique($cityname);
			$cityclientvalname = array_combine($cityclientvals, $cityclientname);


			$cityHtml = '';
			if (!empty($cityclientvalname)) {
				foreach ($cityclientvalname as $keycity => $valcity) {
					$cityHtml .= '<option value="' . $keycity . '">' . $valcity . '</option>';
				}
			}

			$areaZoneOptionHtml = '';

			if (!empty($kw_id)) {
				$html = '
					<div id="assignkey-city-modal" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<form onsubmit="javascript:searchBucketCityZone()">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-fw fa-pencil-square-o"></i> Search Bucket</h4>
									</div>
									<div class="modal-body">
										<div class="container col-md-12">
											<div class="row">
												<div class="alert alert-danger" style="display:none;"></div>
												<div class="alert alert-success" style="display:none;"></div>
											 <input type="hidden" name="kw_id" id="asskwid" value="' . $kw_id . '">
												<div class="col-md-4">
													<div class="form-group">
														<label>Select City</label>
														<select class="form-control" name="assigncity_id" id="assigncity_id">
															<option value="">-- SELECT CITY --</option>
																' . $cityHtml . '
														</select>
													</div>
												</div>											 
												<div class="col-md-4">
													<div class="form-group">
														<label>Find Area</label>
														<select name="assignarea_zone" id="assignarea_zone" class="form-control" tabindex="-1" aria-hidden="true">
																<option value="">-- Select Zone--</option>
														</select>
													</div>
												</div>
												
												<div class="col-md-4">
													<div class="form-group">
													<lebel></label>
														<label><a href="javascript:showBucketViewCityZone(' . $kw_id . ')">Search</a></label>
														 
													</div>
												</div>
											 
												 
											 
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									 
								</div>
							</form>
						</div>
					</div>
				';

			}

			return response()->json(['status' => 1, 'message' => $html]);
		}
	}

	/**
	 * Return the zones(id,name) associated to the specified city id.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return JSON Payload
	 */
	public function assigingetzones(Request $request, $city_id, $kwid)
	{
		$id = $city_id;
		$clientsList = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->join('zones', 'assigned_kwds.zone_id', '=', 'zones.id')
			->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
			->select('clients.id as clientid', 'clients.username', 'clients.business_slug', 'clients.business_name', 'clients.client_type', 'citylists.id as cityid', 'citylists.city as cityname', 'zones.id as zoneid', 'zones.zone as zonename', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword.keyword', 'keyword.slug')
			->where('keyword.id', '=', $kwid)
			->where('citylists.id', '=', $city_id)
			->whereNull('clients.deleted_at')
			->where('clients.leads_remaining', '>', '0')
			->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					")

			->get();


		$zonevals = [];
		$zonename = [];
		if ($clientsList) {
			foreach ($clientsList as $clientszone) {
				array_push($zonevals, $clientszone->zoneid);
				array_push($zonename, $clientszone->zonename);
			}
		}
		$zoneclientvals = array_unique($zonevals);
		$zoneclientname = array_unique($zonename);
		$zoneclientvalname = array_combine($zoneclientvals, $zoneclientname);


		$zoneHtml = '';
		if (!empty($zoneclientvalname)) {
			foreach ($zoneclientvalname as $keyzone => $valzone) {
				$zoneHtml .= '<option value="' . $keyzone . '">' . $valzone . '</option>';
			}
		}


		if ($zoneHtml) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => $zoneHtml,
					"message" => "Populated the zone dropdown successfully !!"
				]
			], 200);
		} else {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Zones not found associated to the selected city !!"
				]
			], 200);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getCityKWList(Request $request)
	{
		$citiesList = DB::table('assigned_kwds')
			->join('cities', 'assigned_kwds.city_id', '=', 'cities.id')
			->select('cities.city')
			->distinct()
			->get();

		return response()->json(['status' => 1, 'message' => $citiesList]);
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
		$keywordToUpdate = $request->session()->get('keywordToUpdate');

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_keyword'))) {
			return view('errors.unauthorised');
		}
		if ($request->session()->has('keywordToUpdate')) {

			$validator = Validator::make($request->all(), [
				'keyword' => 'required|max:255|unique:keyword,keyword,' . $request->input('id'),
				'parent_category_id' => 'required',
				'child_category_id' => 'required',


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



			if ($request->input('category') == 'Category X') {
				$validator = Validator::make($request->all(), [
					'premium_price' => 'required|numeric',
					'platinum_price' => 'required|numeric',
					'royal_price' => 'required|numeric',
					'king_price' => 'required|numeric',
					'preferred_price' => 'required|numeric'


				]);
				if ($validator->fails()) {
					return redirect("developer/keyword")
						->withErrors($validator)
						->withInput();
				}
			}

			$keywordToUpdate = $request->session()->get('keywordToUpdate');
			if ($keywordToUpdate == $request->input('id')) {
				$keyword = Keyword::find($keywordToUpdate);
				$keyword->keyword = $request->input('keyword');
				$keyword->slug = generate_slug($request->input('keyword'));
				$keyword->parent_category_id = $request->input('parent_category_id');
				$keyword->child_category_id = $request->input('child_category_id');
				$keyword->category = $request->input('category');
				if ($request->input('category') != 'Category X') {
					$keyword->premium_price = $keyword->platinum_price = $keyword->royal_price = $keyword->king_price = $keyword->preferred_price = 0;
				} else {
					$keyword->premium_price = $request->input('premium_price');
					$keyword->platinum_price = $request->input('platinum_price');
					$keyword->royal_price = $request->input('royal_price');
					$keyword->king_price = $request->input('king_price');
					$keyword->preferred_price = $request->input('preferred_price');
				}

				// if ($request->hasFile('icon')) {
				// 	$image = [];
				// 	$filePath = getFolderCourseStructure();
				// 	$file = $request->file('icon');
				// 	$filename = $file->getClientOriginalName();
				// 	$destinationPath = public_path($filePath);
				// 	$nameArr = explode('.', $filename);
				// 	$ext = array_pop($nameArr);
				// 	$name = implode('_', $nameArr);
				// 	if (file_exists($destinationPath . '/' . $filename)) {
				// 		$filename = $name . "_" . time() . '.' . $ext;
				// 	}
				// 	$file->move($destinationPath, $filename);

				// 	$image = array(
				// 		'name' => $filename,
				// 		'alt' => $filename,
				// 		'src' => $filePath . "/" . $filename
				// 	);
				// 	$keyword->icon = $image;
				// } else {
				// 	$keyword->icon = $keyword->icon;
				// }


				if ($request->hasFile('icon')) {
					$filePath = getFolderCourseStructure();
					$destinationPath = public_path($filePath);
					$filename = $this->saveImageSmart(
						$request->file('icon'),
						$destinationPath,
						150,
						150
					);

					$image = array(
						'name' => $filename,
						'alt' => $filename,
						'src' => $filePath . "/" . $filename
					);
					$keyword->icon = json_encode($image);
				} else {
					$keyword->icon = $keyword->icon;
				}

				if ($keyword->isDirty()) {
					$originalValues = $keyword->getOriginal();
					$changes = [];
					foreach ($keyword->getDirty() as $field => $newValue) {
						$changes[$field] = json_encode([
							'old' => $originalValues[$field] ?? null,
							'new' => $newValue,
						]);

						$versionData['version'] = $keyword->id;
						$versionData['updated_by'] = Auth::id();
						$versionData['table'] = "keyword";
						$versionData['attributes'] = $keyword->keyword;
						$versionData['description'] = json_encode($changes);
					}
					$this->seoLog->createSeoLog($versionData);
				}



				if ($keyword->save()) {
					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "keyword updated successfully."
						]
					], 200);
				} else {
					return response()->json([
						"statusCode" => 0,
						"data" => [
							"responseCode" => 400,
							"payload" => "",
							"message" => "keyword not updated."
						]
					], 200);
				}

			}
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
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_keyword'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {

			Keyword::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'Keyword deleted succesfully!!']);
		}
	}

	/**
	 * Send the child categories in response related to the requested id.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getChildCategories(Request $request, $id)
	{
		//
		$child_category = ChildCategory::where('parent_category_id', $id)->get();
		if ($request->ajax()) {
			return response()->json(['status' => 1, 'child_category' => $child_category]);
		} else {
			return $child_category;
		}
	}

	public function getChildCategoriesHelper($request, $id)
	{
		$child_category = ChildCategory::where('parent_category_id', $id)->get();
		return $child_category;
	}

	/**
	 * Get paginated kwds.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedKwds(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_keyword'))) {
			return view('errors.unauthorised');
		}

		if ($request->ajax()) {

			$cities = Citieslists::all();
			$parentCategories = ParentCategory::all();
			$childCategories = ChildCategory::all();

			$leads = DB::table('keyword');
			$leads = $leads->select('keyword.*');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('keyword.keyword', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('keyword.slug', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}

			if ($request->input('search.pc') != '') {
				$leads = $leads->where('keyword.parent_category_id', '=', $request->input('search.pc'));
			}
			if ($request->input('search.cc') != '') {
				$leads = $leads->where('keyword.child_category_id', '=', $request->input('search.cc'));
			}
			if ($request->input('search.cat') != '') {
				$leads = $leads->where('keyword.category', 'LIKE', '%' . $request->input('search.cat') . '%');
			}
			$leads = $leads->orderBy('keyword.id', 'desc');
			$leads = $leads->paginate($request->input('length'));

			$cityArr = $parentCatArr = $childCatArr = $keywordArr = [];
			foreach ($cities as $city) {
				$cityArr[$city->id] = $city->city;
			}
			foreach ($parentCategories as $parentCategory) {
				$parentCatArr[$parentCategory->id] = $parentCategory->parent_category;
			}
			foreach ($childCategories as $childCategory) {
				$childCatArr[$childCategory->id] = $childCategory->child_category;
			}
			foreach ($leads as $keyword) {
				$keywordArr[$keyword->id] = $keyword->keyword;
			}

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			foreach ($leads as $lead) {

				$action = '';
				$separator = '';
				if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_keyword')) {
					$action .= $separator . '<a href="/developer/keyword/editIcon/' . $lead->id . '"   title="Edit Icons"><i class="fa fa-picture-o" aria-hidden="true"></i></a> | <a href="javascript:void(0)" onclick="javascript:updateKeyword(' . $lead->id . ',this)" title="Edit Keyword"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></a> | <a href="javascript:void(0)" onclick="javascript:deleteKeyword(' . $lead->id . ',this,\'view_kw\')" title="View Keyword"><i class="fa fa-eye fa-fw" aria-hidden="true"></i></a>';
				}
				if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_keyword')) {

					$action .= $separator . '  |	 <a href="javascript:void(0)" onclick="javascript:deleteKeyword(' . $lead->id . ',this,\'del_kw\')" title="Delete Keyword"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>';
				}

				if (!empty($lead->icon)) {
					$vicons = json_decode($lead->icon, true);

					$icons = '<img loading="lazy" src="' . asset('public/' . $vicons['src']) . '" width="70px">';
				} else {
					$icons = "";
				}
				if ($lead->seo_type == '1') {
					$seo = '<a href="javascript:keywordController.seoStatus(' . $lead->id . ',0)" title="SEO status" class="btn btn-success">Yes</a>';
				} else {
					$seo = '<a href="javascript:keywordController.seoStatus(' . $lead->id . ',1)" title="SEO status" class="btn btn-danger">No</a>';
				}

				$data[] = [
					$seo,
					$lead->keyword,
					isset($childCatArr[$lead->child_category_id]) ? $childCatArr[$lead->child_category_id] : "",
					isset($parentCatArr[$lead->parent_category_id]) ? $parentCatArr[$lead->parent_category_id] : "",
					$lead->category,
					$icons,
					$action,
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}

	/**
	 * Get paginated kwds export.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getKwdsExcel(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('export_keyword'))) {
			return view('errors.unauthorised');
		}
		$cities = Citieslists::all();
		$parentCategories = ParentCategory::all();
		$childCategories = ChildCategory::all();
		$leads = DB::table('keyword');
		$leads = $leads->select('keyword.*');
		if ($request->input('search.value') != '') {
			$leads = $leads->where(function ($query) use ($request) {
				$query->orWhere('keyword.keyword', 'LIKE', '%' . $request->input('search.value') . '%');
			});
		}
		if ($request->input('search.city') != '') {
			$leads = $leads->where('keyword.city_id', '=', $request->input('search.city'));
		}
		if ($request->input('search.pc') != '') {
			$leads = $leads->where('keyword.parent_category_id', '=', $request->input('search.pc'));
		}
		if ($request->input('search.cc') != '') {
			$leads = $leads->where('keyword.child_category_id', '=', $request->input('search.cc'));
		}
		if ($request->input('search.cat') != '') {
			$leads = $leads->where('keyword.category', 'LIKE', '%' . $request->input('search.cat') . '%');
		}
		$leads = $leads->orderBy('keyword.id', 'desc');
		$leads = $leads->get();

		$cityArr = $parentCatArr = $childCatArr = $keywordArr = [];
		foreach ($cities as $city) {
			$cityArr[$city->id] = $city->city;
		}
		foreach ($parentCategories as $parentCategory) {
			$parentCatArr[$parentCategory->id] = $parentCategory->parent_category;
		}
		foreach ($childCategories as $childCategory) {
			$childCatArr[$childCategory->id] = $childCategory->child_category;
		}
		foreach ($leads as $keyword) {
			$keywordArr[$keyword->id] = $keyword->keyword;
		}

		$returnLeads = [];
		$arr = [];
		foreach ($leads as $lead) {
			$arr[] = [
				"Keyword" => $lead->keyword,
				"City" => empty($lead->city_id) ? "" : (isset($cityArr[$lead->city_id]) ? $cityArr[$lead->city_id] : ""),
				"Child Category" => isset($childCatArr[$lead->child_category_id]) ? $childCatArr[$lead->child_category_id] : "",
				"Parent Category" => isset($parentCatArr[$lead->parent_category_id]) ? $parentCatArr[$lead->parent_category_id] : "",
				"Category" => $lead->category
			];
		}
		$excel = \App::make('excel');
		Excel::create('keyword_' . date('Y-m-d_H:i'), function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');

	}

	/**
	 * Display a listing of the distinct keywords for SEO.
	 *
	 * @return json object based on pagination
	 * @param null
	 */
	public function indexSEO(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO'))) {
			return view('errors.unauthorised');
		}


		if ($request->ajax()) {
			$leads = DB::table('keyword as k');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('k.keyword', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('k.slug', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('k.meta_description', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('k.top_description', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('k.courseabout', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('k.bottom_description', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$leads = $leads->select('k.keyword', 'k.id', 'k.meta_title', 'k.meta_keywords', 'k.meta_description', 'k.top_description', 'k.bottom_description');
			$leads = $leads->distinct();
			$leads = $leads->orderBy('k.id', 'desc');
			$leads = $leads->paginate($request->input('length'), ['k.keyword']);

			if ($leads) {
				$returnLeads = $data = [];
				$returnLeads['draw'] = $request->input('draw');
				$returnLeads['recordsTotal'] = $leads->total();
				$returnLeads['recordsFiltered'] = $leads->total();

				foreach ($leads as $lead) {
					$totalCount = Keyword::where('keyword', 'LIKE', $lead->keyword)->count();
					$greenCount = Keyword::where('keyword', 'LIKE', $lead->keyword)->whereNotNull('meta_title')->whereNotNull('meta_description')->whereNotNull('meta_keywords')->count();
					//whereNotNull('top_description')->whereNotNull('bottom_description')->count();
					$redCount = $totalCount - $greenCount;


					$data[] = [

						$lead->keyword,
						$lead->meta_title,
						$lead->meta_keywords,
						$lead->meta_description,
						"<a href='/developer/seo/$lead->id' class='btn btn-danger btn-xs'><i class='fa fa-fw fa-pencil' aria-hidden='true'></i>Edit</a>",
						"<small style='color:green'>$greenCount</small>+<small style='color:red'>$redCount</small>=<small style='color:black'>$totalCount</small>"
					];
				}
				$returnLeads['data'] = $data;
				return response()->json($returnLeads);
			}
		} else {
			return view('admin.seo.read_seo');
		}
	}

	/**
	 * Display a listing of the distinct keywords for SEO.
	 *
	 * @return json object based on pagination
	 * @param null
	 */
	public function seoReport(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO'))) {
			return view('errors.unauthorised');
		}

		if ($request->ajax()) {


			$leads = DB::table('seo_logs as log');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('log.attributes', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}

			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('log.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}
			if ($request->input('search.datet') != '') {
				$leads = $leads->whereDate('log.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
			}

			if ($request->input('search.user') != '') {
				$leads = $leads->where('log.created_by', 'LIKE', $request->input('search.user'));
				$leads = $leads->orWhere('log.updated_by', 'LIKE', $request->input('search.user'));
			}
			$leads = $leads->select('log.*');
			$leads = $leads->distinct();
			$leads = $leads->orderBy('log.id', 'desc');
			$leads = $leads->paginate($request->input('length'), ['k.keyword']);

			if ($leads) {
				$returnLeads = $data = [];
				$returnLeads['draw'] = $request->input('draw');
				$returnLeads['recordsTotal'] = $leads->total();
				$returnLeads['recordsFiltered'] = $leads->total();
				$users = DB::table('users')->select('users.id', 'users.first_name', 'users.last_name')->get();
				if ($users) {
					foreach ($users as $user) {
						$owner[$user->id] = $user->first_name . " " . $user->last_name;
					}
				}
				foreach ($leads as $lead) {

					$owner_name = '';
					if ($lead->created_by != null && isset($owner[$lead->created_by])) {
						$owner_name = $owner[$lead->created_by];

					} else if ($lead->updated_by != null && isset($owner[$lead->updated_by])) {
						$owner_name = $owner[$lead->updated_by];
					}

					if ($lead->description != null && isset($lead->description)) {
						$descriptions = json_decode($lead->description);

						$keyhtml = '';
						foreach ($descriptions as $description) {
							$keywords = json_decode($description);
							if ($keywords->new) {
								$keyhtml .= '<li> Old:' . $keywords->old . '</li>';
								$keyhtml .= '<li> New:' . $keywords->new . '</li>';
							}

						}
						$keyhtml .= '';
						$htmlreport = '<ul class="assign-elements">
					<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="btn btn-success btn-xs">	</span>		 
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
					' . $keyhtml . ' 
					</ul>
					</li>
					</ul>';
					}


					$htmlreport = '<a data-lead_id_follow="' . $lead->id . '" href="javascript:keywordController.seoReportPopup(' . $lead->id . ')"  title="Seo Report"><i class="fa fa-fw fa-eye"></i></a>';

					$data[] = [
						$lead->version,
						$lead->table,
						$lead->attributes,
						$htmlreport,
						$owner_name,
						(date('Y-m-d', strtotime($lead->created_at))),
					];
				}
				$returnLeads['data'] = $data;
				return response()->json($returnLeads);
			}
		} else {
			$search = [];
			if ($request->has('search')) {
				$search = $request->input('search');
			}
			return view('admin.seo.seoReport', ['search' => $search]);
		}
	}


	public function seoReportPopup(Request $request, $id = null)
	{

		$lead = SeoLog::findOrFail($id);
		if ($lead) {

			$statusHtml = '';
			$disabled = '';
			$dateValue = '';

			$keyhtml = '';
			if ($lead->description != null && isset($lead->description)) {

				// Decode the description JSON
				$descriptions = json_decode($lead->description, true); // Use associative array for easier handling
				if (is_array($descriptions)) {
					foreach ($descriptions as $key => $description) {

						$keywords = is_string($description) ? json_decode($description, true) : $description;


						if (is_array($keywords) && (!empty($keywords['new']))) {

							$keyhtml .= '<tr>';
							$keyhtml .= '<td>' . htmlspecialchars($key) . '</td>';
							$keyhtml .= '<td>' . htmlspecialchars($keywords['old'] ?? 'N/A') . '</td>';
							$keyhtml .= '<td>' . htmlspecialchars($keywords['new'] ?? 'N/A') . '</td>';
							$keyhtml .= '</tr>';
						}
					}
				}

			}

			$html = '<div class="row">
						<div class="x_content" style="padding:0">';
			$html .= '</div>
					</div> 
					<div class="table-responsive" style="overflow-x: hidden;">
					<p style="margin-top:10px;margin-bottom:3px;"><strong>Tele Coller Follow Up</strong>  <select onchange="javascript:pushLeadController.getAllFollowUps()" class="follow-up-count"><option value="5">Last 5</option><option value="all">All</option></select></p>
						<table id="datatable-seo-report-popup" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Key</th>
									<th>Old</th>
									<th>New</th>									 
								</tr>
							</thead>
						<tbody>
						' . $keyhtml . '
						<tbody>
						</table>
						 </div> ';



			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => $html,
					'message' => 'get leads'
				]
			], 200);
		} else {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Leads not found'
				]
			], 200);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $keyword
	 */
	public function editSEO(Request $request, $keyword)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return view('errors.unauthorised');
		}
		if (empty($keyword) || is_null($keyword)) {
			$this->danger_msg .= 'Keyword cannot be null or blank.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/seo");
		}
		$keywordObj = Keyword::where('id', $keyword)->first();
		if ($keywordObj) {
			return view('admin.seo.update_seo', ['keyword' => $keywordObj]);
		} else {
			$this->danger_msg .= 'Keyword not found.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/seo");
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $keyword
	 * @return \Illuminate\Http\Response
	 */
	public function updateSEO(Request $request, $keyword)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return view('errors.unauthorised');
		}

		if (empty($keyword) || is_null($keyword)) {
			$this->danger_msg .= 'Keyword cannot be null or blank.';
			$request->session()->flash('danger_msg', $this->danger_msg);

		}
		$keywords = Keyword::where('id', $keyword)->get();
		if ($keywords) {
			$i = 0;
			foreach ($keywords as $kw) {
				$kwObj = Keyword::findOrFail($kw->id);
				$meta_title = $meta_description = $meta_keywords = $top_description = $bottom_description = NULL;

				if ($request->has('meta_title') && $request->input('meta_title') != '') {
					$meta_title = $request->input('meta_title');

				}
				if ($request->has('meta_description') && $request->input('meta_description') != '') {
					$meta_description = $request->input('meta_description');
					$meta_description = preg_replace('/{{keyword}}/i', $kw->keyword, $meta_description);

				}
				if ($request->has('meta_keywords') && $request->input('meta_keywords') != '') {
					$meta_keywords = $request->input('meta_keywords');
					$meta_keywords = preg_replace('/{{keyword}}/i', $kw->keyword, $meta_keywords);

				}
				if ($request->has('top_description') && $request->input('top_description') != '') {
					$top_description = $request->input('top_description');
					$top_description = preg_replace('/{{keyword}}/i', $kw->keyword, $top_description);

				}
				if ($request->has('bottom_description') && $request->input('bottom_description') != '') {
					$bottom_description = $request->input('bottom_description');
					$bottom_description = preg_replace('/{{keyword}}/i', $kw->keyword, $bottom_description);

				}

				$kwObj->meta_title = $meta_title;
				$kwObj->meta_description = $meta_description;
				$kwObj->meta_keywords = $meta_keywords;
				$kwObj->top_description = $top_description;

				$kwObj->faqq1 = $request->input('faqq1');
				$kwObj->faqa1 = $request->input('faqa1');
				$kwObj->faqq2 = $request->input('faqq2');
				$kwObj->faqa2 = $request->input('faqa2');
				$kwObj->faqq3 = $request->input('faqq3');
				$kwObj->faqa3 = $request->input('faqa3');
				$kwObj->faqq4 = $request->input('faqq4');
				$kwObj->faqa4 = $request->input('faqa4');
				$kwObj->faqq5 = $request->input('faqq5');
				$kwObj->faqa5 = $request->input('faqa5');
				$kwObj->faqq6 = $request->input('faqq6');
				$kwObj->faqa6 = $request->input('faqa6');
				$kwObj->bottom_description = $bottom_description;
				$kwObj->ratingvalue = $request->input('ratingvalue');
				$kwObj->ratingcount = $request->input('ratingcount');

				if ($kwObj->isDirty()) {
					$originalValues = $kwObj->getOriginal();
					$changes = [];
					foreach ($kwObj->getDirty() as $field => $newValue) {
						$changes[$field] = json_encode([
							'old' => $originalValues[$field] ?? null,
							'new' => $newValue,
						]);

						$versionData['version'] = $kwObj->id;
						$versionData['updated_by'] = Auth::id();
						$versionData['table'] = "keyword";
						$versionData['attributes'] = $kwObj->keyword;
						$versionData['description'] = json_encode($changes);
					}
					$this->seoLog->createSeoLog($versionData);
				}

				if ($kwObj->save()) {
					++$i;
				}
			}
			if ($i) {
				$this->success_msg .= "Keyword seo fields added successfully... Updated {$i} records.";
				$request->session()->flash('success_msg', $this->success_msg);
				return redirect("developer/seo/");
			} else {
				$this->danger_msg .= 'Keyword seo fields not added successfully.';
				$request->session()->flash('danger_msg', $this->danger_msg);
				return redirect("developer/seo");
			}
		} else {
			$this->danger_msg .= 'Keyword not found.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/seo");
		}
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateMetaInformation(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return response()->json(['status' => 1, 'errors' => 'errors unauthorised'], 400);
		}

		if (empty($id) || is_null($id)) {
			$danger_msg = 'Keyword cannot be null or blank.';
			return response()->json(['status' => 1, 'errors' => $danger_msg], 400);
		}
		$validator = Validator::make($request->all(), [
			'meta_title' => 'required|min:3|max:75',
			'meta_keywords' => 'required|min:10|max:260',
			'meta_description' => 'required|min:45|max:300',
			'ratingvalue' => 'required|numeric',
			'ratingcount' => 'required|numeric',
		]);

		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}


		$i = 0;

		$kwObj = Keyword::findOrFail($id);

		if ($kwObj) {
			$kwObj->meta_title = $request->input('meta_title');
			$kwObj->meta_description = $request->input('meta_description');
			$kwObj->meta_keywords = $request->input('meta_keywords');
			$kwObj->ratingvalue = $request->input('ratingvalue');
			$kwObj->ratingcount = $request->input('ratingcount');


			if ($kwObj->isDirty()) {
				$originalValues = $kwObj->getOriginal();
				$changes = [];
				foreach ($kwObj->getDirty() as $field => $newValue) {
					$changes[$field] = json_encode([
						'old' => $originalValues[$field] ?? null,
						'new' => $newValue,
					]);

					$versionData['version'] = $kwObj->id;
					$versionData['updated_by'] = Auth::id();
					$versionData['table'] = "keyword";
					$versionData['attributes'] = $kwObj->keyword;
					$versionData['description'] = json_encode($changes);
				}
				$this->seoLog->createSeoLog($versionData);
			}
		}

		if (!empty($kwObj->save())) {
			$status = 1;
			$msg = "Meta Update submitted successfully!";

		} else {
			$status = 0;
			$msg = "Meta Update could not be submitted!";
		}

		return response()->json(['status' => $status, 'msg' => $msg], 200);

	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateAboutKeyword(Request $request, $id)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return response()->json(['status' => 1, 'errors' => 'errors unauthorised'], 400);
		}

		if (empty($id) || is_null($id)) {
			$danger_msg = 'Keyword cannot be null or blank.';
			return response()->json(['status' => 1, 'errors' => $danger_msg], 400);
		}
		$validator = Validator::make($request->all(), [
			'heading' => 'required|min:3|max:275',
			'paragraph1' => 'required|min:10|max:160',
			'courseabout' => 'required|min:45',
			'paragraph2' => 'required',
			'paragraph3' => 'required',

		]);

		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}


		$i = 0;

		$kwObj = Keyword::findOrFail($id);

		if ($kwObj) {
			$kwObj->heading = $request->input('heading');
			$kwObj->paragraph1 = $request->input('paragraph1');
			$kwObj->courseabout = $request->input('courseabout');
			$kwObj->paragraph2 = $request->input('paragraph2');
			$kwObj->paragraph3 = $request->input('paragraph3');
			$kwObj->paragraph4 = $request->input('paragraph4');
			$kwObj->paragraph5 = $request->input('paragraph5');
			$kwObj->paragraph6 = $request->input('paragraph6');


			if ($kwObj->isDirty()) {
				$originalValues = $kwObj->getOriginal();
				$changes = [];
				foreach ($kwObj->getDirty() as $field => $newValue) {
					$changes[$field] = json_encode([
						'old' => $originalValues[$field] ?? null,
						'new' => $newValue,
					]);

					$versionData['version'] = $kwObj->id;
					$versionData['updated_by'] = Auth::id();
					$versionData['table'] = "keyword";
					$versionData['attributes'] = $kwObj->keyword;
					$versionData['description'] = json_encode($changes);
				}
				$this->seoLog->createSeoLog($versionData);
			}
		}

		if (!empty($kwObj->save())) {
			$status = 1;
			$msg = "Keyword Update submitted successfully!";

		} else {
			$status = 0;
			$msg = "Keyword Update could not be submitted!";
		}

		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updatePageContent(Request $request, $id)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return response()->json(['status' => 1, 'errors' => 'errors unauthorised'], 400);
		}

		if (empty($id) || is_null($id)) {
			$danger_msg = 'Keyword cannot be null or blank.';
			return response()->json(['status' => 1, 'errors' => $danger_msg], 400);
		}
		$validator = Validator::make($request->all(), [
			'top_description' => 'nullable',
			'bottom_description' => 'nullable',


		]);

		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}
		$kwObj = Keyword::findOrFail($id);

		if ($kwObj) {
			$kwObj->top_description = $request->input('top_description');
			$kwObj->bottom_description = $request->input('bottom_description');


			if ($kwObj->isDirty()) {
				$originalValues = $kwObj->getOriginal();
				$changes = [];
				foreach ($kwObj->getDirty() as $field => $newValue) {
					$changes[$field] = json_encode([
						'old' => $originalValues[$field] ?? null,
						'new' => $newValue,
					]);

					$versionData['version'] = $kwObj->id;
					$versionData['updated_by'] = Auth::id();
					$versionData['table'] = "keyword";
					$versionData['attributes'] = $kwObj->keyword;
					$versionData['description'] = json_encode($changes);
				}
				$this->seoLog->createSeoLog($versionData);
			}
		}

		if (!empty($kwObj->save())) {
			$status = 1;
			$msg = "Content Update submitted successfully!";

		} else {
			$status = 0;
			$msg = "Content Update could not be submitted!";
		}

		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateFaqKeyword(Request $request, $id)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return response()->json(['status' => 1, 'errors' => 'errors unauthorised'], 400);
		}

		if (empty($id) || is_null($id)) {
			$danger_msg = 'Keyword cannot be null or blank.';
			return response()->json(['status' => 1, 'errors' => $danger_msg], 400);
		}
		$validator = Validator::make($request->all(), [
			'faqq1' => 'required',
			'faqa1' => 'required',
			'faqq2' => 'required',
			'faqa2' => 'required',
			'faqq3' => 'required',
			'faqa3' => 'required',


		]);

		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}
		$kwObj = Keyword::findOrFail($id);

		if ($kwObj) {

			$kwObj->faqq1 = $request->input('faqq1');
			$kwObj->faqa1 = $request->input('faqa1');
			$kwObj->faqq2 = $request->input('faqq2');
			$kwObj->faqa2 = $request->input('faqa2');
			$kwObj->faqq3 = $request->input('faqq3');
			$kwObj->faqa3 = $request->input('faqa3');
			$kwObj->faqq4 = $request->input('faqq4');
			$kwObj->faqa4 = $request->input('faqa4');
			$kwObj->faqq5 = $request->input('faqq5');
			$kwObj->faqa5 = $request->input('faqa5');
			$kwObj->faqq6 = $request->input('faqq6');
			$kwObj->faqa6 = $request->input('faqa6');


			if ($kwObj->isDirty()) {
				$originalValues = $kwObj->getOriginal();
				$changes = [];
				foreach ($kwObj->getDirty() as $field => $newValue) {
					$changes[$field] = json_encode([
						'old' => $originalValues[$field] ?? null,
						'new' => $newValue,
					]);

					$versionData['version'] = $kwObj->id;
					$versionData['updated_by'] = Auth::id();
					$versionData['table'] = "keyword";
					$versionData['attributes'] = $kwObj->keyword;
					$versionData['description'] = json_encode($changes);
				}
				$this->seoLog->createSeoLog($versionData);
			}
		}

		if (!empty($kwObj->save())) {
			$status = 1;
			$msg = "FAQ Update submitted successfully!";

		} else {
			$status = 0;
			$msg = "FAQ Update could not be submitted!";
		}

		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}



	/**
	 * Display a listing of the distinct keywords for SEO.
	 *
	 * @return json object based on pagination
	 * @param null
	 */
	public function indexCategotySEO(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {

			$leads = DB::table('parent_category as k');
			if ($request->input('search.value') !== '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('k.parent_category', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$leads = $leads->select('k.parent_category', 'k.id', 'k.meta_title', 'k.meta_keywords', 'k.meta_description', 'k.top_description', 'k.bottom_description');
			$leads = $leads->distinct();
			$leads = $leads->orderBy('k.parent_category', 'asc');
			$leads = $leads->paginate($request->input('length'), ['k.parent_category']);

			if ($leads) {
				$returnLeads = $data = [];
				$returnLeads['draw'] = $request->input('draw');
				$returnLeads['recordsTotal'] = $leads->total();
				$returnLeads['recordsFiltered'] = $leads->total();

				foreach ($leads as $lead) {


					$data[] = [
						$lead->parent_category,
						$lead->meta_title,
						$lead->meta_keywords,

						"<a href='/developer/categoryEdit/seo/$lead->id' class='btn btn-danger btn-xs'><i class='fa fa-fw fa-pencil' aria-hidden='true'></i>Edit</a>",
					];
				}
				$returnLeads['data'] = $data;
				return response()->json($returnLeads);
			}
		} else {
			return view('admin.seo.category_seo');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $keyword
	 */
	public function editCategorySEO(Request $request, $id)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return view('errors.unauthorised');
		}
		if (empty($id) || is_null($id)) {
			$this->danger_msg .= 'Keyword cannot be null or blank.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/category/seo");
		}
		$keywordObj = ParentCategory::where('id', $id)->first();

		if ($keywordObj) {
			return view('admin.seo.category_seo', ['keyword' => $keywordObj]);
		} else {
			$this->danger_msg .= 'Category not found.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/category/seo");
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $keyword
	 * @return \Illuminate\Http\Response
	 */
	public function updateCategorySEO(Request $request, $keyword)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return view('errors.unauthorised');
		}
		if (empty($keyword) || is_null($keyword)) {
			$this->danger_msg .= 'Category cannot be null or blank.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/category/seo");
		}
		$keywords = ParentCategory::where('id', $keyword)->get();
		if ($keywords) {
			$i = 0;
			foreach ($keywords as $kw) {
				$kwObj = ParentCategory::findOrFail($kw->id);
				$meta_title = $meta_description = $meta_keywords = $top_description = $bottom_description = NULL;

				if ($request->has('meta_title') && $request->input('meta_title') != '') {
					$meta_title = $request->input('meta_title');

				}
				if ($request->has('meta_description') && $request->input('meta_description') != '') {
					$meta_description = $request->input('meta_description');
					$meta_description = preg_replace('/{{keyword}}/i', $kw->keyword, $meta_description);

				}
				if ($request->has('meta_keywords') && $request->input('meta_keywords') != '') {
					$meta_keywords = $request->input('meta_keywords');
					$meta_keywords = preg_replace('/{{keyword}}/i', $kw->keyword, $meta_keywords);

				}
				if ($request->has('top_description') && $request->input('top_description') != '') {
					$top_description = $request->input('top_description');
					$top_description = preg_replace('/{{keyword}}/i', $kw->keyword, $top_description);
				}
				if ($request->has('bottom_description') && $request->input('bottom_description') != '') {
					$bottom_description = $request->input('bottom_description');
					$bottom_description = preg_replace('/{{keyword}}/i', $kw->keyword, $bottom_description);
				}


				$kwObj->meta_title = $meta_title;
				$kwObj->meta_description = $meta_description;
				$kwObj->meta_keywords = $meta_keywords;
				$kwObj->top_description = $top_description;
				$kwObj->faqq1 = $request->input('faqq1');
				$kwObj->faqa1 = $request->input('faqa1');
				$kwObj->faqq2 = $request->input('faqq2');
				$kwObj->faqa2 = $request->input('faqa2');
				$kwObj->faqq3 = $request->input('faqq3');
				$kwObj->faqa3 = $request->input('faqa3');
				$kwObj->faqq4 = $request->input('faqq4');
				$kwObj->faqa4 = $request->input('faqa4');
				$kwObj->faqq5 = $request->input('faqq5');
				$kwObj->faqa5 = $request->input('faqa5');
				$kwObj->faqq6 = $request->input('faqq6');
				$kwObj->faqa6 = $request->input('faqa6');
				$kwObj->bottom_description = $bottom_description;
				$kwObj->ratingvalue = $request->input('ratingvalue');
				$kwObj->ratingcount = $request->input('ratingcount');

				if ($kwObj->save()) {
					++$i;
				}
			}
			if ($i) {
				$this->success_msg .= "Keyword seo fields added successfully... Updated {$i} records.";
				$request->session()->flash('success_msg', $this->success_msg);
				return redirect("developer/category/seo/");
			} else {
				$this->danger_msg .= 'Keyword seo fields not added successfully.';
				$request->session()->flash('danger_msg', $this->danger_msg);
				return redirect("developer/category/seo");
			}
		} else {
			$this->danger_msg .= 'Keyword not found.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/category/seo");
		}
	}

	/**
	 * Display a listing of the distinct keywords for SEO.
	 *
	 * @return json object based on pagination
	 * @param null
	 */
	public function indexChildcategorySEO(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {

			$leads = DB::table('child_category as k');
			if ($request->input('search.value') !== '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('k.child_category', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$leads = $leads->select('k.child_category', 'k.id', 'k.meta_title', 'k.meta_keywords', 'k.meta_description', 'k.top_description', 'k.bottom_description');
			$leads = $leads->distinct();
			$leads = $leads->orderBy('k.child_category', 'asc');
			$leads = $leads->paginate($request->input('length'), ['k.child_category']);

			if ($leads) {
				$returnLeads = $data = [];
				$returnLeads['draw'] = $request->input('draw');
				$returnLeads['recordsTotal'] = $leads->total();
				$returnLeads['recordsFiltered'] = $leads->total();

				foreach ($leads as $lead) {


					$data[] = [
						$lead->child_category,
						$lead->meta_title,
						$lead->meta_keywords,
						$lead->meta_description,
						"<a href='/developer/childcategoryEdit/seo/$lead->id' class='btn btn-danger btn-xs'><i class='fa fa-fw fa-pencil' aria-hidden='true'></i>Edit</a>",
					];
				}
				$returnLeads['data'] = $data;
				return response()->json($returnLeads);
			}
		} else {
			return view('admin.seo.childcategory_seo');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $keyword
	 */
	public function editChildcategorySEO(Request $request, $keyword)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return view('errors.unauthorised');
		}
		if (empty($keyword) || is_null($keyword)) {
			$this->danger_msg .= 'Keyword cannot be null or blank.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/child_category/seo");
		}
		$keywordObj = ChildCategory::where('id', $keyword)->first();
		if ($keywordObj) {
			return view('admin.seo.childcategory_seo', ['keyword' => $keywordObj]);
		} else {
			$this->danger_msg .= 'child category not found.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/child_category/seo");
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $keyword
	 * @return \Illuminate\Http\Response
	 */
	public function updateChildcategorySEO(Request $request, $keyword)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return view('errors.unauthorised');
		}

		if (empty($keyword) || is_null($keyword)) {
			$this->danger_msg .= 'Keyword cannot be null or blank.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/child_category/seo");
		}
		$keywords = ChildCategory::where('id', $keyword)->get();
		if ($keywords) {
			$i = 0;
			foreach ($keywords as $kw) {
				$kwObj = ChildCategory::findOrFail($kw->id);
				$meta_title = $meta_description = $meta_keywords = $top_description = $bottom_description = NULL;

				if ($request->has('meta_title') && $request->input('meta_title') != '') {
					$meta_title = $request->input('meta_title');

				}
				if ($request->has('meta_description') && $request->input('meta_description') != '') {
					$meta_description = $request->input('meta_description');
					$meta_description = preg_replace('/{{keyword}}/i', $kw->keyword, $meta_description);

				}
				if ($request->has('meta_keywords') && $request->input('meta_keywords') != '') {
					$meta_keywords = $request->input('meta_keywords');
					$meta_keywords = preg_replace('/{{keyword}}/i', $kw->keyword, $meta_keywords);

				}
				if ($request->has('top_description') && $request->input('top_description') != '') {
					$top_description = $request->input('top_description');
					$top_description = preg_replace('/{{keyword}}/i', $kw->keyword, $top_description);

				}
				if ($request->has('bottom_description') && $request->input('bottom_description') != '') {
					$bottom_description = $request->input('bottom_description');
					$bottom_description = preg_replace('/{{keyword}}/i', $kw->keyword, $bottom_description);

				}




				$kwObj->meta_title = $meta_title;
				$kwObj->meta_description = $meta_description;
				$kwObj->meta_keywords = $meta_keywords;
				$kwObj->top_description = $top_description;

				$kwObj->faqq1 = $request->input('faqq1');
				$kwObj->faqa1 = $request->input('faqa1');
				$kwObj->faqq2 = $request->input('faqq2');
				$kwObj->faqa2 = $request->input('faqa2');
				$kwObj->faqq3 = $request->input('faqq3');
				$kwObj->faqa3 = $request->input('faqa3');
				$kwObj->faqq4 = $request->input('faqq4');
				$kwObj->faqa4 = $request->input('faqa4');
				$kwObj->faqq5 = $request->input('faqq5');
				$kwObj->faqa5 = $request->input('faqa5');
				$kwObj->faqq6 = $request->input('faqq6');
				$kwObj->faqa6 = $request->input('faqa6');
				$kwObj->bottom_description = $bottom_description;
				$kwObj->ratingvalue = $request->input('ratingvalue');
				$kwObj->ratingcount = $request->input('ratingcount');
				if ($kwObj->save()) {
					++$i;
				}
			}
			if ($i) {
				$this->success_msg .= "child category seo fields added successfully... Updated {$i} records.";
				$request->session()->flash('success_msg', $this->success_msg);
				return redirect("developer/childcategory/seo");
			} else {
				$this->danger_msg .= 'child category seo fields not added successfully.';
				$request->session()->flash('danger_msg', $this->danger_msg);
				return redirect("developer/childcategory/seo");
			}
		} else {
			$this->danger_msg .= 'Child not found.';
			$request->session()->flash('danger_msg', $this->danger_msg);
			return redirect("developer/childcategory/seo");
		}
	}




	/**
	 * Get matches courses based on ajax.
	 *
	 * @param  string
	 * @return JSON Object having matched course details
	 */
	public function getCourseAjax(Request $request)
	{
		if ($request->ajax()) {
			if (null == $request->input('q')) {
				$courses = Keyword::take(6)->get();
			} else {
				$courses = Keyword::where('keyword', 'LIKE', "%" . $request->input('q') . "%")->get();
			}
			return response()->json($courses, 200);
		}
	}

	/**
	 * Remove the specified resource from storage status.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function seoStatus(request $request, $id, $val)
	{
		if ($request->ajax()) {

			$keyword = Keyword::findOrFail($id);
			$keyword->seo_type = $val;

			if ($keyword->save()) {
				$status = 1;
				$msg = "SEO status updated successfully !";
			} else {
				$status = 0;
				$msg = "SEO status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}

}
