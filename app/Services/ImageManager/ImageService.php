<?php

namespace App\Services\ImageManager;

use App\Services\Interfaces\FileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\GifEncoder;
use Intervention\Image\Drivers\Gd\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Gd\Encoders\PngEncoder;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;

class ImageService implements FileServiceInterface
{
    /**
     * @param string $disk
     * @param Request $request
     * @param string $name
     * @param string $convert 'original|webp|jpg|png|gif|'
     * @param int $quality 0-100
     * @return string
     */
    public static function uploadFile(string $disk, Request $request, string $name = 'images', string $convert = 'original', int $quality = 75): string
    {
        try {
            $manager = new ImageManager(new Driver());
            $extension = $request->file($name)->extension();
            $image = $manager->read($request->file($name));
            if ($convert === 'original') {
                $image->encode(new AutoEncoder($quality));
            } else if ($convert === 'webp') {
                $image->encode(new WebpEncoder($quality));
                $extension = 'webp';
            } else if ($convert === 'jpg' || $convert === 'jpeg') {
                $image->encode(new JpegEncoder($quality));
                $extension = 'jpg';
            } else if ($convert === 'png') {
                $image->encode(new PngEncoder($quality));
                $extension = 'png';
            } else if ($convert === 'gif') {
                $image->encode(new GifEncoder($quality));
                $extension = 'gif';
            }
            $imageName = time() . '-' . pathinfo($request->file($name)->hashName(), PATHINFO_FILENAME) . "." . $extension;
            $image->save(storage_path('app/' . $imageName));
            Storage::disk($disk)->put($imageName, file_get_contents(storage_path('app/' . $imageName)));
            unlink(storage_path('app/' . $imageName));
            return $imageName;
        } catch (\Exception $e) {
            // Handle the exception, log it, or throw a custom exception
            // For example:
            Log::error('Error occurred while uploading file: ' . $e->getMessage());
            throw new \Exception('Failed to upload file.');
        }
    }


    public static function deleteFile(string $disk, string $path): bool
    {
        return Storage::disk($disk)->delete($path);
    }
}
