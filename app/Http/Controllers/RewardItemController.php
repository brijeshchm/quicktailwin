<?php
namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CoinTransaction;
use App\Models\RewardsItem;
use App\Models\Client;
use App\Models\ParentCategory;
use App\Models\Keyword;
use App\Models\Citieslists;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RewardItemController  extends Controller
{
     public function index()
    {       
		$items = RewardsItem::latest()
			->get()
			->map(function ($item) {
				$image="";
				if($item->image_url){
					$image_url = json_decode($item->image_url);
					$image = $image_url->rewards->src;
				}
				return [
					'id'             => $item->id,
					'title'          => $item->title,
					'code'           => $item->code,
					'description'    => $item->description,
					'image_url'      => $image ? $image : null,
					'coins_required' => $item->coins_required,
					'credit_coins'   => $item->credit_coins,
					'city_prices'    => $item->city_prices,
					'category_id'    => $item->category_id,
					'category'       => $item->category,
					'is_active'      => $item->is_active,
					'created_at'     => $item->created_at?->format('d-M-Y h:i A'),
					'updated_at'     => $item->updated_at?->format('d-M-Y h:i A'),
				];
			}); 
        $categories = Keyword::orderBy('keyword')->get();
        $citylist = Citieslists::orderBy('city')->get();
 
        return view('admin.rewards.index', compact('items', 'categories','citylist'));
    }

    public function store(Request $request,RewardsItem $reward)
    {

 
        $data = $this->validated($request,$reward);
 
       

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

        RewardsItem::create($data);

        return redirect()
            ->route('developer.rewards.index')
            ->with('success', 'Reward item created successfully.');
    }

    public function update(Request $request, RewardsItem $reward)
    {
  
        $data = $this->validated($request, $reward);
 
        $alt = $request->title;
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

    public function destroy(RewardsItem $reward)
    {
        $reward->delete();

        return redirect()
            ->route('developer.rewards.index')
            ->with('success', 'Item deleted successfully.');
    }

    // ── Shared validation ──────────────────────────────────
    private function validated(Request $request, RewardsItem $reward): array
    {
        // return $request->validate([
        //     'title'                         => 'required|string|max:255',
        //     'code'                  => 'required|string|unique:rewards_items',
        //     'description'                  => 'nullable|string',
        //     'image_url'                    => 'nullable|string|max:500',
        //     'coins_required'               => 'required|integer|min:1',
        //     'credit_coins'                 => 'required|integer|min:0',
        //     'city_prices'                  => 'nullable|array',
        //     'city_prices.*.city'           => 'required|string|max:100',
        //     'city_prices.*.coins_required' => 'required|integer|min:1',
        //     'city_prices.*.credit_coins'   => 'required|integer|min:0',
        //     'category_id'                     => 'nullable|string|max:100',
        //     'category'                     => 'nullable|string|max:100',
        //     'is_active'                    => 'boolean',
        // ]);
 

    return $request->validate([
        'title' => 'required|string|max:255',

        'code' => [
            'required',
            'string',
            Rule::unique('rewards_items', 'code')->ignore($reward->id),
        ],

        'description'                  => 'nullable|string',
        // 'image_url'                    => 'nullable|string|max:500',
        'coins_required'               => 'required|integer|min:1',
        'credit_coins'                 => 'required|integer|min:0',
        'city_prices'                  => 'nullable|array',
        'city_prices.*.city'           => 'required|string|max:100',
        'city_prices.*.coins_required' => 'required|integer|min:1',
        'city_prices.*.credit_coins'   => 'required|integer|min:0',
        'category_id'                  => 'nullable|string|max:100',
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