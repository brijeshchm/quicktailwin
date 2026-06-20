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
//  dd($items);
        return view('admin.rewards.index', compact('items', 'categories','citylist'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
 
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('rewards', 'public');
            $data['image_url'] = url($path);
        }

            $alt = $request->name;
        	if ($request->hasFile('image_file')) {
			$filePath = getFolderRewardsStructure();
			$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
					$request->file('image_file'),
					$destinationPath,
					127,
					112
				);

				$image['rewards'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
			$data['image_url']= json_encode($image);
				 
		} 

        RedeemableItem::create($data);

        return redirect()
            ->route('developer.rewards.index')
            ->with('success', 'Reward item created successfully.');
    }

    public function update(Request $request, RedeemableItem $reward)
    {

    // dd($request);
        $data = $this->validated($request);
 
        $alt = $request->name;
        if ($request->hasFile('image_file')) {
			$filePath = getFolderRewardsStructure();
			$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
					$request->file('image_file'),
					$destinationPath,
					127,
					112
				);

				$image['rewards'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
			$data['image_url']= json_encode($image);
				 
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

    private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
	{
		$ext = strtolower($file->getClientOriginalExtension());
		$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$name = str_replace(' ', '_', $name);
		$filename = bin2hex(random_bytes(5)).'_Quickdials';

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

		$width  = $width ?? imagesx($src);
		$height = $height ?? imagesy($src);

		$dst = imagecreatetruecolor($width, $height);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		imagecopyresampled(
			$dst, $src,
			0, 0, 0, 0,
			$width, $height,
			imagesx($src), imagesy($src)
		);

		$finalName = $filename . '.webp';
		imagewebp($dst, $destinationPath . '/' . $finalName, 80);

		imagedestroy($src);
		imagedestroy($dst);

		return $finalName;
	}




}