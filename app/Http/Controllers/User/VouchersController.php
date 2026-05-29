<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\Client\Address;
use App\Models\Guest;
use App\Models\Voucher;
use App\Models\ParentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VouchersController extends Controller
{
    /**
     * Show addresses page
     */
    public function vouchers()
    {
        $user = Guest::find(1);
        // $client = Auth::guard('clients')->user();
 
        // $addresses = $client->addresses()->latest()->get();
 $categories = ParentCategory::get();
         $vouchers = [
    (object)[
        'category_id' => 'keyword',
        'title' => '20% Off on Health Checkup',
        'code' => 'HEALTH500',
        'type' => 'flat',
        'value' => 20,
        'min_order' => 2000,
        'brand' => 'Apollo',
        'valid_until' => now()->addDays(30),
        'description' => 'Valid on full body checkup packages',
    ],

    (object)[
        'category_id' => 'keyword',
        'title' => '20% Off on Pharmacy',
        'code' => 'PHARMA20',
        'type' => 'percentage',
        'value' => 20,
        'max_discount' => 300,
        'brand' => 'MedPlus',
        'valid_until' => now()->addDays(7),
        'description' => 'On all medicines and wellness products',
    ],

    (object)[
        'category_id' => 'keyword',
        'title' => 'Flat ₹150 Off',
        'code' => 'EAT150',
        'type' => 'flat',
        'value' => 150,
        'min_order' => 500,
        'brand' => 'Zomato',
        'valid_until' => now()->addDays(15),
    ],
];
        return view('user.profile.vouchers', compact('user','vouchers','categories'));
    }

    /**
     * Claim a voucher (AJAX)
     */
    public function claim(Request $request)
    {
        $request->validate(['voucher_id' => 'required|exists:vouchers,id']);

        $user = Auth::user();
        $voucher = Voucher::active()->findOrFail($request->voucher_id);

        // Already claimed?
        if ($user->hasClaimedVoucher($voucher->id)) {
            return response()->json([
                'success' => false,
                'message' => 'You have already claimed this voucher.',
            ], 422);
        }

        // Exhausted?
        if ($voucher->is_exhausted) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher is no longer available.',
            ], 422);
        }

        // Claim
        $user->vouchers()->attach($voucher->id, [
            'status'     => 'claimed',
            'claimed_at' => now(),
        ]);

        $voucher->increment('used_count');

        return response()->json([
            'success'    => true,
            'message'    => 'Voucher claimed! Code: ' . $voucher->code,
            'code'       => $voucher->code,
            'claimed'    => $user->vouchers()->count(),
        ]);
    }

    /**
     * My claimed vouchers
     */
    public function myVouchers()
    {
        $user = Auth::user();

        $vouchers = $user->vouchers()
            ->with('category')
            ->orderByPivot('claimed_at', 'desc')
            ->get();

        return view('user.profile.my-vouchers', compact('user', 'vouchers'));
    }
 
    /**
     * Store new address (AJAX)
     */
    public function store(StoreAddressRequest $request)
    {
        $client = Auth::guard('clients')->user();

        // Prevent duplicate tag (one home, one office per client)
        if (in_array($request->tag, ['home', 'office'])) {
            $exists = $client->addresses()->where('tag', $request->tag)->exists();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => "You already have a {$request->tag} address. Please edit or delete it first.",
                ], 422);
            }
        }

        $data = $request->validated();
        $data['client_id'] = $client->id;

        // First address becomes default
        if ($client->addresses()->count() === 0) {
            $data['is_default'] = true;
        }

        $address = Guest::create($data);

        // Update profile progress
        $client->update([
            'profile_progress' => $client->calculateProgress(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully!',
            'address' => $address,
            'html'    => view('user.profile.address-card', compact('address'))->render(),
        ]);
    }

    /**
     * Delete address (AJAX)
     */
    public function destroy(Address $address)
    {
        // Ownership check
        if ($address->client_id !== Auth::guard('clients')->id()) {
            abort(403);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address removed',
        ]);
    }

    /**
     * Save & Continue to next step
     */
    public function continue(Request $request)
    {
        $client = Auth::guard('guest')->user();

        // Require at least one address
        if ($client->addresses()->count() === 0) {
            return back()->withErrors(['address' => 'Please add at least one address before continuing.']);
        }

        $client->update([
            'profile_step'     => 'favorites',
            'profile_progress' => $client->calculateProgress(),
        ]);

        return redirect()->route('user.profile.favorites')
            ->with('success', 'Addresses saved successfully!');
    }




    


}