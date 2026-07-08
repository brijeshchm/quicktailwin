<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Models\Client\Client; //model
use Validator;
use Illuminate\Support\Facades\Input;
use Image;
use DB;
use Mail;
use Excel;
use session;
use App\Http\Controllers\SitemapsController as SMC;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Zone;
use App\Models\Lead;
use App\Models\User;
use App\Models\Keyword;
use App\Models\Redemption;
use App\Models\LeadFollowUp;
use App\Models\Status;
use App\Models\AssignedLead;
use App\Models\AssigneddArea;
use App\Models\Citieslists;
use App\Models\AssignedZone;
use App\Models\State;
use App\Models\Occupation;

use Spatie\PdfToImage\Pdf;

class RewardsController extends Controller
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

 
	public function getBusinessRewardsDashboard(Request $request)
	{		 
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);



		  $business = Auth::user(); // change to Auth::user()->business if you have a separate Business model
 
    
 
        // ---- Stats ----
        // $totalRevenue = Lead::where('business_id', $businessId)
        //     ->where('status', 'completed')
        //     ->orWhere('status', 'reviewed')
        //     ->sum('cost');
		$totalRevenue = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID)->where('status', 'completed')
            ->orWhere('status', 'reviewed')->sum('cost');

 
        $rewardBalance = $business->reward_balance ?? 0; // adjust to your wallet/coins column
 
        // $completedEnquiries = Lead::where('business_id', $businessId)
        //     ->whereIn('status', ['completed', 'reviewed'])
        //     ->count();
 		$completedEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->whereIn('status', ['completed', 'reviewed'])->count();
       

		$pendingEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->where('status', 'pending')->count();
 
		$averageRating = 0;

		$recentEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.cost as assign_cost','assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->take(5)->get();
  

		$allEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id','assigned_leads.status as assign_status', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->latest()->get();

//  dd($allEnquiries);
        $pendingList = $allEnquiries->where('status', 'pending')->values();
        $activeList  = $allEnquiries->where('status', 'accepted')->values();
 
        // ---- Redemptions (reward bookings) ----
        $allRedemptions = Redemption::where('business_id', $clientID)
            ->with('customer')
            ->latest()
            ->get();
 
        $rewardPendingList  = $allRedemptions->where('status', 'pending')->values();
        $rewardAwaitingList = $allRedemptions->where('status', 'completed')->values();
 
        return view('business.rewards-dashboard', [
            'totalRevenue'        => $totalRevenue,
            'rewardBalance'       => $rewardBalance,
            'averageRating'       => $averageRating,
            'completedEnquiries'  => $completedEnquiries,
            'pendingEnquiries'    => $pendingEnquiries,
            'recentEnquiries'     => $recentEnquiries,
            'pendingList'         => $pendingList,
            'activeList'          => $activeList,
            'rewardPendingList'   => $rewardPendingList,
            'rewardAwaitingList'  => $rewardAwaitingList,
        ]);



		 
	}


  /**
     * Accept an enquiry (pending -> accepted)
     */
    public function acceptEnquiry(Request $request, Lead $enquiry)
    {
        $this->authorizeBusinessOwnsResource($enquiry);
 
        $enquiry->update(['status' => 'accepted']);
 
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Enquiry accepted']);
        }
 
        return back()->with('success', 'Enquiry accepted');
    }
 
    /**
     * Mark an enquiry as completed (accepted -> completed)
     */
    public function completeEnquiry(Request $request, Lead $enquiry)
    {
        $this->authorizeBusinessOwnsResource($enquiry);
 
        $enquiry->update(['status' => 'completed']);
 
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Service marked as completed']);
        }
 
        return back()->with('success', 'Service marked as completed');
    }
 
    /**
     * Mark a reward redemption as completed by the business.
     * Business does NOT get coins yet — only after customer confirms separately.
     */
    public function completeRedemption(Request $request, Redemption $redemption)
    {
        $this->authorizeBusinessOwnsResource($redemption);
 
        $redemption->update(['status' => 'completed']);
 
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Marked complete. Awaiting customer confirmation to receive your reward coins.',
            ]);
        }
 
        return back()->with('success', 'Marked complete. Awaiting customer confirmation.');
    }
 
    /**
     * Simple ownership guard. Replace with a proper Policy class
     * (php artisan make:policy EnquiryPolicy) for production.
     */
    private function authorizeBusinessOwnsResource($resource): void
    {
        if ($resource->business_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

 

    public function getBusinessRewardsPending(Request $request)
	{		 
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);



		  $business = Auth::user(); // change to Auth::user()->business if you have a separate Business model
 
    
 
        // ---- Stats ----
        // $totalRevenue = Lead::where('business_id', $businessId)
        //     ->where('status', 'completed')
        //     ->orWhere('status', 'reviewed')
        //     ->sum('cost');
		$totalRevenue = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID)->where('status', 'completed')
            ->orWhere('status', 'reviewed')->sum('cost');

 
        $rewardBalance = $business->reward_balance ?? 0; // adjust to your wallet/coins column
 
        // $completedEnquiries = Lead::where('business_id', $businessId)
        //     ->whereIn('status', ['completed', 'reviewed'])
        //     ->count();
 		$completedEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->whereIn('status', ['completed', 'reviewed'])->count();
       

		$pendingEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->where('status', 'pending')->count();
 
		$averageRating = 0;

		$recentEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.cost as assign_cost','assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->take(5)->get();
  

		$allEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id','assigned_leads.status as assign_status', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->latest()->get();

//   dd($clientID);
        $pendingList = $allEnquiries->where('status', 'pending')->values();
        $activeList  = $allEnquiries->where('status', 'accepted')->values();
 
        // ---- Redemptions (reward bookings) ----
        $allRedemptions = Redemption::where('business_id', $clientID)
            ->with('customer')
            ->latest()
            ->get();
 
        $rewardPendingList  = $allRedemptions->where('status', 'pending')->values();
        $rewardAwaitingList = $allRedemptions->where('status', 'completed')->values();
 
        return view('business.rewards-pending', [
            'totalRevenue'        => $totalRevenue,
            'rewardBalance'       => $rewardBalance,
            'averageRating'       => $averageRating,
            'completedEnquiries'  => $completedEnquiries,
            'pendingEnquiries'    => $pendingEnquiries,
            'recentEnquiries'     => $recentEnquiries,
            'pendingList'         => $pendingList,
            'activeList'          => $activeList,
            'rewardPendingList'   => $rewardPendingList,
            'rewardAwaitingList'  => $rewardAwaitingList,
        ]);



		 
	}
    public function getBusinessRewardsCompleted(Request $request)
	{		 
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);



		  $business = Auth::user(); // change to Auth::user()->business if you have a separate Business model
 
    
 
        // ---- Stats ----
        // $totalRevenue = Lead::where('business_id', $businessId)
        //     ->where('status', 'completed')
        //     ->orWhere('status', 'reviewed')
        //     ->sum('cost');
		$totalRevenue = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID)->where('status', 'completed')
            ->orWhere('status', 'reviewed')->sum('cost');

 
        $rewardBalance = $business->reward_balance ?? 0; // adjust to your wallet/coins column
 
        // $completedEnquiries = Lead::where('business_id', $businessId)
        //     ->whereIn('status', ['completed', 'reviewed'])
        //     ->count();
 		$completedEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->whereIn('status', ['completed', 'reviewed'])->count();
       

		$pendingEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->where('status', 'pending')->count();
 
		$averageRating = 0;

		$recentEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.cost as assign_cost','assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->take(5)->get();
  

		$allEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id','assigned_leads.status as assign_status', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->latest()->get();

