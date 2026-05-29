<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Client\Business;
use App\Models\Occupation;
use App\Models\Guest;
use App\Models\lead;
use App\Models\Client\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ServiceController extends Controller
{
    /**
     * Show favorites page
     */
    public function service(Request $request)
    {
         $user = Auth::guard('guest')->user();
         

        // All categories for sidebar
        $categories = Occupation::get();
 $services = DB::table('leads')

    ->leftJoin('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
    ->leftJoin('clients', 'assigned_leads.client_id', '=', 'clients.id')

    ->leftJoinSub(
        DB::table('lead_follow_ups as lf')
            ->leftJoin('status', 'lf.status', '=', 'status.id')
            ->select(
                'lf.lead_id',
                'lf.status as status_id',
                'status.name as status_name',
                'lf.remark',
                'lf.created_at'
            )
            ->whereIn('lf.id', function ($q) {
                $q->select(DB::raw('MAX(id)'))
                  ->from('lead_follow_ups')
                  ->groupBy('lead_id');
            }),
        'follow',
        'leads.id', '=', 'follow.lead_id'
    )

    ->select(
        'leads.id',
        'leads.kw_text',
        'leads.mobile',
        'leads.created_at',
        'leads.city_name',

        // ✅ FIX 1: Pull status_id + status_name from the subquery
        'follow.status_id   as follow_status_id',
        'follow.status_name as follow_status',

        'follow.remark      as follow_remarks',
        'follow.created_at  as last_follow_at',

        DB::raw('COUNT(DISTINCT assigned_leads.client_id) as assigned_count'),
        DB::raw("GROUP_CONCAT(DISTINCT clients.business_name SEPARATOR ', ') as client_companies")
    )

    ->where('leads.mobile', $user->mobile)

    ->groupBy(
        'leads.id',
        'leads.kw_text',
        'leads.mobile',
        'leads.created_at',
        'leads.city_name',

        // ✅ FIX 2: Fully qualify with table alias
        'follow.status_id',
        'follow.status_name',

        'follow.remark',
        'follow.created_at'
    )

    ->orderByDesc('leads.created_at')
    ->get();
    //   dd($services);
        $joinedIds='4';
            $interestedIds='4';

            
        return view('user.profile.service', compact(
            'user', 'categories','services','joinedIds','interestedIds'
        ));
    }

    /**
     * Search businesses (AJAX)
     */
    public function search(Request $request)
    {
        $request->validate([
            'q'        => 'nullable|string|max:100',
            'category' => 'required|exists:categories,slug',
        ]);

        // $client = Auth::guard('clients')->user();
        $user = Guest::find(1);
        $category = Occupation::where('slug', $request->category)->firstOrFail();

        

        return response()->json([
            'success' => true,
            'category'    =>$category,
            'count'   => '1',
        ]);
    }

    /**
     * Toggle favorite (add/remove)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
        ]);

        $client = Auth::guard('clients')->user();
        $business = Business::findOrFail($request->business_id);

        $favorite = Favorite::where('client_id', $client->id)
            ->where('business_id', $business->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $action = 'removed';
        } else {
            Favorite::create([
                'client_id'   => $client->id,
                'business_id' => $business->id,
                'category_id' => $business->category_id,
            ]);
            $action = 'added';

            // Boost popularity
            $business->increment('popularity');
        }

        return response()->json([
            'success'        => true,
            'action'         => $action,
            'total_favorites'=> $client->favorites()->count(),
            'message'        => $action === 'added'
                ? 'Added to favorites'
                : 'Removed from favorites',
        ]);
    }

    /**
     * Continue to next step
     */
    public function continue(Request $request)
    {
        $client = Auth::guard('clients')->user();

        if ($client->favorites()->count() === 0) {
            return back()->withErrors([
                'favorites' => 'Please add at least one favorite to continue.'
            ]);
        }

        $client->update([
            'profile_step'     => 'completed',
            'profile_progress' => $client->calculateProgress(),
        ]);

        return redirect()->route('client.profile.completed')
            ->with('success', 'Favorites saved! Profile complete.');
    }
}