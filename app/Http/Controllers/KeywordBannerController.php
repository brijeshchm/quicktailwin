<?php
// app/Http/Controllers/KeywordBannerController.php
namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\KeywordBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client\Client; //model
class KeywordBannerController extends Controller
{


public function upload(Request $request, $keywordId)
{
    $request->validate([
        'banners'             => 'required|array|max:10',
        'banners.*'           => 'required|image|mimes:jpeg,jpg,png,svg,webp|max:5120',
        'banner_clients'      => 'nullable|array',
        'banner_clients.*'    => 'nullable|string|exists:clients,business_slug',
        'alt_text.*'          => 'nullable|string|max:255',
    ], [
        'banner_clients.*.exists' => 'Selected client is invalid.',
    ]);

    if (!extension_loaded('gd') || !function_exists('imagewebp')) {
        return response()->json(['status' => 'error', 'message' => 'Server missing GD/WebP.'], 500);
    }

    $keyword   = Keyword::findOrFail($keywordId);
    $relDir    = 'uploads/keyword-banners';
    $uploadDir = public_path($relDir);

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $startOrder = (int) $keyword->banners()->max('sort_order') + 1;
    $clients    = $request->input('banner_clients', []);
    $saved      = [];

    DB::beginTransaction();
    try {
        foreach ($request->file('banners') as $index => $file) {
            $filename = $this->saveImageSmart($file, $uploadDir, 1351, 192, 'cover');

            $saved[] = KeywordBanner::create([
                'keyword_id'    => $keyword->id,
                'image_path'    => $relDir . '/' . $filename,
                'original_name' => $file->getClientOriginalName(),
                'alt_text'      => $request->input("alt_text.$index"),
                'client_slug'   => $clients[$index] ?? null,
                'sort_order'    => $startOrder + $index,
            ]);
        }

        DB::commit();

        return response()->json([
            'status'  => 'success',
            'message' => count($saved) . ' banner(s) uploaded.',
            'data'    => $saved,
        ]);
    } catch (\Throwable $e) {
        DB::rollBack();
        foreach ($saved as $b) {
            @unlink(public_path($b->image_path));
        }
        return response()->json(['status' => 'error', 'message' => 'Upload failed: ' . $e->getMessage()], 500);
    }
}

/**
 * Update client_slug of an existing banner.
 */
public function updateClient(Request $request, $id)
{
   
    $request->validate([
        'client_slug' => 'nullable|string|exists:clients,business_slug',
    ], [
        'client_slug.exists' => 'Selected client is invalid.',
    ]);

    $banner = KeywordBanner::findOrFail($id);
    $banner->update(['client_slug' => $request->input('client_slug') ?: null]);

    return response()->json([
        'status'  => 'success',
        'message' => 'Client linked.',
        'data'    => $banner,
    ]);
}


 
/**
 * Update URL of an existing banner.
 */
public function updateUrl(Request $request, $id)
{
    $request->validate([
        'url' => 'nullable|url|max:500',
    ], [
        'url.url' => 'Please enter a valid URL (e.g. https://example.com).',
    ]);

    $banner = KeywordBanner::findOrFail($id);
    $banner->update(['url' => $request->input('url') ?: null]);

    return response()->json([
        'status'  => 'success',
        'message' => 'URL updated.',
        'data'    => $banner,
    ]);
}
  

