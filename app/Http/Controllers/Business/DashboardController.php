<?php
namespace App\Http\Controllers\Business;
use App\Support\DemoStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\LeadFollowUp;
use App\Models\Lead;
use App\Models\Status;
use App\Models\Keyword;
use App\Models\Client;
use App\Models\PaymentHistory;
use App\Models\AssignedZone;
use App\Models\State;
use App\Models\AssignedLead;
use DB;
use Validator; 
use Illuminate\Http\JsonResponse;
 
 
use Carbon\Carbon; 
class DashboardController extends Controller
{
    private function common(): array { 
 
    // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
    $client = Client::find($clientID); 

	$leads = DB::table('leads')
        ->join('assigned_leads','leads.id','=','assigned_leads.lead_id')				  
        ->select('leads.*','assigned_leads.client_id','assigned_leads.lead_id','assigned_leads.created_at as created')				   
        ->orderBy('assigned_leads.created_at','desc')
        ->where('assigned_leads.readLead','0')
        ->where('assigned_leads.client_id',$clientID)->get()->count();
  
//  $completion = auth()->guard('business')->user()->getProfileCompletionBreakdown();

//   $business = Auth::guard('business')->user();
 
 $completion = $client->getProfileCompletionBreakdown();

//   dd($completion);
    $percent = $completion['total'];

    
	$profile=[
        'name'=>$client->business_name,
        'category'=>'',
        'verified'=>$client->verified,
        'profileCompletion'=>$percent,
        'yearEstablished'=>$client->year_of_estb,
        'description'=>$client->business_description,        
        'overview'=>$client->business_overview,
        'ownerName'=>$client->first_name.' '.$client->last_name,
        'ownerPhone'=>$client->personal_phone,
        'ownerEmail'=>$client->personal_email,
        'phone'=>$client->mobile,
        'email'=>$client->email,
        'website'=>$client->website,
        'city'=>$client->city,
        'state'=>$client->state,
        'zone'=>$client->zone,
        'area'=>$client->area,
        'pincode'=>$client->pincode,
        'landmark'=>$client->landmark,
        'certifications'=>$client->certifications,
        'business_map'=>$client->business_map,
        'address'=>$client->address,        
        'hours'=>'Mon-Sat: 9:00 AM - 7:00 PM',
        'metaTitle'=>'',
        'metaDescription'=>'',
        'metaKeyword'=>'',
        'logoUrl'=>optional(unserialize($client->logo))['large']['src'] ?? '#',
        'bannerUrl'=>optional(unserialize($client->profile_pic))['large']['src'] ?? '#',
        'facebookUrl'=>$client->facebook_url,
        'instagramUrl'=>$client->instagram_url,
        'twitterUrl'=>$client->twitter_url,
        'linkedinUrl'=>$client->linkedin_url,
        'youtubeUrl'=>$client->youtube_url,
        'pinterestUrl'=>$client->pinterest_url,
        'newLead'=>$leads
        ];


		$today=now(); 
	
	 $account=[        
        'coins'=>$client->coins_amt,     
        'pauseLead'=>$client->pauseLead,
        'activeStatus'=>$client->active_status,
        'paidStatus'=>$client->paid_status,
        'certifiedStatus'=>$client->certified_status,
        'trustedStatus'=>$client->trusted_status,
        'gstStatus'=>$client->gst_status,
        'chatFeature'=>true,
        'clientContactStatus'=>true,
        'clientTransferStatus'=>false,
        'clientGSTStatus'=>$client->gst_status,
        'postingAndReceivingStatus'=>true,
        'membershipType'=>$client->client_type,
        'packageName'=>ucfirst($client->client_type),
        'memberSince'=>date('d-m-Y',strtotime($client->expired_from)),
        'membershipEndsOn'=>date('d-m-Y',strtotime($client->expired_on)),
        'dailyLeadLimit'=>25,
        'leadsUsedToday'=>8
     ];
$tabs=['general'=>'Basic Info','personal'=>'Personal Details','seo'=>'SEO Meta','keywords'=>'Service Keywords','locations'=>'Service Areas','media'=>'Media & Gallery','awards'=>'Awards','certs'=>'Certificates','socials'=>'Social Links','recent'=>'Recent Activity','faqs'=>'FAQ`s'];


$leadsTabs=['leads'=>'Lead','new-lead'=>'New Leads','favorites'=>'Favorites','archived'=>'Archived','manage-enquiry'=>'Manage Enquiry'];



		return ['profile'=>$profile,'account'=>$account,'completion'=>$completion,'tabs'=>$tabs,'leadsTabs'=>$leadsTabs]; 
	
	}
	
    public function dashboard(Request $request): View {
			
		
    $clientID = auth()->guard('clients')->user()->id;
  
    $clientDetails = DB::table('clients')->where('id', $clientID)->first();
		
	$todayLeads = DB::table('leads')
    ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
    ->leftJoin('citylists', 'leads.city_id', '=', 'citylists.id')
    ->leftJoin('areas', 'leads.area_id', '=', 'areas.id')
    ->leftJoin('zones', 'leads.zone_id', '=', 'zones.id')
    ->select(
        'leads.*',
        'assigned_leads.client_id',
        'assigned_leads.lead_id',
        'assigned_leads.created_at as created',
        'areas.area',
        'zones.zone'
    )
    ->where('assigned_leads.client_id', $clientID)
    // ->whereDate('assigned_leads.created_at', Carbon::today())
    ->orderBy('assigned_leads.created_at', 'desc')
    ->get();

$todayCount = $todayLeads->count();
	  	
	    


        $data = [];				
			 
			$leads = DB::table('leads as leads');
			$leads = $leads->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');
			
			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			 
			$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Interested' || `name` LIKE 'Meeting Close' || `name` LIKE 'Sales Close' || `name` LIKE 'Invalid Number' || `name` LIKE 'Joined')";
					 
			$leads = $leads->join(DB::raw('('.$rawQuery.') as fu'),'leads.id','=',DB::raw('`fu`.`lead_id`'));
			// generating raw query to make join
			
			$leads = $leads->select('leads.*','leads.id as lead_id','assigned_leads.*','assigned_leads.id as assign_id',DB::raw('`fu`.`status_name`'),DB::raw('`fu`.`status`'),DB::raw('`fu`.`expected_date_time`'),DB::raw('`fu`.`remark`'));
			$leads = $leads->orderBy('assigned_leads.id','desc');
		 
		 
			$leads = $leads->where('assigned_leads.client_id', $clientID);
				 
			$recentActivity = $leads->get();
			
//  dd($recentActivity);







    $rating = DB::table('comments')
    ->where('comment_client_ID', $clientID)
    ->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
    ->first();

$avgRating = ($rating->total > 0)
    ? round($rating->sum / $rating->total, 1)
    : 0;
 
$ratingCount = $rating->total ?? 0;

// 1. Get latest follow_up id per lead for this client
$latestFollowUpIds = DB::table('lead_follow_ups')
    ->select('lead_id', DB::raw('MAX(id) as max_id'))
    ->where('client_id', $clientID)
    ->groupBy('lead_id');

// 2. Main query — only join the latest follow-up row, then filter its status
// $leads = DB::table('assigned_leads')
//     ->join('leads', 'leads.id', '=', 'assigned_leads.lead_id')
//     ->joinSub($latestFollowUpIds, 'lfu_latest', function ($join) {
//         $join->on('assigned_leads.lead_id', '=', 'lfu_latest.lead_id');
//     })
//     ->join('lead_follow_ups as lfu', 'lfu_latest.max_id', '=', 'lfu.id')
//     ->leftJoin('status as s', 'lfu.status', '=', 's.id')
//     ->where('assigned_leads.client_id', $clientID)
//     ->where('s.name', 'New Lead')   // <-- now only matches CURRENT status, not history
//     ->orderBy('assigned_leads.created_at', 'desc')
//     ->select(
//         'leads.id as lead_id',
//         'leads.name',
//         'leads.mobile',
//         'leads.email',
//         'leads.kw_text',
//         'leads.zone',
//         'leads.city_name',
//         'leads.plan',
//         'leads.address',
//         'leads.age',
//         'leads.experience',
//         'leads.remark',
//         'assigned_leads.created_at as created',
//         'assigned_leads.coins',
//         'assigned_leads.readLead',
//         'assigned_leads.scrapLead',
//         'assigned_leads.id as assignId',
//         'assigned_leads.favorite_lead',
//         's.name as status_name'
//     )
//     ->paginate(300);
 
        $leads = DB::table('leads as leads');
			$leads = $leads->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');
			
			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			 
			$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Interested' || `name` LIKE 'Meeting Close' || `name` LIKE 'Sales Close' || `name` LIKE 'Invalid Number' || `name` LIKE 'Joined')";
					 
			$leads = $leads->join(DB::raw('('.$rawQuery.') as fu'),'leads.id','=',DB::raw('`fu`.`lead_id`'));
			// generating raw query to make join
			
			$leads = $leads->select('leads.*','leads.id as lead_id','assigned_leads.*','assigned_leads.id as assign_id',DB::raw('`fu`.`status_name`'),DB::raw('`fu`.`status`'),DB::raw('`fu`.`expected_date_time`'),DB::raw('`fu`.`remark`'));
			$leads = $leads->orderBy('assigned_leads.id','desc');
		 
		 
			$leads = $leads->where('assigned_leads.client_id', $clientID);
				 
			$leads = $leads->paginate(10);

        $businessName = $clientDetails->business_name ?? 'Our Company';
        $address = $clientDetails->address ?? '';
        $map = $clientDetails->business_map ?? '';
        $profileUrl = url('business/' . ($clientDetails->business_slug ?? ''));

        // Transform Data (Fast Way)
        $leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

            $keyword = $lead->kw_text ?? 'your enquiry';
            $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));
            // 🔹 Share Lead Details
            $lead->share_address = "Greetings from {$businessName},\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information"
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . "{$profileUrl}";

            $lead->share_service = "Greetings from {$businessName},\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information of the services offered by our business please refer "
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . ", Or {$profileUrl}";
            $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information about the services offered by our business"
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . ". Or visit our profile: {$profileUrl}";


            $frmcheckText = '';

            if (!empty($lead->frmcheck)) {
                $frmcheckArray = is_array($lead->frmcheck)
                    ? $lead->frmcheck
                    : json_decode($lead->frmcheck, true);
                if (is_array($frmcheckArray)) {
                    $frmcheckText = implode(', ', $frmcheckArray);
                }
            }

           
            $parts = array_filter([
            $lead->kw_text   ? '<strong>Interested in</strong> ' . e($lead->kw_text)   : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"        : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"          : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"               : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                 : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"   : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

      
            return $lead;
        });

	 
 
	  // 1. Latest follow-up per lead
