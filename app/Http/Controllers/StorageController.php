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
            $contentType = Storage::disk('storage_ktp')->mimeType($filename);
            return response($file, 200)->header('Content-Type', $contentType);
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
    public function storageLisence(string $filename)
    {
        if (Storage::disk('storage_lisence')->exists($filename)) {
            $file = Storage::disk('storage_lisence')->get($filename);
            $contentType = Storage::disk('storage_lisence')->mimeType($filename);
            return response($file, 200)->header('Content-Type', $contentType);
        } else {
            abort(404, 'File not found');
        }
    }

    public function storagePublic(string $filename){
        if(Storage::disk('public')->exists($filename)){
            $file = Storage::disk('public')->get($filename);
            $contentType = Storage::disk('public')->mimeType($filename);
            return response($file, 200)->header('Content-Type', $contentType);
        } else {
            abort(404, 'File not found');
        }
    }
}
