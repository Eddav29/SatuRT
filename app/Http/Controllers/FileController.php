<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

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

    public function ckeditor_image_upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'upload.required' => 'Thumbnail harus diisi.',
            'upload.mimes' => 'File harus berupa gambar.',
            'upload.max' => 'File maksimal 2048kb.',
        ]);

        if ($validator->fails()) {
            return response()->json(['uploaded' => 0], 400);
        }

        try {
            if ($request->file('upload')) {
                $manager = new ImageManager(new Driver());
                $extension = $request->file('upload')->extension();
                $image = $manager->read($request->file('upload'));
                $image->encode(new WebpEncoder(75));
                $extension = 'webp';
                $imageName = time() . '-' . pathinfo($request->file('upload')->hashName(), PATHINFO_FILENAME) . "." . $extension;
                $image->save(storage_path('app/' . $imageName));
                Storage::disk('public')->put($imageName, file_get_contents(storage_path('app/' . $imageName)));
                unlink(storage_path('app/' . $imageName));
                $url = asset('storage/images_storage/' . $imageName);
                return response()->json(['fileName' => $imageName, 'uploaded' => 1, 'url' => $url], 200);
            }

            return response()->json(['uploaded' => 0], 400);
        } catch (\Throwable $th) {
            NotificationPusher::error('File gagal ditambahkan');
            return response()->json(['uploaded' => 0, 'message' => $th->getMessage()], 400);
        }
    }
}