$latestFollowUpsSub = DB::table('lead_follow_ups')
    ->select('lead_id', DB::raw('MAX(id) as max_id'))
    ->where('client_id', $clientID)
    ->groupBy('lead_id');
 
$latestFollowUps = DB::table('lead_follow_ups as lf1')
    ->joinSub($latestFollowUpsSub, 'lf2', function ($join) {
        $join->on('lf1.id', '=', 'lf2.max_id');
    })
    ->leftJoin('status as s', 'lf1.status', '=', 's.id')   // <-- join lookup table
    ->where('lf1.client_id', $clientID)
    ->select('lf1.lead_id', 's.name as status');           // <-- pull the NAME, not the id
 
// 2. Status counts — ONE status column only
$statusCounts = DB::table('assigned_leads')
    ->leftJoinSub($latestFollowUps, 'lfu', function ($join) {
        $join->on('assigned_leads.lead_id', '=', 'lfu.lead_id');
    })
    ->where('assigned_leads.client_id', $clientID)
    ->select(
        DB::raw("COALESCE(lfu.status, 'New Lead') as status"),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy(DB::raw("COALESCE(lfu.status, 'New Lead')"))
    ->pluck('total', 'status');

// dd($statusCounts); // uncomment to inspect raw counts

// 3. Normalize so all 8 labels always show, even with 0 leads
$statusLabels = ['New Lead', 'Interested', 'Not Interested', 'Follow Up', 'NPUP', 'Not Connected','Visited','Sales Close', 'Call Later', 'Joined','Meeting','Invalid Number','Switched Off'];

$finalCounts = collect($statusLabels)->mapWithKeys(function ($label) use ($statusCounts) {
    return [$label => $statusCounts[$label] ?? 0];
});

   
		
		$stats=['profileViews'=>$clientDetails->views,'viewsChangePct'=>18,'totalLeads'=>$todayCount,'leadsChangePct'=>12,'totalCalls'=>174,'avgRating'=>$avgRating];	
		$today=now(); 

		$series=[]; 
		for($i=29;$i>=0;$i--){			 
			$series[]=['date'=>$today->copy()->subDays($i)->format('Y-m-d'),'views'=>20 + (($i*47)%190) + (($i%5)*28)];		 
		}
		// dd($series);
		// $activities=[
		// ['id'=>1,'type'=>'lead','text'=>'New lead received from Rahul Verma for AC repair','createdAt'=>$today->copy()->subMinutes(18)->toDateTimeString()],
		// ['id'=>2,'type'=>'review','text'=>'Priya Nair left a 5-star review','createdAt'=>$today->copy()->subHours(2)->toDateTimeString()],
		// ['id'=>3,'type'=>'view_milestone','text'=>'Your profile crossed 12,000 total views','createdAt'=>$today->copy()->subHours(7)->toDateTimeString()],
		// ['id'=>4,'type'=>'listing','text'=>'Emergency Plumbing listing was updated','createdAt'=>$today->copy()->subDay()->toDateTimeString()],
		// ['id'=>5,'type'=>'lead','text'=>'A lead was assigned to Neha Singh','createdAt'=>$today->copy()->subDays(2)->toDateTimeString()],
		// ];
	 $startOfMonth = now()->startOfMonth();
    $endOfMonth   = now()->endOfMonth();

    $monthsFollow = [
        'total_leads'    => Lead::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        'interested'     => Lead::where('status_name', 'interested')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        'follow_up'      => Lead::where('status_name', 'follow_up')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        'calling_visits' => Lead::where('status_name', 'calling_visit')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        'direct_visits'  => Lead::where('status_name', 'direct_visit')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
        'joined'         => Lead::where('status_name', 'joined')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
    ];

       $followups = DB::table('lead_follow_ups')
        ->leftJoin('status as s', 'lead_follow_ups.status', '=', 's.id')
        ->where('lead_follow_ups.client_id', $clientID)
        ->orderByDesc('lead_follow_ups.id')
        ->select(
            'lead_follow_ups.id',
            'lead_follow_ups.lead_id',
            'lead_follow_ups.remark as notes',
            's.name as outcome',
            'lead_follow_ups.expected_date_time as dueAt',
             
        )
        ->get()
        ->map(fn ($fu) => (array) $fu);
        $statues = Status::where('lead_follow_up', '1')->get();	 


		return view('business.business.dashboard',array_merge($this->common(),
		['stats'=>$stats,'monthsFollow'=>$monthsFollow,'statues'=>$statues,'series'=>$series,'recentActivity'=>$recentActivity,'leads'=>$leads,'followups'=>$followups]));

	}
	
 	public function newEnquiry(Request $request)
	{
		// $client = auth()->guard('clients')->user();

		// if (!$client) {
		// 	return redirect()->route('login');
		// }
// dd('new lead');
		$clientID = '1748';
		// $clientID = $client->id;

		$clientDetails = DB::table('clients')
			->where('id', $clientID)
			->first();

		$rating = DB::table('comments')
			->where('comment_client_ID', $clientID)
			->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
			->first();

		$avgRating = ($rating->total > 0)
			? round($rating->sum / $rating->total, 1)
			: 0;
 $statusBucketMap = [
        'New Lead'        => 'new',
        'Interested'      => 'contacted',
        'Follow Up'       => 'contacted',
        'Call Later'      => 'contacted',
        'Meeting'         => 'contacted',
        'Not Connected'   => 'contacted',
        'NPUP'            => 'contacted',
        'Visited'         => 'contacted',
        'Sales Close'     => 'converted',
        'Joined'          => 'converted',
        'Not Interested'  => 'closed',
        'Invalid Number'  => 'closed',
        'Switched Off'    => 'closed',
    ];

		$ratingCount = $rating->total ?? 0;
 $statusNamesForBucket = collect($statusBucketMap)
      
        ->keys()
        ->all();
// dd($statusNamesForBucket);
    // 1. Get latest follow_up id per lead for this client
    $latestFollowUpIds = DB::table('lead_follow_ups')
        ->select('lead_id', DB::raw('MAX(id) as max_id'))
        ->where('client_id', $clientID)
        ->groupBy('lead_id');

$leads = DB::table('leads')
    ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
    ->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
    ->leftjoin('areas', 'leads.area_id', '=', 'areas.id')
    ->leftjoin('zones', 'leads.zone_id', '=', 'zones.id')
    ->select('leads.*', 'assigned_leads.*', 'assigned_leads.client_id as clientId', 'assigned_leads.lead_id', 'assigned_leads.id as assignId', 'assigned_leads.created_at as created', 'areas.area', 'zones.zone')

    ->orderBy('assigned_leads.created_at', 'desc')
     ->where('assigned_leads.readLead', '0')
    ->where('assigned_leads.client_id', $clientID)->paginate(300);



 

    $businessName = $clientDetails->business_name ?? 'Our Company';
    $address      = $clientDetails->address ?? '';
    $map          = $clientDetails->business_map ?? '';
    $profileUrl   = url('businessdetails/' . ($clientDetails->business_slug ?? ''));

    // Transform Data (Fast Way) — now returns the exact shape leads.blade.php expects
    $leads->getCollection()->transform(function ($lead) use (
        $businessName, $address, $map, $profileUrl, $avgRating, $ratingCount, $statusBucketMap
    ) {
        $keyword  = $lead->kw_text ?? 'your enquiry';
        $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));

        // FIX: was $addressText (undefined) — now uses $address, defined above
        $lead->share_address = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . "{$profileUrl}";

        $lead->share_service = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information of the services offered by our business please refer "
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ", Or {$profileUrl}";

        $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information about the services offered by our business"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ". Or visit our profile: {$profileUrl}";

        $frmcheckText = '';
        if (!empty($lead->frmcheck ?? null)) {
            $frmcheckArray = is_array($lead->frmcheck) ? $lead->frmcheck : json_decode($lead->frmcheck, true);
            if (is_array($frmcheckArray)) {
                $frmcheckText = implode(', ', $frmcheckArray);
            }
        }

        $parts = array_filter([
            $lead->kw_text   ? '<strong>Interested in</strong> ' . e($lead->kw_text)   : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"        : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"          : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"               : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                 : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"   : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

        // ── Reshape into the array keys leads.blade.php actually reads ──
        return [
            'assignId'            => $lead->assignId,       // use assigned_leads.id: the per-client record the update routes act on
            'lead_id'       => $lead->lead_id,         // keep raw lead id too, for follow-up joins
            'clientId'       => $lead->clientId,         // keep raw lead id too, for follow-up joins
            'customerName'  => $lead->name,
            'phone'         => $lead->mobile,
            'email'         => $lead->email,
            'readLead'      => $lead->readLead,
            'service'       => $keyword,
            'message'       => $lead->remarks,
            'status'        => $statusBucketMap[$lead->status_name] ?? 'new',   // bucketed, for filter tabs
            'status_label'  => $lead->status_name ?? 'New Lead',                // real granular label, for the badge
            'favorite'      => $lead->favorite_lead,
            'archived'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'scrapLead'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'coins'            => $lead->coins,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'createdAt'     => $lead->created,
            'assignedTo'    => $lead->clientId ?? null,
            'share_address' => $lead->share_address,
            'share_service' => $lead->share_service,
            'share_review'  => $lead->share_review,
            'share_lead'    => $lead->share_lead,
        ];
    });

   $followups = DB::table('lead_follow_ups')
        ->leftJoin('status as s', 'lead_follow_ups.status', '=', 's.id')
        ->where('lead_follow_ups.client_id', $clientID)
        ->orderByDesc('lead_follow_ups.id')
        ->select(
            'lead_follow_ups.id',
            'lead_follow_ups.lead_id',
            'lead_follow_ups.remark as notes',
            's.name as outcome',
            'lead_follow_ups.expected_date_time as dueAt',
             
        )
        ->get()
        ->map(fn ($fu) => (array) $fu);
   $statues = Status::where('lead_filter', '1')->get();

   
		return view('business.business.new-enquiry', array_merge($this->common(),['leads' => $leads,'followups'=>$followups,    'statues'       => $statues,]));
	}

