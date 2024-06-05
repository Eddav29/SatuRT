<?php

namespace App\Services\FileManager;

use App\Services\Interfaces\FileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    public static function uploadFile(string $disk, Request $request, string $name = 'images'): string
    {
        $fileName = time() . '-' . $request->file($name)->getClientOriginalName();  
        $request->file($name)->storeAs($disk, $fileName);
        return $fileName;
    }

    public static function deleteFile(string $disk, string $path): bool
    {
        return Storage::disk($disk)->delete($path);
    }
}