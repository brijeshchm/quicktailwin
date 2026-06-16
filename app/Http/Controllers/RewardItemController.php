<?php
namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CoinTransaction;
use App\Models\RedeemableItem;
use App\Models\Client;
use App\Models\ParentCategory;
use App\Models\Keyword;
use App\Models\Citieslists;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardItemController  extends Controller
{
     public function index()
    {
        $items      = RedeemableItem::latest()->get();
        $categories = Keyword::orderBy('keyword')->get();
        $citylist = Citieslists::orderBy('city')->get();

        return view('admin.rewards.index', compact('items', 'categories','citylist'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('rewards', 'public');
            $data['image_url'] = url($path);
        }

        RedeemableItem::create($data);

        return redirect()
            ->route('developer.rewards.index')
            ->with('success', 'Reward item created successfully.');
    }

    public function update(Request $request, RedeemableItem $reward)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('rewards', 'public');
            $data['image_url'] = url($path);
        }

        $data['is_active'] = $request->boolean('is_active');

        $reward->update($data);

        return redirect()
            ->route('developer.rewards.index')
            ->with('success', 'Reward item updated successfully.');
    }

    public function destroy(RedeemableItem $reward)
    {
        $reward->delete();

        return redirect()
            ->route('developer.rewards.index')
            ->with('success', 'Item deleted successfully.');
    }

    // ── Shared validation ──────────────────────────────────
    private function validated(Request $request): array
    {
        return $request->validate([
            'name'                         => 'required|string|max:255',
            'description'                  => 'nullable|string',
            'image_url'                    => 'nullable|string|max:500',
            'coins_required'               => 'required|integer|min:1',
            'credit_coins'                 => 'required|integer|min:0',
            'city_prices'                  => 'nullable|array',
            'city_prices.*.city'           => 'required|string|max:100',
            'city_prices.*.coins_required' => 'required|integer|min:1',
            'city_prices.*.credit_coins'   => 'required|integer|min:0',
            'category'                     => 'nullable|string|max:100',
            'is_active'                    => 'boolean',
        ]);

 



    }
}