public function leads(Request $request,$tab='leads'): View
{

          
    if(request()->segment(3)){
    $tab = request()->segment(3);
    }else{

    $tab= 'leads';
    }

 


    $clientID = auth()->guard('clients')->user()->id;
 

    $statues = Status::where('lead_filter', '1')->get();

    $services = DB::table('assigned_kwds')
        ->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
        ->select('keyword.id', 'keyword.keyword', 'keyword.slug')
        ->orderBy('keyword.keyword', 'asc')
        ->where('assigned_kwds.client_id', $clientID)
        ->get();

    // ── FIX: $clientDetails was never fetched before — this was crashing the page ──
    $clientDetails = DB::table('clients')->where('id', $clientID)->first();

    $rating = DB::table('comments')
        ->where('comment_client_ID', $clientID)
        ->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
        ->first();

    $avgRating   = $rating->total > 0 ? round($rating->sum / $rating->total, 1) : 0;
    $ratingCount = $rating->total ?? 0;

    // Maps 13 granular statuses down to the 4 buckets the UI's filter tabs use.
    // Adjust the bucket names on the right to match your Status table's real names.
    // Defined up here (not after the query) because we need it to build the SQL filter below.
    $statusBucketMap = [
        'New Lead'        => 'new',
        'Interested'      => 'contacted',
        'Follow Up'       => 'contacted',
        'Call Later'      => 'contacted',
        'Meeting'         => 'contacted',
        'Not Connected'   => 'contacted',
        'NPUP'            => 'contacted',
        'Visited'         => 'contacted',
        'Sales Close'     => 'converted',
        'Joined'          => 'converted',
        'Not Interested'  => 'closed',
        'Invalid Number'  => 'closed',
        'Switched Off'    => 'closed',
    ];

    $filter = $request->query('filter', 'all');
// dd($filter);
    // Reverse the bucket map: "converted" -> ["Sales Close", "Joined"], etc.
    // Used to filter the SQL query by real status names for a given bucket.
    $statusNamesForBucket = collect($statusBucketMap)
        ->filter(fn ($bucket) => $bucket === $filter)
        ->keys()
        ->all();
// dd($statusNamesForBucket);
    // 1. Get latest follow_up id per lead for this client
    $latestFollowUpIds = DB::table('lead_follow_ups')
        ->select('lead_id', DB::raw('MAX(id) as max_id'))
        ->where('client_id', $clientID)
        ->groupBy('lead_id');

    // 2. Main query — only join the latest follow-up row, then filter its status
    $leads = DB::table('assigned_leads')
        ->join('leads', 'leads.id', '=', 'assigned_leads.lead_id')
        ->joinSub($latestFollowUpIds, 'lfu_latest', function ($join) {
            $join->on('assigned_leads.lead_id', '=', 'lfu_latest.lead_id');
        })
        ->join('lead_follow_ups as lfu', 'lfu_latest.max_id', '=', 'lfu.id')
        ->leftJoin('status as s', 'lfu.status', '=', 's.id')
        ->where('assigned_leads.client_id', $clientID)
        // ── FIX: filter=converted etc. now actually filters the query ──
        ->when($filter === 'favorites', fn ($q) => $q->where('assigned_leads.favorite_lead', '1')->where('assigned_leads.scrapLead', '0'))
        ->when($filter === 'archived', fn ($q) => $q->where('assigned_leads.scrapLead', '1'))
        ->when($filter === 'all', fn ($q) => $q->where('assigned_leads.scrapLead', '0'))
        ->when(!empty($statusNamesForBucket), fn ($q) => $q
            ->whereIn('s.name', $statusNamesForBucket)
            ->where('assigned_leads.scrapLead', '0'))
        ->orderBy('assigned_leads.created_at', 'desc')
        ->select(
            'leads.id as lead_id',
            'leads.name',
            'leads.mobile',
            'leads.email',
            'leads.kw_text',
            'leads.zone',
            'leads.city_name',
            'leads.plan',
            'leads.address',
            'leads.age',
            'leads.experience',
            'leads.remark',
            'assigned_leads.created_at as created',
            'assigned_leads.coins',
            'assigned_leads.readLead',
            'assigned_leads.scrapLead',
            'assigned_leads.id as assignId',
            'assigned_leads.favorite_lead',
            'assigned_leads.client_id as clientId', 
            's.id as status_id',
            's.name as status_name',
            'lfu.expected_date_time as followDate'
        )
        ->paginate(300);

    $businessName = $clientDetails->business_name ?? 'Our Company';
    $address      = $clientDetails->address ?? '';
    $map          = $clientDetails->business_map ?? '';
    $profileUrl   = url('businessdetails/' . ($clientDetails->business_slug ?? ''));

    // Transform Data (Fast Way) — now returns the exact shape leads.blade.php expects
    $leads->getCollection()->transform(function ($lead) use (
        $businessName, $address, $map, $profileUrl, $avgRating, $ratingCount, $statusBucketMap
    ) {
        $keyword  = $lead->kw_text ?? 'your enquiry';
        $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));

        // FIX: was $addressText (undefined) — now uses $address, defined above
        $lead->share_address = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . "{$profileUrl}";

        $lead->share_service = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information of the services offered by our business please refer "
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ", Or {$profileUrl}";

        $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information about the services offered by our business"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ". Or visit our profile: {$profileUrl}";

        $frmcheckText = '';
        if (!empty($lead->frmcheck ?? null)) {
            $frmcheckArray = is_array($lead->frmcheck) ? $lead->frmcheck : json_decode($lead->frmcheck, true);
            if (is_array($frmcheckArray)) {
                $frmcheckText = implode(', ', $frmcheckArray);
            }
        }

        $parts = array_filter([
            $lead->kw_text   ? '<strong>Interested in</strong> ' . e($lead->kw_text)   : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"        : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"          : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"               : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                 : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"   : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

        // ── Reshape into the array keys leads.blade.php actually reads ──
        return [
            'assignId'            => $lead->assignId,       // use assigned_leads.id: the per-client record the update routes act on
            'lead_id'       => $lead->lead_id,         // keep raw lead id too, for follow-up joins
            'clientId'       => $lead->clientId,         // keep raw lead id too, for follow-up joins
            'customerName'  => $lead->name,
            'phone'         => $lead->mobile,
            'email'         => $lead->email,
            'readLead'      => $lead->readLead,
            'service'       => $keyword,
            'message'       => $lead->remarks,
            'followDate'       => $lead->followDate,
            'status'        => $statusBucketMap[$lead->status_name] ?? 'new',   // bucketed, for filter tabs
            'status_label'  => $lead->status_name ?? 'New Lead',                // real granular label, for the badge
            'favorite'      => $lead->favorite_lead,
            'archived'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'scrapLead'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'coins'            => $lead->coins,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'createdAt'     => $lead->created,
            'assignedTo'    => $lead->clientId ?? null,
            'share_address' => $lead->share_address,
            'share_service' => $lead->share_service,
            'share_review'  => $lead->share_review,
            'share_lead'    => $lead->share_lead,
        ];
    });

    // 1. Latest follow-up per lead
    $latestFollowUpsSub = DB::table('lead_follow_ups')
        ->select('lead_id', DB::raw('MAX(id) as max_id'))
        ->where('client_id', $clientID)
        ->groupBy('lead_id');

    $latestFollowUps = DB::table('lead_follow_ups as lf1')
        ->joinSub($latestFollowUpsSub, 'lf2', function ($join) {
            $join->on('lf1.id', '=', 'lf2.max_id');
        })
        ->leftJoin('status as s', 'lf1.status', '=', 's.id')
        ->where('lf1.client_id', $clientID)
        ->select('lf1.lead_id', 's.name as status', 'lf1.expected_date_time');

    // 2. Status counts for a dashboard widget, if you use one
    $statusCounts = DB::table('assigned_leads')
        ->leftJoinSub($latestFollowUps, 'lfu', function ($join) {
            $join->on('assigned_leads.lead_id', '=', 'lfu.lead_id');
        })
        ->where('assigned_leads.client_id', $clientID)
        ->select(
            DB::raw("COALESCE(lfu.status, 'New Lead') as status"),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy(DB::raw("COALESCE(lfu.status, 'New Lead')"))
        ->pluck('total', 'status');

    $statusLabels = ['New Lead', 'Interested', 'Not Interested', 'Follow Up', 'NPUP', 'Not Connected', 'Visited', 'Sales Close', 'Call Later', 'Joined', 'Meeting', 'Invalid Number', 'Switched Off'];

    $finalCounts = collect($statusLabels)->mapWithKeys(fn ($label) => [$label => $statusCounts[$label] ?? 0]);

    // ── FIX: pull REAL follow-ups (all, not just latest) for the activity list, ──
    // ── shaped to match what the view's $leadFus logic expects ──
    $followups = DB::table('lead_follow_ups')
        ->leftJoin('status as s', 'lead_follow_ups.status', '=', 's.id')
        ->where('lead_follow_ups.client_id', $clientID)
        ->orderByDesc('lead_follow_ups.id')
        ->select(
            'lead_follow_ups.id',
            'lead_follow_ups.lead_id',
            'lead_follow_ups.remark as notes',
            's.name as outcome',
            'lead_follow_ups.expected_date_time as dueAt',
             
        )
        ->get()
        ->map(fn ($fu) => (array) $fu);

    // ── FIX: pull REAL team/staff instead of DemoStore ──
    $team = DB::table('clients')  // rename to your actual team/employees table
        ->where('id', $clientID)
        ->select('id', 'business_name')
        ->get()
        ->map(fn ($m) => (array) $m);


        
if($tab == "leads"){


    return view('business.business.leads', array_merge($this->common(), [
        'leads'      => $leads,
        'team'       => $team,
        'tab'       => $tab,
        'statues'       => $statues,
        'followups'  => $followups,
        'statusCounts' => $finalCounts,   // available if you want to show a status summary widget
        'filter'     => $filter,
    ]));


}elseif($tab == "new-lead"){


    $leads = DB::table('leads')
        ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
        ->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
        ->leftjoin('areas', 'leads.area_id', '=', 'areas.id')
        ->leftjoin('zones', 'leads.zone_id', '=', 'zones.id')
        ->select('leads.*', 'assigned_leads.*', 'assigned_leads.client_id as clientId', 'assigned_leads.lead_id', 'assigned_leads.id as assignId', 'assigned_leads.created_at as created', 'areas.area', 'zones.zone')

    ->orderBy('assigned_leads.created_at', 'desc')
     ->where('assigned_leads.readLead', '0')
    ->where('assigned_leads.client_id', $clientID)->paginate(300);
 
    $businessName = $clientDetails->business_name ?? 'Our Company';
    $address      = $clientDetails->address ?? '';
    $map          = $clientDetails->business_map ?? '';
    $profileUrl   = url('businessdetails/' . ($clientDetails->business_slug ?? ''));

    // Transform Data (Fast Way) — now returns the exact shape leads.blade.php expects
    $leads->getCollection()->transform(function ($lead) use (
        $businessName, $address, $map, $profileUrl, $avgRating, $ratingCount, $statusBucketMap
    ) {
        $keyword  = $lead->kw_text ?? 'your enquiry';
        $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));

        // FIX: was $addressText (undefined) — now uses $address, defined above
        $lead->share_address = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . "{$profileUrl}";

        $lead->share_service = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information of the services offered by our business please refer "
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ", Or {$profileUrl}";

        $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information about the services offered by our business"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ". Or visit our profile: {$profileUrl}";

        $frmcheckText = '';
        if (!empty($lead->frmcheck ?? null)) {
            $frmcheckArray = is_array($lead->frmcheck) ? $lead->frmcheck : json_decode($lead->frmcheck, true);
            if (is_array($frmcheckArray)) {
                $frmcheckText = implode(', ', $frmcheckArray);
            }
        }

        $parts = array_filter([
            $lead->kw_text   ? '<strong>Interested in</strong> ' . e($lead->kw_text)   : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"        : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"          : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"               : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                 : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"   : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

        // ── Reshape into the array keys leads.blade.php actually reads ──
        return [
            'assignId'            => $lead->assignId,       // use assigned_leads.id: the per-client record the update routes act on
            'lead_id'       => $lead->lead_id,         // keep raw lead id too, for follow-up joins
            'clientId'       => $lead->clientId,         // keep raw lead id too, for follow-up joins
            'customerName'  => $lead->name,
            'phone'         => $lead->mobile,
            'email'         => $lead->email,
            'readLead'      => $lead->readLead,
            'service'       => $keyword,
            'message'       => $lead->remarks,
            'status'        => $statusBucketMap[$lead->status_name] ?? 'new',   // bucketed, for filter tabs
            'status_label'  => $lead->status_name ?? 'New Lead',                // real granular label, for the badge
            'favorite'      => $lead->favorite_lead,
            'archived'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'scrapLead'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'coins'            => $lead->coins,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'createdAt'     => $lead->created,
            'assignedTo'    => $lead->clientId ?? null,
            'share_address' => $lead->share_address,
            'share_service' => $lead->share_service,
            'share_review'  => $lead->share_review,
            'share_lead'    => $lead->share_lead,
        ];
    });
 return view('business.business.new-enquiry', array_merge($this->common(), [
        'leads'      => $leads,
        'team'       => $team,
        'tab'       => $tab,
        'statues'       => $statues,
        'followups'  => $followups,
        'statusCounts' => $finalCounts,   // available if you want to show a status summary widget
        'filter'     => $filter,
    ]));


}elseif($tab == "archived"){

 
     $leads = DB::table('leads as leads');
			$leads = $leads->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');
			
			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			 
			$rawQuery .= " AND m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Meeting Close' || `name` LIKE 'Sales Close' || `name` LIKE 'Joined')";
					 
			$leads = $leads->join(DB::raw('('.$rawQuery.') as fu'),'leads.id','=',DB::raw('`fu`.`lead_id`'));
			// generating raw query to make join
			
			$leads = $leads->select('leads.*','assigned_leads.*','assigned_leads.id as assign_id','assigned_leads.created_at as createdAt',DB::raw('`fu`.`status_name`'),DB::raw('`fu`.`status`'),DB::raw('`fu`.`expected_date_time`'),DB::raw('`fu`.`remark`'));
			$leads = $leads->orderBy('assigned_leads.id','desc');
		 
		 
			$leads = $leads->where('assigned_leads.client_id', $clientID);
				 
			$leads = $leads->paginate(25);

        $businessName = $clientDetails->business_name ?? 'Our Company';
        $address = $clientDetails->address ?? '';
        $map = $clientDetails->business_map ?? '';
        $profileUrl = url('business/' . ($clientDetails->business_slug ?? ''));

        // Transform Data (Fast Way)
        $leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

            $keyword = $lead->kw_text ?? 'your enquiry';
            $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));
            // 🔹 Share Lead Details
            $lead->share_address = "Greetings from {$businessName},\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information"
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . "{$profileUrl}";

            $lead->share_service = "Greetings from {$businessName},\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information of the services offered by our business please refer "
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . ", Or {$profileUrl}";
            $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information about the services offered by our business"
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . ". Or visit our profile: {$profileUrl}";


            $frmcheckText = '';

            if (!empty($lead->frmcheck)) {
                $frmcheckArray = is_array($lead->frmcheck)
                    ? $lead->frmcheck
                    : json_decode($lead->frmcheck, true);
                if (is_array($frmcheckArray)) {
                    $frmcheckText = implode(', ', $frmcheckArray);
                }
            }

           
            $parts = array_filter([
            $lead->kw_text   ? '<strong>Interested in</strong> ' . e($lead->kw_text)   : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"        : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"          : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"               : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                 : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"   : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

      
            return $lead;
        });

//  dd($leads->getCollection());
 return view('business.business.archived', array_merge($this->common(), [
        'leads'      => $leads,
        'team'       => $team,
        'tab'       => $tab,
        'statues'       => $statues,
        'followups'  => $followups,
        'statusCounts' => $finalCounts,   // available if you want to show a status summary widget
        'filter'     => $filter,
    ]));

}elseif($tab == "favorites"){


       
    $leads = DB::table('leads as leads');
			$leads = $leads->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');
			
			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			 
			$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'Meeting Close' || `name` LIKE 'Sales Close' || `name` LIKE 'Joined')";
					 
			$leads = $leads->join(DB::raw('('.$rawQuery.') as fu'),'leads.id','=',DB::raw('`fu`.`lead_id`'));
			// generating raw query to make join
			
			$leads = $leads->select('leads.*','assigned_leads.*','assigned_leads.id as assign_id','assigned_leads.created_at as createdAt',DB::raw('`fu`.`status_name`'),DB::raw('`fu`.`status`'),DB::raw('`fu`.`expected_date_time`'),DB::raw('`fu`.`remark`'));
			$leads = $leads->orderBy('assigned_leads.id','desc');
		 
		 
			$leads = $leads->where('assigned_leads.client_id', $clientID);
			$leads = $leads->where('assigned_leads.favorite_lead', '1');
				 
			$leads = $leads->paginate(25);
 
    $businessName = $clientDetails->business_name ?? 'Our Company';
    $address      = $clientDetails->address ?? '';
    $map          = $clientDetails->business_map ?? '';
    $profileUrl   = url('businessdetails/' . ($clientDetails->business_slug ?? ''));

    // Transform Data (Fast Way) — now returns the exact shape leads.blade.php expects
    $leads->getCollection()->transform(function ($lead) use (
        $businessName, $address, $map, $profileUrl, $avgRating, $ratingCount, $statusBucketMap
    ) {
        $keyword  = $lead->kw_text ?? 'your enquiry';
        $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));

        // FIX: was $addressText (undefined) — now uses $address, defined above
        $lead->share_address = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . "{$profileUrl}";

        $lead->share_service = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information of the services offered by our business please refer "
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ", Or {$profileUrl}";

        $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information about the services offered by our business"
            . (!empty($address) ? ", you can visit us at {$address}" : "")
            . ". Or visit our profile: {$profileUrl}";

        $frmcheckText = '';
        if (!empty($lead->frmcheck ?? null)) {
            $frmcheckArray = is_array($lead->frmcheck) ? $lead->frmcheck : json_decode($lead->frmcheck, true);
            if (is_array($frmcheckArray)) {
                $frmcheckText = implode(', ', $frmcheckArray);
            }
        }

        $parts = array_filter([
            $lead->kw_text   ? '<strong>Interested in</strong> ' . e($lead->kw_text)   : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"        : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"          : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"               : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                 : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"   : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

        // ── Reshape into the array keys leads.blade.php actually reads ──
        return [
            'assignId'            => $lead->assign_id,       // use assigned_leads.id: the per-client record the update routes act on
            'lead_id'       => $lead->lead_id,         // keep raw lead id too, for follow-up joins
            'clientId'       => $lead->client_id,         // keep raw lead id too, for follow-up joins
            'customerName'  => $lead->name,
            'phone'         => $lead->mobile,
            'email'         => $lead->email,
            'readLead'      => $lead->readLead,
            'service'       => $keyword,
            'message'       => $lead->remarks,
            'followDate'       => $lead->expected_date_time,
            'status'        => $statusBucketMap[$lead->status_name] ?? 'new',   // bucketed, for filter tabs
            'status_label'  => $lead->status_name ?? 'New Lead',                // real granular label, for the badge
            'favorite'      => $lead->favorite_lead,
            'archived'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'scrapLead'      => $lead->scrapLead,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'coins'            => $lead->coins,                        // scrapLead doubles as "archived" — rename the column if that's not accurate
            'createdAt'     => $lead->createdAt,
            'assignedTo'    => $lead->clientId ?? null,
            'share_address' => $lead->share_address,
            'share_service' => $lead->share_service,
            'share_review'  => $lead->share_review,
            'share_lead'    => $lead->share_lead,
        ];
    });

 return view('business.business.favorites', array_merge($this->common(), [
        'leads'      => $leads,
        'team'       => $team,
        'tab'       => $tab,
        'statues'       => $statues,
        'followups'  => $followups,
        'statusCounts' => $finalCounts,   // available if you want to show a status summary widget
        'filter'     => $filter,
    ]));

}elseif($tab == "manage-enquiry"){

$clientID = auth()->guard('clients')->user()->id;
  

        // 🔹 Filter inputs from the form
        $dateFrom = $request->query('date_from');
        $dateTo   = $request->query('date_to');
        $statusId = $request->query('status');
        $member   = $request->query('member', '');
    // dd($dateFrom);
    $rating = DB::table('comments')
        ->where('comment_client_ID', $clientID)
        ->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
        ->first();

    $avgRating   = ($rating->total > 0) ? round($rating->sum / $rating->total, 1) : 0;
    $ratingCount = $rating->total ?? 0;

    $followups = DB::table('lead_follow_ups')
        ->leftJoin('status as s', 'lead_follow_ups.status', '=', 's.id')
        ->where('lead_follow_ups.client_id', $clientID)
        ->orderByDesc('lead_follow_ups.id')
        ->select(
            'lead_follow_ups.id',
            'lead_follow_ups.lead_id',
            'lead_follow_ups.remark as notes',
            's.name as outcome',
            'lead_follow_ups.expected_date_time as dueAt',
        )
        ->get()
        ->map(fn ($fu) => (array) $fu);
 
    // 🔹 Fetch client details (was missing — used below but never queried)
    $clientDetails = DB::table('clients')->where('id', $clientID)->first();

    $leadsQuery = DB::table('leads as leads')
        ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');

    // generating raw query to make join
    $rawQuery = "SELECT m1.*, m3.name as status_name FROM lead_follow_ups m1
                 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id)
                 INNER JOIN status m3 ON m1.status = m3.id
                 WHERE m2.id IS NULL";

    $rawQuery .= " AND m1.status NOT IN (
        SELECT id FROM `status`
        WHERE `name` LIKE 'Joined'
           OR `name` LIKE 'Meeting Close'
           OR `name` LIKE 'Sales Close'          
           
    )";


    if($dateFrom !=''){
        $rawQuery .= " AND DATE(m1.expected_date_time)>='".date('Y-m-d',strtotime($dateFrom))."'";
    }
    
    if($dateTo !=''){
        $rawQuery .= " AND DATE(m1.expected_date_time)<='".date('Y-m-d',strtotime($dateTo))."'";
    }
 
    // if($dateFrom =='' && $dateTo ==''){
    //     $rawQuery .= " AND DATE(m1.expected_date_time) <='".date('Y-m-d')."'";
    // }
    $leadsQuery = $leadsQuery->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

    $leadsQuery = $leadsQuery->select(
        'leads.*',
        'assigned_leads.*',
        'assigned_leads.id as assign_id',
        'assigned_leads.created_at as createdAt',
        DB::raw('`fu`.`status_name`'),
        DB::raw('`fu`.`status`'),
        DB::raw('`fu`.`expected_date_time`'),
        DB::raw('`fu`.`remark`')
    );

    $leadsQuery = $leadsQuery->where('assigned_leads.client_id', $clientID);

    // 🔹 Apply filters from the form

    if (!empty($statusId)) {
        $leadsQuery->where('fu.status', $statusId);
    }

    if (!empty($member)) {
        $leadsQuery->where('assigned_leads.member_id', $member); // adjust column name if different
    }
  


    $leadsQuery = $leadsQuery->orderBy('assigned_leads.id', 'desc');

    $leads = $leadsQuery->paginate(10)->withQueryString(); // 🔹 keeps filters in pagination links

    $businessName = $clientDetails->business_name ?? 'Our Company';
    $address      = $clientDetails->address ?? '';
    $map          = $clientDetails->business_map ?? '';
    $profileUrl   = url('business/' . ($clientDetails->business_slug ?? ''));

    // Transform Data (Fast Way)
    $leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

        $keyword  = $lead->kw_text ?? 'your enquiry';
        $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));
        $addressText = $address; // was referenced below but undefined — now bound

        $lead->share_address = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information"
            . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
            . "{$profileUrl}";

        $lead->share_service = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information of the services offered by our business please refer "
            . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
            . ", Or {$profileUrl}";

        $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information about the services offered by our business"
            . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
            . ". Or visit our profile: {$profileUrl}";

        $frmcheckText = '';
        if (!empty($lead->frmcheck)) {
            $frmcheckArray = is_array($lead->frmcheck) ? $lead->frmcheck : json_decode($lead->frmcheck, true);
            if (is_array($frmcheckArray)) {
                $frmcheckText = implode(', ', $frmcheckArray);
            }
        }

        $parts = array_filter([
            $lead->kw_text     ? '<strong>Interested in</strong> ' . e($lead->kw_text) : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"             : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"             : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"                 : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                   : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"     : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

        return $lead;
    });

    $status = Status::where('lead_filter', '1')->get();
