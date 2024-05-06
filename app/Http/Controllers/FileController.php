<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(string $path, string $identifier)
    {
        $fileName = '';
        $disk = '';

        switch ($path) {
            case 'pengumuman':
                $fileName = Informasi::find($identifier)->thumbnail_url;
                $disk = 'storage_announcement/';
                break;

            default:
                abort(404, 'Path not found');
                break;
        }

        try {
            return Storage::download($disk . $fileName);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'File not found or an error occurred.'], 404);
        }
    }

    public function show(string $path, string $identifier)
    {
        $fileName = '';
        $disk = '';

        switch ($path) {
            case 'pengumuman':
                $fileName = Informasi::find($identifier)->thumbnail_url;
                $disk = 'storage_announcement/';
                break;
            default:
                abort(404, 'Path not found');
                break;
        }

        try {
            return response()->file(Storage::path($disk . $fileName));
        } catch (\Throwable $th) {
            return response()->json(['error' => 'File not found or an error occurred.'], 404);
        }
    }
}
