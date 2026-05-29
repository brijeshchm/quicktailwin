<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HandlesImageUploads
{
    /**
     * Smart image save — resize, compress, store, return filename.
     *
     * @param  UploadedFile $file
     * @param  string       $destinationPath  Absolute path (e.g. public_path('uploads/avatars'))
     * @param  int          $width            Target width
     * @param  int          $height           Target height
     * @param  int          $quality          JPG/WebP quality 0-100
     * @return string|null  Saved filename
     */
    protected function saveImageSmart(
        ?UploadedFile $file,
        string $destinationPath,
        int $width = 400,
        int $height = 400,
        int $quality = 85
    ): ?string {
        if (!$file || !$file->isValid()) return null;

        // Ensure directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $extension    = strtolower($file->getClientOriginalExtension());
        $extension    = in_array($extension, ['jpg','jpeg','png','webp']) ? $extension : 'jpg';
        $filename     = Str::random(20) . '_' . time() . '.' . $extension;
        $fullPath     = $destinationPath . DIRECTORY_SEPARATOR . $filename;

        // Load source image based on type
        $mime = $file->getMimeType();
        switch ($mime) {
            case 'image/jpeg': $src = imagecreatefromjpeg($file->getPathname()); break;
            case 'image/png':  $src = imagecreatefrompng($file->getPathname());  break;
            case 'image/webp': $src = imagecreatefromwebp($file->getPathname()); break;
            default:
                // Fallback: just move it
                $file->move($destinationPath, $filename);
                return $filename;
        }

        if (!$src) return null;

        $srcW = imagesx($src);
        $srcH = imagesy($src);

        // Calculate crop for center-fill (cover behavior)
        $srcAspect = $srcW / $srcH;
        $dstAspect = $width / $height;

        if ($srcAspect > $dstAspect) {
            // Source wider — crop sides
            $newSrcW = (int) ($srcH * $dstAspect);
            $newSrcH = $srcH;
            $srcX    = (int) (($srcW - $newSrcW) / 2);
            $srcY    = 0;
        } else {
            // Source taller — crop top/bottom
            $newSrcW = $srcW;
            $newSrcH = (int) ($srcW / $dstAspect);
            $srcX    = 0;
            $srcY    = (int) (($srcH - $newSrcH) / 2);
        }

        // Create destination canvas
        $dst = imagecreatetruecolor($width, $height);

        // Preserve transparency for PNG/WebP
        if (in_array($extension, ['png','webp'])) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $width, $height, $transparent);
        }

        // Resize + crop
        imagecopyresampled(
            $dst, $src,
            0, 0, $srcX, $srcY,
            $width, $height,
            $newSrcW, $newSrcH
        );

        // Save based on extension
        $saved = false;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $saved = imagejpeg($dst, $fullPath, $quality);
                break;
            case 'png':
                // PNG quality 0-9 (9 = max compression)
                $pngQuality = 9 - (int) round($quality / 11.11);
                $saved = imagepng($dst, $fullPath, max(0, min(9, $pngQuality)));
                break;
            case 'webp':
                $saved = imagewebp($dst, $fullPath, $quality);
                break;
        }

        imagedestroy($src);
        imagedestroy($dst);

        return $saved ? $filename : null;
    }

    /**
     * Delete an old image file (if exists)
     */
    protected function deleteImageFile(?string $filename, string $directory): void
    {
        if (!$filename) return;
      
        if (file_exists($filename)) @unlink($filename);



        
    }
}