//   dd($leads->getCollection());

    //count lead
    $leadsFollowQuery = DB::table('leads as leads')
        ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');

    // generating raw query to make join
    $rawFollowQuery = "SELECT m1.*, m3.name as status_name FROM lead_follow_ups m1
                 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id)
                 INNER JOIN status m3 ON m1.status = m3.id
                 WHERE m2.id IS NULL";

   

    $leadsFollowQuery = $leadsFollowQuery->join(DB::raw('(' . $rawFollowQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

    $leadsFollowQuery = $leadsFollowQuery->select(
        'leads.*',
        'assigned_leads.*',
        'assigned_leads.id as assign_id',
        DB::raw('`fu`.`status_name`'),
        DB::raw('`fu`.`status`'),
        DB::raw('`fu`.`expected_date_time`'),
        DB::raw('`fu`.`remark`')
    );

    $leadsFollowQuery = $leadsFollowQuery->where('assigned_leads.client_id', $clientID);

    
    $leadsFollowQuery = $leadsFollowQuery->orderBy('assigned_leads.id', 'desc');

   



$totalLeads = (clone $leadsFollowQuery)->count();

$interestedCount = (clone $leadsFollowQuery)
    ->where('fu.status_name', 'Interested')
    ->count();

$newLead = (clone $leadsFollowQuery)
    ->where('fu.status_name', 'New Lead')
    ->count();
 $follow_up = (clone $leadsFollowQuery)
    ->whereNotIn('fu.status_name', [
        'Not Interested',
        'Meeting Close',
        'Sales Close',
        'Invalid Number',
        'Joined',
    ])
    ->count();
    $currentDate = now()->format('Y-m-d');
 
 $pending = (clone $leadsFollowQuery)
    ->whereNotIn('fu.status_name', [
        'Not Interested',
        'Meeting Close',
        'Sales Close',
        'Invalid Number',
        'Joined',
    ])->whereDate('fu.expected_date_time', '<', $currentDate)
    ->count();


    $joined = (clone $leadsFollowQuery)
    ->whereIn('fu.status_name', [      
        'Meeting Close',
        'Sales Close',        
        'Joined',
    ])
    ->count();

//  dd($interestedCount);
     $followList = [
        'total_leads'    => $totalLeads,
        'new_lead'     => $newLead,
        'interested'     => $interestedCount,
        'pending'      => $follow_up,         
        'overdue'      => $pending,         
        'joined'         => $joined,
    ];

 return view('business.business.manage-enquiry', array_merge($this->common(), [
        'leads'      => $leads,
        'team'       => $team,
        'tab'       => $tab,
        'statues'       => $statues,
        'followups'  => $followups,
        'followList'  => $followList,
        'statusCounts' => $finalCounts,   // available if you want to show a status summary widget
        'filter'     => $filter,
    ]));



}


}
	
    public function leads_old(Request $r): View {
       

       // $clientID = auth()->guard('clients')->user()->id;
       $clientID = '1748';
		$statues = Status::where('lead_filter', '1')->get();
		$services = DB::table('assigned_kwds')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->select('keyword.id', 'keyword.keyword','keyword.slug')
			->orderBy('keyword.keyword', 'asc')
			->where('assigned_kwds.client_id', $clientID)
			->get();
     $rating = DB::table('comments')
    ->where('comment_client_ID', $clientID)
    ->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
    ->first();

$avgRating = ($rating->total > 0)
    ? round($rating->sum / $rating->total, 1)
    : 0;

$ratingCount = $rating->total ?? 0;

            
// 1. Get latest follow_up id per lead for this client
$latestFollowUpIds = DB::table('lead_follow_ups')
    ->select('lead_id', DB::raw('MAX(id) as max_id'))
    ->where('client_id', $clientID)
    ->groupBy('lead_id');

// 2. Main query — only join the latest follow-up row, then filter its status
$leads = DB::table('assigned_leads')
    ->join('leads', 'leads.id', '=', 'assigned_leads.lead_id')
    ->joinSub($latestFollowUpIds, 'lfu_latest', function ($join) {
        $join->on('assigned_leads.lead_id', '=', 'lfu_latest.lead_id');
    })
    ->join('lead_follow_ups as lfu', 'lfu_latest.max_id', '=', 'lfu.id')
    ->leftJoin('status as s', 'lfu.status', '=', 's.id')
    ->where('assigned_leads.client_id', $clientID)
  //  ->where('s.name', 'New Lead')   // <-- now only matches CURRENT status, not history
    ->orderBy('assigned_leads.created_at', 'desc')
    ->select(
        'leads.id as lead_id',
        'leads.name',
        'leads.mobile',
        'leads.email',
        'leads.kw_text',
        'leads.zone',
        'leads.city_name',
        'leads.plan',
        'leads.address',
        'leads.age',
        'leads.experience',
        'leads.remark',
        'assigned_leads.created_at as created',
        'assigned_leads.coins',
        'assigned_leads.readLead',
        'assigned_leads.scrapLead',
        'assigned_leads.id as assignId',
        'assigned_leads.favorite_lead',
        's.name as status_name',
        'lfu.expected_date_time as followDate'
    )
    ->paginate(300);
 
 
        $businessName = $clientDetails->business_name ?? 'Our Company';
        $address = $clientDetails->address ?? '';
        $map = $clientDetails->business_map ?? '';
        $profileUrl = url('businessdetails/' . ($clientDetails->business_slug ?? ''));

        // Transform Data (Fast Way)
        $leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

            $keyword = $lead->kw_text ?? 'your enquiry';
            $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));


            // 🔹 Share Lead Details
        


            $lead->share_address = "Greetings from {$businessName},\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information"
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . "{$profileUrl}";

            $lead->share_service = "Greetings from {$businessName},\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information of the services offered by our business please refer "
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . ", Or {$profileUrl}";
            $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
                . "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
                . "For more information about the services offered by our business"
                . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
                . ". Or visit our profile: {$profileUrl}";


            $frmcheckText = '';

            if (!empty($lead->frmcheck)) {
                $frmcheckArray = is_array($lead->frmcheck)
                    ? $lead->frmcheck
                    : json_decode($lead->frmcheck, true);
                if (is_array($frmcheckArray)) {
                    $frmcheckText = implode(', ', $frmcheckArray);
                }
            }

            $parts = array_filter([
                $lead->kw_text ? "Interested in {$lead->kw_text}" : '',
                $frmcheckText ? "Mode of {$frmcheckText}" : '',
                $lead->zone ? "Location {$lead->zone}" : '',
                $lead->plan ? "Plan {$lead->plan}" : '',
                $lead->age ? "Age {$lead->age}" : '',
                $lead->experience ? "Experience {$lead->experience}" : '',
            ]);

            $remark = implode(" • ", $parts);

            if (!empty($lead->remark)) {
                $remark .= " " . trim($lead->remark);
            }

        $lead->share_lead =
        "Name: {$lead->name}\n" .
        "Mobile: {$lead->mobile}\n" .
        "Email: {$lead->email}\n" .
        "Service: {$keyword}\n" .
        "Location: {$location}\n" .
        "remark: {$remark}";

            $lead->remarks = $remark;
            return $lead;
        });

	 
 
	  // 1. Latest follow-up per lead
