<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Client\Address;
use App\Models\Guest;
use App\Models\RedeemableItem;
use App\Models\Client;
use App\Models\CoinTransaction;
use App\Models\Redemption;
use App\Models\Voucher;
use App\Models\ParentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class RewardController extends Controller
{
    
 public function index()
    {

  $user = Auth::user();
 
        $rewards = [
            'balance'      => $user->reward_balance ?? 0,
            'totalEarned'  => $user->total_earned ?? 0,
            'totalRedeemed' => $user->total_redeemed ?? 0,
        ];
 
        $items = RedeemableItem::where('is_active', true)          
            ->get();
 
        $businesses = Guest::all();
 
        $redemptions = Redemption::where('user_id', $user->id)
            ->latest()
            ->get();
 
            
        $transactions = CoinTransaction::where('user_id', $user->id)
            ->latest()
            ->get();
 
        $minRewardPoints = $items->count() > 0
            ? $items->min('coins_required')
            : 500;
 
        $progressPercent = min(100, $rewards['balance'] > 0
            ? ($rewards['balance'] / max($minRewardPoints, 1)) * 100
            : 0);
 
        return view('user.rewards.index', [
            'rewards'          => $rewards,
            'items'            => $items,
            'businesses'       => $businesses,
            'redemptions'      => $redemptions,
            'transactions'     => $transactions,
            'minRewardPoints'  => $minRewardPoints,
            'progressPercent'  => $progressPercent,
        ]);


       
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'item_id'     => 'required|exists:redeemable_items,id',
            'business_id' => 'required|exists:businesses,id',
            'city'        => 'nullable|string',
        ]);

        $user     = Auth::user();
        $item     = RedeemableItem::findOrFail($request->item_id);
        $business = Client::findOrFail($request->business_id);

        // Resolve effective cost
        $coinsRequired = $item->coins_required;
        if ($request->city && !empty($item->city_prices)) {
            foreach ($item->city_prices as $cp) {
                if ($cp['city'] === $request->city) {
                    $coinsRequired = $cp['coins_required'];
                    break;
                }
            }
        }

        if ($user->coin_balance < $coinsRequired) {
            return back()->with('error', 'Insufficient coins.');
        }

        DB::transaction(function () use ($user, $item, $business, $request, $coinsRequired) {
            // Deduct coins
            $user->decrement('coin_balance', $coinsRequired);
            $user->increment('total_redeemed', $coinsRequired);

            // Record redemption
            Redemption::create([
                'user_id'            => $user->id,
                'redeemable_item_id' => $item->id,
                'business_id'        => $business->id,
                'item_name'          => $item->name,
                'business_name'      => $business->name,
                'city'               => $request->city,
                'coins_spent'        => $coinsRequired,
                'status'             => 'pending',
            ]);

            // Log transaction
            CoinTransaction::create([
                'user_id'     => $user->id,
                'type'        => 'redeemed',
                'points'      => $coinsRequired,
                'description' => "Redeemed: {$item->name} at {$business->name}",
            ]);
        });

        return back()->with('success', "You've redeemed {$item->name}! Remaining: " . $user->fresh()->coin_balance . " coins.");
    }

    public function confirmRedemption(Redemption $redemption)
    {
        abort_if($redemption->user_id !== Auth::id(), 403);
        abort_if($redemption->status !== 'completed', 422, 'Cannot confirm at this stage.');

        DB::transaction(function () use ($redemption) {
            $redemption->update(['status' => 'confirmed']);

            // Credit refund coins to business owner
            $business = $redemption->business;
            $item     = $redemption->item;

            if ($business && $item && $item->credit_coins > 0) {
                // Credit business owner wallet
                $business->owner?->increment('coin_balance', $item->credit_coins);
                $business->owner?->increment('total_earned', $item->credit_coins);

                CoinTransaction::create([
                    'user_id'     => $business->owner_id,
                    'type'        => 'earned',
                    'points'      => $item->credit_coins,
                    'description' => "Refund for redemption: {$item->name}",
                ]);
            }
        });

        return back()->with('success', 'Completion confirmed. The business has received its reward coins.');
    }

 

    


}