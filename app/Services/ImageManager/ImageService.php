<?php

namespace App\Services\ImageManager;

use App\Services\Interfaces\FileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class imageService implements FileServiceInterface
{
    public static function uploadFile($disk, Request $request): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('images'));
        $image->toJpeg(80);
        $imageName = $request->images->hashName();
        $image->save(storage_path('app/' . $imageName));
        Storage::disk($disk)->put($imageName, file_get_contents(storage_path('app/' . $imageName)));
        unlink(storage_path('app/' . $imageName));

        return $imageName;
    }

    public static function deleteFile($disk, $path): bool
    {
        return Storage::disk($disk)->delete($path);
    }
}