$latestFollowUpsSub = DB::table('lead_follow_ups')
    ->select('lead_id', DB::raw('MAX(id) as max_id'))
    ->where('client_id', $clientID)
    ->groupBy('lead_id');

$latestFollowUps = DB::table('lead_follow_ups as lf1')
    ->joinSub($latestFollowUpsSub, 'lf2', function ($join) {
        $join->on('lf1.id', '=', 'lf2.max_id');
    })
    ->leftJoin('status as s', 'lf1.status', '=', 's.id')   // <-- join lookup table
    ->where('lf1.client_id', $clientID)
    ->select('lf1.lead_id', 's.name as status','lf1.expected_date_time');           // <-- pull the NAME, not the id

// 2. Status counts — ONE status column only
$statusCounts = DB::table('assigned_leads')
    ->leftJoinSub($latestFollowUps, 'lfu', function ($join) {
        $join->on('assigned_leads.lead_id', '=', 'lfu.lead_id');
    })
    ->where('assigned_leads.client_id', $clientID)
    ->select(
        DB::raw("COALESCE(lfu.status, 'New Lead') as status"),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy(DB::raw("COALESCE(lfu.status, 'New Lead')"))
    ->pluck('total', 'status');

// dd($statusCounts); // uncomment to inspect raw counts

// 3. Normalize so all 8 labels always show, even with 0 leads
$statusLabels = ['New Lead', 'Interested', 'Not Interested', 'Follow Up', 'NPUP', 'Not Connected','Visited','Sales Close', 'Call Later', 'Joined','Meeting','Invalid Number','Switched Off'];

$finalCounts = collect($statusLabels)->mapWithKeys(function ($label) use ($statusCounts) {
    return [$label => $statusCounts[$label] ?? 0];
});

// dd($leads->getCollection());
    return view('business.business.leads',array_merge($this->common(),
    
    ['leads'=>$leads,'team'=>DemoStore::get('team'),
    
    'followups'=>DemoStore::get('followups'),'filter'=>$r->query('filter','all')])); 
    
    }
    
    
    
    public function updateLead(Request $r,int $id): RedirectResponse { DemoStore::updateItem('leads',$id,$r->only(['status','assignedTo','favorite','archived'])); return back()->with('success','Lead updated successfully.'); }
    
    public function addFollowUp(Request $request, int $id): JsonResponse|RedirectResponse
    {
        // Temporary
        $clientId = 1748;

        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'status' => 'required|exists:status,id',
                'remark' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Get status
            |--------------------------------------------------------------------------
            */

            $status = Status::find($request->status);

            if (!$status) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Expected date validation
            |--------------------------------------------------------------------------
            */

            if ($status->show_exp_date) {

                $validator = Validator::make($request->all(), [
                    'expected_date_time' => 'required|date',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Expected date is required.',
                        'errors'  => $validator->errors(),
                    ], 422);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Find Lead
            |--------------------------------------------------------------------------
            */

            // Use route ID instead of request lead_id
            $lead = Lead::find($request->lead_id);

            if (!$lead) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enquiry not found.',
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | Create Follow Up
            |--------------------------------------------------------------------------
            */

            $leadFollowUp = new LeadFollowUp();

            /*
            |--------------------------------------------------------------------------
            | NPUP check
            |--------------------------------------------------------------------------
            */

            if (strcasecmp($status->name, 'npup') === 0) {

                $npupCount = LeadFollowUp::where('lead_id', $request->lead_id)
                    ->where('client_id', $clientId)
                    ->where('status', $status->id)
                    ->count();

                if ($npupCount >= 15) {

                    $notInterestedStatus = Status::where('name', 'Not Interested')->first();

                    if ($notInterestedStatus) {
                        $leadFollowUp->status = $notInterestedStatus->id;
                    } else {
                        $leadFollowUp->status = $status->id;
                    }

                } else {
                    $leadFollowUp->status = $status->id;
                }

            } else {

                $leadFollowUp->status = $status->id;
            }

            /*
            |--------------------------------------------------------------------------
            | Save data
            |--------------------------------------------------------------------------
            */

            $leadFollowUp->lead_id   = $request->lead_id;
            $leadFollowUp->client_id = $clientId;

            $leadFollowUp->remark = trim(strip_tags($request->remark));

            $leadFollowUp->expected_date_time = null;

            if ($request->filled('expected_date_time')) {
                $leadFollowUp->expected_date_time = date(
                    'Y-m-d H:i:s',
                    strtotime($request->expected_date_time)
                );
            }

            $leadFollowUp->save();

            return response()->json([
                'success' => true,
                'status'  => 1,
                'message' => 'Follow-up added successfully.',
                'data'    => $leadFollowUp,
            ], 200);
        }

        return back()->with('success', 'Follow-up added.');
    }
    
    public function addFollowUp_olddddd(Request $request,int $id): RedirectResponse { 
     //   $clientId=  auth()->guard('clients')->user()->id;
        $clientId = '1748';
    

    if ($request->ajax()) {

   // dd($request);
			$validator = Validator::make($request->all(), [

				'status' => 'required',
				'remark' => 'required',

			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			// check now expected date and time if status is not - not interested/location issue
			$statusModel = Status::find($request->input('status'));
			//if($statusModel->name!='Not Interested' && $statusModel->name!='Location Issue'){
			if ($statusModel->show_exp_date) {
				$validator = Validator::make($request->all(), [
					'expected_date_time' => 'required',
				]);
				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}
			}

			$lead = Lead::find($request->lead_id);
			if (!empty($lead)) {
				$leadFollowUp = new LeadFollowUp;
				$status = Status::findorFail($request->input('status'));
				if (!strcasecmp($status->name, 'npup')) {
					$npupCount = LeadFollowUp::where('lead_id', $request->lead_id)->where('client_id',$clientId)->where('status', $status->id)->count();
					if ($npupCount >= 15) {
						$status = Status::where('name', 'LIKE', 'Not Interested')->first();
						$leadFollowUp->status = $status->id;
					} else {
						$leadFollowUp->status = $request->input('status');
					}
				} else {
					$leadFollowUp->status = $request->input('status');
				}


				$leadFollowUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$leadFollowUp->lead_id = $request->lead_id;
				$leadFollowUp->client_id = $clientId;
				$leadFollowUp->expected_date_time = NULL;
				if ($request->input('expected_date_time') != '') {
					$leadFollowUp->expected_date_time = date('Y-m-d H:i:s', strtotime($request->input('expected_date_time')));
				}
				if ($leadFollowUp->save()) {
					return response()->json(['status' => 1], 200);
				}
			} else {

				return response()->json(['status' => 0, '' => "Enquiry not found"], 200);
			}
		}
    
 
    
   return back()->with('success','Follow-up added.'); 
    
    
    }
    public function updateFollowUp(Request $r,int $id): RedirectResponse {
        
    
    DemoStore::updateItem('followups',$id,$r->only(['done','notes','outcome','dueAt','assignedTo'])); return back()->with('success','Follow-up updated.'); 
    
    
    }
    public function deleteFollowUp(int $id): RedirectResponse { DemoStore::deleteItem('followups',$id); return back()->with('success','Follow-up removed.'); }
    
    public function followUps(Request $r): View
    {
    
        $clientID = auth()->guard('clients')->user()->id;
  

        // 🔹 Filter inputs from the form
        $dateFrom = $r->query('date_from');
        $dateTo   = $r->query('date_to');
        $statusId = $r->query('status');
        $member   = $r->query('member', '');
    // dd($dateFrom);
    $rating = DB::table('comments')
        ->where('comment_client_ID', $clientID)
        ->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
        ->first();

    $avgRating   = ($rating->total > 0) ? round($rating->sum / $rating->total, 1) : 0;
    $ratingCount = $rating->total ?? 0;

    $followups = DB::table('lead_follow_ups')
        ->leftJoin('status as s', 'lead_follow_ups.status', '=', 's.id')
        ->where('lead_follow_ups.client_id', $clientID)
        ->orderByDesc('lead_follow_ups.id')
        ->select(
            'lead_follow_ups.id',
            'lead_follow_ups.lead_id',
            'lead_follow_ups.remark as notes',
            's.name as outcome',
            'lead_follow_ups.expected_date_time as dueAt',
        )
        ->get()
        ->map(fn ($fu) => (array) $fu);
 
    // 🔹 Fetch client details (was missing — used below but never queried)
    $clientDetails = DB::table('clients')->where('id', $clientID)->first();

    $leadsQuery = DB::table('leads as leads')
        ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');

    // generating raw query to make join
    $rawQuery = "SELECT m1.*, m3.name as status_name FROM lead_follow_ups m1
                 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id)
                 INNER JOIN status m3 ON m1.status = m3.id
                 WHERE m2.id IS NULL";

    $rawQuery .= " AND m1.status NOT IN (
        SELECT id FROM `status`
        WHERE `name` LIKE 'Not Interested'
           OR `name` LIKE 'Meeting Close'
           OR `name` LIKE 'Sales Close'
           OR `name` LIKE 'Invalid Number'
           OR `name` LIKE 'Joined'
    )";


    if($dateFrom !=''){
        $rawQuery .= " AND DATE(m1.expected_date_time)>='".date('Y-m-d',strtotime($dateFrom))."'";
    }
    
    if($dateTo !=''){
        $rawQuery .= " AND DATE(m1.expected_date_time)<='".date('Y-m-d',strtotime($dateTo))."'";
    }
 
    if($dateFrom =='' && $dateTo ==''){
        $rawQuery .= " AND DATE(m1.expected_date_time) <='".date('Y-m-d')."'";
    }
    $leadsQuery = $leadsQuery->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

    $leadsQuery = $leadsQuery->select(
        'leads.*',
        'assigned_leads.*',
        'assigned_leads.id as assign_id',
        'assigned_leads.created_at as createdAt',
        DB::raw('`fu`.`status_name`'),
        DB::raw('`fu`.`status`'),
        DB::raw('`fu`.`expected_date_time`'),
        DB::raw('`fu`.`remark`')
    );

    $leadsQuery = $leadsQuery->where('assigned_leads.client_id', $clientID);

    // 🔹 Apply filters from the form

    if (!empty($statusId)) {
        $leadsQuery->where('fu.status', $statusId);
    }

    if (!empty($member)) {
        $leadsQuery->where('assigned_leads.member_id', $member); // adjust column name if different
    }
  


    $leadsQuery = $leadsQuery->orderBy('assigned_leads.id', 'desc');

    $leads = $leadsQuery->paginate(25)->withQueryString(); // 🔹 keeps filters in pagination links

    $businessName = $clientDetails->business_name ?? 'Our Company';
    $address      = $clientDetails->address ?? '';
    $map          = $clientDetails->business_map ?? '';
    $profileUrl   = url('business/' . ($clientDetails->business_slug ?? ''));

    // Transform Data (Fast Way)
    $leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

        $keyword  = $lead->kw_text ?? 'your enquiry';
        $location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));
        $addressText = $address; // was referenced below but undefined — now bound

        $lead->share_address = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information"
            . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
            . "{$profileUrl}";

        $lead->share_service = "Greetings from {$businessName},\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information of the services offered by our business please refer "
            . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
            . ", Or {$profileUrl}";

        $lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
            . "We're following up on your enquiry made on Quickdials for {$keyword}.\n"
            . "For more information about the services offered by our business"
            . (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
            . ". Or visit our profile: {$profileUrl}";

        $frmcheckText = '';
        if (!empty($lead->frmcheck)) {
            $frmcheckArray = is_array($lead->frmcheck) ? $lead->frmcheck : json_decode($lead->frmcheck, true);
            if (is_array($frmcheckArray)) {
                $frmcheckText = implode(', ', $frmcheckArray);
            }
        }

        $parts = array_filter([
            $lead->kw_text     ? '<strong>Interested in</strong> ' . e($lead->kw_text) : '',
            $frmcheckText      ? "<strong>Mode of</strong> {$frmcheckText}"             : '',
            $lead->zone        ? "<strong>Location:</strong> {$lead->zone}"             : '',
            $lead->plan        ? "<strong>Plan:</strong> {$lead->plan}"                 : '',
            $lead->age         ? "<strong>Age:</strong> {$lead->age}"                   : '',
            $lead->experience  ? "<strong>Experience:</strong> {$lead->experience}"     : '',
        ]);

        $remark = implode(" , ", $parts);
        if (!empty($lead->remark)) {
            $remark .= '<br>' . trim($lead->remark);
        }

        $lead->share_lead = "Name: {$lead->name}\n"
            . "Mobile: {$lead->mobile}\n"
            . "Email: {$lead->email}\n"
            . "Service: {$keyword}\n"
            . "Location: {$location}\n"
            . "remark: {$remark}";

        $lead->remarks = $remark;

        return $lead;
    });

    $status = Status::where('lead_filter', '1')->get();
