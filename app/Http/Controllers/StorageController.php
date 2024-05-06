<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function storageKTP($filename)
    {

        if (Storage::disk('storage_ktp')->exists($filename)) {
            $file = Storage::disk('storage_ktp')->get($filename);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        } else {
            abort(404, 'File not found');
        }
    }

    public function storageAnnouncement(string $filename)
    {
        if (Storage::disk('storage_announcement')->exists($filename)) {
            $file = Storage::disk('storage_announcement')->get($filename);
            $contentType = Storage::disk('storage_announcement')->mimeType($filename);
            return response($file, 200)->header('Content-Type', $contentType);
        } else {
            abort(404, 'File not found');
        }
    }
}