//  dd($allEnquiries);
        $pendingList = $allEnquiries->where('status', 'pending')->values();
        $activeList  = $allEnquiries->where('status', 'accepted')->values();
 
        // ---- Redemptions (reward bookings) ----
        $allRedemptions = Redemption::where('business_id', $clientID)
            ->with('customer')
            ->latest()
            ->get();
 
        $rewardPendingList  = $allRedemptions->where('status', 'pending')->values();
        $rewardAwaitingList = $allRedemptions->where('status', 'completed')->values();
 
        return view('business.rewards-completed', [
            'totalRevenue'        => $totalRevenue,
            'rewardBalance'       => $rewardBalance,
            'averageRating'       => $averageRating,
            'completedEnquiries'  => $completedEnquiries,
            'pendingEnquiries'    => $pendingEnquiries,
            'recentEnquiries'     => $recentEnquiries,
            'pendingList'         => $pendingList,
            'activeList'          => $activeList,
            'rewardPendingList'   => $rewardPendingList,
            'rewardAwaitingList'  => $rewardAwaitingList,
        ]);



		 
	}
    public function getBusinessRewardsHistory(Request $request)
	{		 
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);



		  $business = Auth::user(); // change to Auth::user()->business if you have a separate Business model
 
    
 
        // ---- Stats ----
        // $totalRevenue = Lead::where('business_id', $businessId)
        //     ->where('status', 'completed')
        //     ->orWhere('status', 'reviewed')
        //     ->sum('cost');
		$totalRevenue = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID)->where('status', 'completed')
            ->orWhere('status', 'reviewed')->sum('cost');

 
        $rewardBalance = $business->reward_balance ?? 0; // adjust to your wallet/coins column
 
        // $completedEnquiries = Lead::where('business_id', $businessId)
        //     ->whereIn('status', ['completed', 'reviewed'])
        //     ->count();
 		$completedEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->whereIn('status', ['completed', 'reviewed'])->count();
       

		$pendingEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->where('status', 'pending')->count();
 
		$averageRating = 0;

		$recentEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.cost as assign_cost','assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->take(5)->get();
  

		$allEnquiries = DB::table('leads')
		->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
		->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id','assigned_leads.status as assign_status', 'assigned_leads.created_at as created')
		->orderBy('assigned_leads.created_at', 'desc')
		->where('assigned_leads.client_id', $clientID)->latest()->latest()->get();

//  dd($allEnquiries);
        $pendingList = $allEnquiries->where('status', 'pending')->values();
        $activeList  = $allEnquiries->where('status', 'accepted')->values();
 
        // ---- Redemptions (reward bookings) ----
        $allRedemptions = Redemption::where('business_id', $clientID)
            ->with('customer')
            ->latest()
            ->get();
 
        $rewardPendingList  = $allRedemptions->where('status', 'pending')->values();
        $rewardAwaitingList = $allRedemptions->where('status', 'completed')->values();
 
        return view('business.rewards-history', [
            'totalRevenue'        => $totalRevenue,
            'allEnquiries'        => $allEnquiries,
            'rewardBalance'       => $rewardBalance,
            'averageRating'       => $averageRating,
            'completedEnquiries'  => $completedEnquiries,
            'pendingEnquiries'    => $pendingEnquiries,
            'recentEnquiries'     => $recentEnquiries,
            'pendingList'         => $pendingList,
            'activeList'          => $activeList,
            'rewardPendingList'   => $rewardPendingList,
            'rewardAwaitingList'  => $rewardAwaitingList,
        ]);
		 
	}



}