//   dd($leads->getCollection());


    //count lead
    $leadsFollowQuery = DB::table('leads as leads')
        ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');

    // generating raw query to make join
    $rawFollowQuery = "SELECT m1.*, m3.name as status_name FROM lead_follow_ups m1
                 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id)
                 INNER JOIN status m3 ON m1.status = m3.id
                 WHERE m2.id IS NULL";

   

    $leadsFollowQuery = $leadsFollowQuery->join(DB::raw('(' . $rawFollowQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

    $leadsFollowQuery = $leadsFollowQuery->select(
        'leads.*',
        'assigned_leads.*',
        'assigned_leads.id as assign_id',
        DB::raw('`fu`.`status_name`'),
        DB::raw('`fu`.`status`'),
        DB::raw('`fu`.`expected_date_time`'),
        DB::raw('`fu`.`remark`')
    );

    $leadsFollowQuery = $leadsFollowQuery->where('assigned_leads.client_id', $clientID);

    
    $leadsFollowQuery = $leadsFollowQuery->orderBy('assigned_leads.id', 'desc');

   



$totalLeads = (clone $leadsFollowQuery)->count();

$interestedCount = (clone $leadsFollowQuery)
    ->where('fu.status_name', 'Interested')
    ->count();

$newLead = (clone $leadsFollowQuery)
    ->where('fu.status_name', 'New Lead')
    ->count();
 $follow_up = (clone $leadsFollowQuery)
    ->whereNotIn('fu.status_name', [
        'Not Interested',
        'Meeting Close',
        'Sales Close',
        'Invalid Number',
        'Joined',
    ])
    ->count();
    $currentDate = now()->format('Y-m-d');
 
 $pending = (clone $leadsFollowQuery)
    ->whereNotIn('fu.status_name', [
        'Not Interested',
        'Meeting Close',
        'Sales Close',
        'Invalid Number',
        'Joined',
    ])->whereDate('fu.expected_date_time', '<', $currentDate)
    ->count();


    $joined = (clone $leadsFollowQuery)
    ->whereIn('fu.status_name', [      
        'Meeting Close',
        'Sales Close',        
        'Joined',
    ])
    ->count();

//  dd($interestedCount);
     $followList = [
        'total_leads'    => $totalLeads,
        'new_lead'     => $newLead,
        'interested'     => $interestedCount,
        'pending'      => $follow_up,         
        'overdue'      => $pending,         
        'joined'         => $joined,
    ];
// dd($followList['total_leads']);

    return view('business.business.follow-ups', array_merge($this->common(), [
        'followups' => $followups,
        'leads'     => $leads,
        'team'      => DemoStore::get('team'),
        'statues'    => $status,
        'member'    => $member,
        'dateFrom'  => $dateFrom,
        'dateTo'    => $dateTo,
        'followList'    => $followList,
        'statusId'  => $statusId,
    ]));
}
    
 
    public function listings(): View { return view('business.business.listings',array_merge($this->common(),['listings'=>DemoStore::get('listings')])); }
    public function addListing(Request $r): RedirectResponse { $v=$r->validate(['title'=>'required|string|max:120','category'=>'required|string|max:80','description'=>'required|string|max:500']); DemoStore::addItem('listings',array_merge($v,['status'=>'active','views'=>0,'leads'=>0,'createdAt'=>now()->toDateTimeString()])); return back()->with('success','Listing created.'); }
    public function updateListing(Request $r,int $id): RedirectResponse { DemoStore::updateItem('listings',$id,$r->only(['title','category','description','status'])); return back()->with('success','Listing updated.'); }
    public function deleteListing(int $id): RedirectResponse { DemoStore::deleteItem('listings',$id); return back()->with('success','Listing deleted.'); }
    public function reviews(Request $request): View { 
        
    // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
			$reviews = DB::table('comments');
			 
			$reviews = $reviews->orderBy('comment_ID','desc')
			->where('comment_client_ID',$clientID)->get();
			// ->paginate($request->input('length'));

// dd($reviews);
    return view('business.business.reviews',array_merge($this->common(),
    
    ['reviews'=>$reviews])
    
    ); 
    
    
    
    }
    public function pendingProfile(Request $request): View { 
        
    // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
			$reviews = DB::table('comments');
			 
			$reviews = $reviews->orderBy('comment_ID','desc')
			->where('comment_client_ID',$clientID)->get();
			// ->paginate($request->input('length'));

// dd($reviews);
    return view('business.business.pending-profile',array_merge($this->common(),
    
    ['reviews'=>$reviews])
    
    ); 
    
    
    
    }
    public function replyReview(Request $r,int $id): RedirectResponse { $v=$r->validate(['reply'=>'required|string|max:600']); DemoStore::updateItem('reviews',$id,$v); return back()->with('success','Reply posted.'); }
    public function team(): View {



		return view('business.business.team',array_merge($this->common(),['team'=>DemoStore::get('team')])); 
		
		
		
		}


        /**
 * Returns follow-up history for one lead as JSON, for the popup's datatable.
 * GET /leads/{leadId}/follow-ups/list?limit=5|all
 */
public function followUpsList(Request $r, int $leadId)
{
    // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
 
    $query = DB::table('lead_follow_ups')
        ->leftJoin('status as s', 'lead_follow_ups.status', '=', 's.id')
        ->where('lead_follow_ups.client_id', $clientID)
        ->where('lead_follow_ups.lead_id', $leadId)   
        ->whereNotNull('lead_follow_ups.remark')
        ->where('lead_follow_ups.remark', '!=', '')
        ->orderByDesc('lead_follow_ups.id')
        ->select(
            'lead_follow_ups.id',
            'lead_follow_ups.remark as notes',
            's.name as status',
            'lead_follow_ups.expected_date_time',
            'lead_follow_ups.created_at'
        );

    $limit = $r->query('limit', '5');
    if ($limit !== 'all') {
        $query->limit((int) $limit);
    }

    $followups = $query->get()->map(fn ($fu) => [
        'id'            => $fu->id,
        'date'          => $fu->created_at ? \Carbon\Carbon::parse($fu->created_at)->format('M j, Y g:i A') : null,
        'notes'         => $fu->notes,
        'status'        => $fu->status,
        'expected_date' => $fu->expected_date_time ? \Carbon\Carbon::parse($fu->expected_date_time)->format('M j, Y g:i A') : null,
    ]);
 
    return response()->json($followups);
}
    public function addMember(Request $r): RedirectResponse { $v=$r->validate(['name'=>'required|string|max:100','email'=>'required|email','phone'=>'nullable|string|max:30','role'=>'required|in:agent,manager']); DemoStore::addItem('team',array_merge($v,['active'=>true])); return back()->with('success','Team member added.'); }
    public function updateMember(Request $r,int $id): RedirectResponse { DemoStore::updateItem('team',$id,$r->only(['active','name','email','phone','role'])); return back()->with('success','Team member updated.'); }
    public function deleteMember(int $id): RedirectResponse { DemoStore::deleteItem('team',$id); return back()->with('success','Team member removed.'); }


    public function profile(Request $request,$tab='general'): View { 
          
    if(request()->segment(3)){
    $tab = request()->segment(3);
    }else{

  $tab= 'general';
    }

    $allowed=['general','personal','seo','keywords','locations','media','awards','certs','socials','recent','faqs']; abort_unless(in_array($tab,$allowed,true),404);

   
    
   // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
    $states = State::where('country_id', '101')->get();
    $client = Client::find($clientID);
if( $tab == "general"){
    return view('business.business.profile',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 

}elseif($tab == "personal"){
 return view('business.business.personal-details',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 

}elseif($tab == "seo"){
 return view('business.business.business-meta',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 


}elseif($tab == "keywords"){


// $clientID = auth()->guard('clients')->user()->id;
$clientID = '1748';
$keywordlist = Keyword::whereNotExists(function ($query) use ($clientID) {
        $query->select(DB::raw(1))
            ->from('assigned_kwds')
            ->whereColumn('assigned_kwds.kw_id', 'keyword.id')
            ->where('assigned_kwds.client_id', $clientID);
    })->get();


    // $clientID = auth()->guard('clients')->user()->id;
			$assignKeywords = DB::table('assigned_kwds')
			//	->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->select('assigned_kwds.*','parent_category.parent_category', 'child_category.child_category', 'keyword.keyword','keyword.slug')
				->orderBy('assigned_kwds.created_at', 'desc')
				->where('assigned_kwds.client_id', $clientID)
				->get();
 return view('business.business.keywords',array_merge($this->common(),['tab'=>$tab,'keywordlist'=>$keywordlist,'assignKeywords'=>$assignKeywords,'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 


}elseif($tab == "locations"){


// $clientID = auth()->guard('clients')->user()->id;
$clientID = '1748';
 
 
    $assignedZone = DB::table('assigned_zones');
    $assignedZone = $assignedZone->join('zones','assigned_zones.zone_id','=','zones.id')
    ->join('citylists','assigned_zones.city_id','=','citylists.id')			 
    ->select('assigned_zones.*','citylists.city','zones.zone','assigned_zones.id as assign_id')
    ->orderBy('assigned_zones.id','desc')
    ->where('assigned_zones.client_id',$clientID)

     ->latest('assign_id')
        ->paginate(10)
        ->withQueryString();
  
					   
//   dd($assignedZone->getCollection());

 return view('business.business.location-service',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>$assignedZone,'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 


}elseif($tab == "media"){


 return view('business.business.media-gallery',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 


}elseif($tab == "awards"){
 return view('business.business.award',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 


}elseif($tab == "certs"){
 return view('business.business.certificates',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 
}elseif($tab == "socials"){
 return view('business.business.socials',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 

}elseif($tab == "recent"){
 return view('business.business.recent-activity',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 
}elseif($tab == "faqs"){

 return view('business.business.business-faqs',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 
} 



    }
    public function personalDetails(Request $request): View { 
        
    
    // $allowed=['general','personal','seo','keywords','locations','media','awards','certs','socials']; abort_unless(in_array($tab,$allowed,true),404);

    $tab = "personal";

   // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
    $states = State::where('country_id', '101')->get();
    $client = Client::find($clientID);

    return view('business.business.personal-details',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 
    
    
    }




    public function profile_old(string $tab='general'): View { 
        
    
    $allowed=['general','personal','seo','keywords','locations','media','awards','certs','socials']; abort_unless(in_array($tab,$allowed,true),404);
   // $clientID = auth()->guard('clients')->user()->id;
    $clientID = '1748';
    $states = State::where('country_id', '101')->get();
    $client = Client::find($clientID);

    return view('business.business.profile',array_merge($this->common(),['tab'=>$tab,'keywords'=>DemoStore::get('keywords'),'states'=>$states,'client'=>$client,'locations'=>DemoStore::get('locations'),'gallery'=>DemoStore::get('gallery'),'awards'=>DemoStore::get('awards'),'certificates'=>DemoStore::get('certificates')])); 
    
    
    }



    public function updateProfile(Request $r): RedirectResponse { 
        
    
    $data=$r->except(['_token','_method','redirect_tab']);
    
   
    DemoStore::put('profile',array_merge(DemoStore::get('profile'),$data)); 
    
    return redirect()->route('profile',['tab'=>$r->input('redirect_tab','general')])->with('success','Business profile saved.');
    
    
    }
    public function addKeyword(Request $r): RedirectResponse { $v=$r->validate(['keyword'=>'required','parentCategory'=>'required','childCategory'=>'required']); DemoStore::addItem('keywords',$v); return back()->with('success','Keyword added.'); }
    public function deleteKeyword(int $id): RedirectResponse { DemoStore::deleteItem('keywords',$id); return back()->with('success','Keyword deleted.'); }
    public function addLocation(Request $r): RedirectResponse { $v=$r->validate(['state'=>'required','city'=>'required','area'=>'required']); DemoStore::addItem('locations',$v); return back()->with('success','Service area added.'); }
    public function deleteLocation(int $id): RedirectResponse { DemoStore::deleteItem('locations',$id); return back()->with('success','Service area deleted.'); }
    public function addGallery(Request $r): RedirectResponse { $v=$r->validate(['url'=>'required|string','caption'=>'nullable|string']); DemoStore::addItem('gallery',$v); return back()->with('success','Gallery image added.'); }
    public function deleteGallery(int $id): RedirectResponse { DemoStore::deleteItem('gallery',$id); return back()->with('success','Gallery image deleted.'); }
    public function addAward(Request $r): RedirectResponse { $v=$r->validate(['name'=>'required|string','imageUrl'=>'nullable|string']); DemoStore::addItem('awards',$v); return back()->with('success','Award added.'); }
    public function deleteAward(int $id): RedirectResponse { DemoStore::deleteItem('awards',$id); return back()->with('success','Award deleted.'); }
    public function updateCertificates(Request $r): RedirectResponse { DemoStore::put('certificates',$r->except(['_token','_method'])); return back()->with('success','Certificates saved.'); }
    
    	function dataEncodeJsonBase64($o){
				$o = json_encode($o);
				$o = base64_encode($o);
				return $o;
	}
	function dataDecodeJsonBase64($o){
				$o = base64_decode($o);
				$o = json_decode($o); 
				
				return $o;
	}
    public function account(string $tab='settings'): View { 
        
    
    $allowed=['settings','package','invoices','coins_history','transactions']; abort_unless(in_array($tab,$allowed,true),404); 
    	// $clientID = auth()->guard('clients')->user()->id;
        $clientID = "1748";
		$client = Client::find($clientID);
    $data = [];

		$common = [
			'business_name' => trim($client->business_name),
			'customer_name' => trim($client->sirName).' '.$client->first_name.' '.$client->last_name,
			'email'         => trim($client->email),
			'phone'         => $client->mobile,
			'country'       => $client->country,
			'state'         => $client->state,
			'city'          => $client->city,
			'client_id'     => $client->id,
			'username'      => $client->username,
			'tds_status'    => 'No',
			'tds_amount'    => '0',
		];

		$packages = [
			'coins_1000'  => [1000, 1111], //0.90
			'coins_2000'  => [2000, 2272],//0.89
			'coins_3000'  => [3000, 3529],//0.86
			'coins_5000'  => [5000, 6099], //0.84
			'coins_10000' => [10000, 12500],//0.78
			'coins_20000' => [20000, 27777],//0.72
			'coins_40000' => [40000, 57777],//0.70
			'coins_50000' => [50000, 76923],//0.66
		];

		/* ✅ Free Package */
		if ($client->coins_free == '0') {
			$free = array_merge($common, [
				'amt' => 0,
				'gst_status' => 'No',
				'gst_tax' => '0',
				'gst_total_amount' => '0',
				'total_amount' => '0',
				'coins' => 555,
				'package' => 'Free Package',
				'package_bottom' => "Free Package",
			]);

			$free['encrypt'] = $this->dataEncodeJsonBase64($free);
			$data['coins_free'] = $free;
		}

		/* ✅ Paid Packages */
		foreach ($packages as $key => [$amount, $coins]) {

			$gst = round($amount * 0.18);

			$item = array_merge($common, [
				'amt' => $amount,
				'gst_status' => 'yes',
				'gst_tax' => $gst,
				'gst_total_amount' => $amount + $gst,
				'total_amount' => $amount + $gst,
				'coins' => $coins,
				'package' => "{$amount} Rs to {$coins} Coins",
				'package_bottom' => "Buy Package",
			]);

			$item['encrypt'] = $this->dataEncodeJsonBase64($item);
			$data[$key] = $item;
		}

$coinsLeads = DB::table('assigned_leads')
			->join('leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
			->leftjoin('keyword', 'assigned_leads.kw_id', '=', 'keyword.id')

			->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created', 'assigned_leads.coins', 'assigned_leads.scrapLead')

			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.client_id', $clientID) ->paginate(10)
                ->withQueryString();

                // dd($coinsLeads->getCollection());
            $invoices = PaymentHistory::where('client_id', $clientID)
				->orderBy('created_at', 'desc')
				 ->paginate(10)
                ->withQueryString();
$transactions = [];
    return view('business.business.account',array_merge($this->common(),['tab'=>$tab,'data'=>$data,'invoices'=>$invoices,'coinUsage'=>$coinsLeads,'transactions'=>$transactions])); 
    
    
    
    
    
    }


    public function updateAccount(Request $r): RedirectResponse { DemoStore::put('account',array_merge(DemoStore::get('account'),$r->except(['_token','_method']))); return back()->with('success','Account setting updated.'); }
    public function buyPackage(Request $r): RedirectResponse { $v=$r->validate(['coins'=>'required|integer|min:1','amount'=>'required|integer|min:1','name'=>'required|string']); $a=DemoStore::get('account'); $a['coins']+=(int)$v['coins']; $a['packageName']=$v['name']; DemoStore::put('account',$a); DemoStore::addItem('transactions',['type'=>'purchase','description'=>'Purchased '.number_format($v['coins']).' coins package','amount'=>(int)$v['coins'],'createdAt'=>now()->toDateTimeString()]); $gst=(int)round($v['amount']*.18); DemoStore::addItem('invoices',['paidAmount'=>(int)$v['amount'],'gst'=>$gst,'totalAmount'=>(int)$v['amount']+$gst,'createdAt'=>now()->toDateTimeString()]); return back()->with('success','Package purchased and coins added.'); }
    public function invoice(int $id) { $invoice=collect(DemoStore::get('invoices'))->firstWhere('id',$id); abort_unless($invoice,404); $html=view('business.business.invoice',array_merge($this->common(),compact('invoice')))->render(); return response($html)->header('Content-Type','text/html')->header('Content-Disposition','attachment; filename="invoice-'.$id.'.html"'); }
    public function contact(): View { return view('business.business.contact',$this->common()); }
    public function reset(): RedirectResponse { DemoStore::reset(); return redirect()->route('dashboard')->with('success','Demo data reset.'); }
    public function signOut(): RedirectResponse { return back()->with('success','You have been signed out. See you soon!'); }




public function success(Request $request)
	{
	 
		$data = $request->order_id;	
	 
		if (!$request->filled('order_id')) {
			abort(400, 'Order ID missing');
		}
 	 
		$paymentHistory = PaymentHistory::where('order_number', $request->order_id)->first();

		if ($paymentHistory) {
			$check = $paymentHistory->update([
				'invoice_status' => '1'				 
			]);	 
		}
 
		return view('business.razorpay.success',array_merge($this->common(), [
			'data' => $data,
			'paymentHistory' => $paymentHistory
		]));
	}


	public function failed(Request $request)
	{
            $data = $request->order_id;	
	 
		if (!$request->filled('order_id')) {
			abort(400, 'Order ID missing');
		}
 	 
		$paymentHistory = PaymentHistory::where('order_number', $request->order_id)->first();

		if ($paymentHistory) {
			$check = $paymentHistory->update([
				'invoice_status' => '0'				 
			]);	 
		}
 
		return view('business.razorpay.failed',array_merge($this->common(), [
			'data' => $data,
			'paymentHistory' => $paymentHistory
		]));
	}









}