    public function destroy($id)
    {
        $banner = KeywordBanner::findOrFail($id);
        $path   = public_path($banner->image_path);

        if (file_exists($path)) {
            @unlink($path);
        }

        $banner->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Banner deleted.',
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order'              => 'required|array',
            'order.*.id'         => 'required|integer|exists:keyword_banners,id',
            'order.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->order as $item) {
            KeywordBanner::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['status' => 'success']);
    }

    /*
     * Save an uploaded image with smart resize + WebP conversion.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  string  $destinationPath   Absolute folder path
     * @param  int|null $maxWidth
     * @param  int|null $maxHeight
     * @param  string  $mode  'cover' = crop to fill, 'contain' = fit inside, 'stretch' = exact
     * @param  int     $quality  WebP quality 1-100
     * @return string  Final filename only (e.g. abc123_Quickdials.webp)
     */
    private function saveImageSmart(
        $file,
        $destinationPath,
        $maxWidth = null,
        $maxHeight = null,
        $mode = 'cover',
        $quality = 82
    ) {
        $ext      = strtolower($file->getClientOriginalExtension());
        $filename = bin2hex(random_bytes(5)) . '_Quickdials';

        // ✅ SVG → save directly (vector, no conversion)
        if ($ext === 'svg') {
            $finalName = $filename . '.svg';
            $file->move($destinationPath, $finalName);
            return $finalName;
        }

        // ✅ Raster → load source
        $imagePath = $file->getPathname();
        $src = $this->createImageFromFile($imagePath, $ext);

        if (!$src) {
            throw new \Exception("Unsupported image type: {$ext}");
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);

        // ✅ Calculate target dimensions based on mode
        [$dstW, $dstH, $cropX, $cropY, $cropW, $cropH] = $this->calculateDimensions(
            $srcW, $srcH, $maxWidth, $maxHeight, $mode
        );

        // ✅ Create destination canvas with transparency support
        $dst = imagecreatetruecolor($dstW, $dstH);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefilledrectangle($dst, 0, 0, $dstW, $dstH, $transparent);
        imagealphablending($dst, true);

        // ✅ Resample with crop offsets (for 'cover' mode)
        imagecopyresampled(
            $dst, $src,
            0, 0,            // dst x, y
            $cropX, $cropY,  // src x, y (crop start)
            $dstW, $dstH,    // dst w, h
            $cropW, $cropH   // src w, h (crop area)
        );

        $finalName = $filename . '.webp';
        $savedOk   = imagewebp($dst, $destinationPath . '/' . $finalName, $quality);

        imagedestroy($src);
        imagedestroy($dst);

        if (!$savedOk) {
            throw new \Exception('Failed to write WebP file.');
        }

        return $finalName;
    }

    /**
     * Create GD resource from file based on extension.
     */
    private function createImageFromFile($path, $ext)
    {
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                return @imagecreatefromjpeg($path);
            case 'png':
                $img = @imagecreatefrompng($path);
                if ($img) {
                    imagepalettetotruecolor($img);
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                }
                return $img;
            case 'webp':
                return @imagecreatefromwebp($path);
            case 'gif':
                return @imagecreatefromgif($path);
        }
        return false;
    }

    /**
     * Compute output dimensions + crop offsets based on mode.
     * Returns: [dstW, dstH, cropX, cropY, cropW, cropH]
     */
    private function calculateDimensions($srcW, $srcH, $maxW, $maxH, $mode)
    {
        // No resize requested
        if (!$maxW && !$maxH) {
            return [$srcW, $srcH, 0, 0, $srcW, $srcH];
        }

        // Only one dimension given → preserve aspect
        if (!$maxW) {
            $ratio = $maxH / $srcH;
            return [(int)($srcW * $ratio), $maxH, 0, 0, $srcW, $srcH];
        }
        if (!$maxH) {
            $ratio = $maxW / $srcW;
            return [$maxW, (int)($srcH * $ratio), 0, 0, $srcW, $srcH];
        }

        switch ($mode) {
            case 'stretch':
                // Force exact dimensions (may distort)
                return [$maxW, $maxH, 0, 0, $srcW, $srcH];

            case 'contain':
                // Fit inside box, preserve aspect, no crop, no upscale
                $ratio = min($maxW / $srcW, $maxH / $srcH, 1);
                return [
                    (int)($srcW * $ratio),
                    (int)($srcH * $ratio),
                    0, 0, $srcW, $srcH,
                ];

            case 'cover':
            default:
                // Fill box, preserve aspect, center-crop overflow
                $srcRatio = $srcW / $srcH;
                $dstRatio = $maxW / $maxH;

                if ($srcRatio > $dstRatio) {
                    // Source is wider → crop sides
                    $cropH = $srcH;
                    $cropW = (int)($srcH * $dstRatio);
                    $cropX = (int)(($srcW - $cropW) / 2);
                    $cropY = 0;
                } else {
                    // Source is taller → crop top/bottom
                    $cropW = $srcW;
                    $cropH = (int)($srcW / $dstRatio);
                    $cropX = 0;
                    $cropY = (int)(($srcH - $cropH) / 2);
                }
                return [$maxW, $maxH, $cropX, $cropY, $cropW, $cropH];
        }
    }
}