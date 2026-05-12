<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BusinessDashboardController extends Controller
{
    protected $danger_msg = '';
    protected $success_msg = '';
    protected $warning_msg = '';
    protected $info_msg = '';
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $client = auth()->guard('clients')->user();
 
        if (!$client) {
            return redirect()->route('login');
        }

        $clientID = $client->id;

        $clientDetails = DB::table('clients')
            ->where('id', $clientID)
            ->first();

        $rating = DB::table('comments')
            ->where('comment_client_ID', $client->id)
            ->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
            ->first();

        $avgRating = ($rating->total > 0)
            ? round($rating->sum / $rating->total, 1)
            : 0;

        $ratingCount = $rating->total ?? 0;

        $leads = DB::table('leads')
            ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
            ->where('assigned_leads.client_id', $client->id)
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
                'assigned_leads.favorite_lead'
               
            )
            ->paginate(30);

        $businessName = $clientDetails->business_name ?? 'Our Company';
        $address = $clientDetails->address ?? '';
        $map = $clientDetails->business_map ?? '';
        $profileUrl = url('business-details/' . ($clientDetails->business_slug ?? ''));

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

 
 


        // dd($leads_list);
        return view('business.dashboard', [
            'leads' => $leads,
            'clientDetails' => $clientDetails,
            'avgRating' => $avgRating,
            'ratingCount' => $ratingCount
        ]);
    }




    public function dashboard_old()
    {
        $clientID = auth()->guard('clients')->user()->id;
        $clientDetails = DB::table('clients')->where('id', $clientID)->first();
        $leads = DB::table('leads')
            ->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
            ->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
            ->leftjoin('areas', 'leads.area_id', '=', 'areas.id')
            ->leftjoin('zones', 'leads.zone_id', '=', 'zones.id')
            ->select('leads.*', 'assigned_leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created', 'areas.area', 'zones.zone')

            ->orderBy('assigned_leads.created_at', 'desc')
            ->where('assigned_leads.client_id', $clientID)->get();
        return view('business.dashboard', ['leads' => $leads, 'clientDetails' => $clientDetails]);
    }

}
