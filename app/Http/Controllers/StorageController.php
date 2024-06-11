<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    private function serveFile($disk, $filename)
    {
        if (Storage::disk($disk)->exists($filename)) {
            $file = Storage::disk($disk)->get($filename);
            $contentType = Storage::disk($disk)->mimeType($filename);
            return response($file, 200)->header('Content-Type', $contentType);
        } else {
            abort(404, 'File not found');
        }
    }
    public function storageKTP($filename)
    {
        $user = Auth::user();

        if ($user->role->role_name === 'Ketua RT') {
            return $this->serveFile('storage_ktp', $filename);
        } else if ($user->role->role_name === 'Penduduk') {
            $kk = KartuKeluarga::where('kartu_keluarga_id', $user->penduduk->kartu_keluarga_id)->first();
            $kk->load('penduduk');
            $pendudukFiles = Penduduk::where('foto_ktp', $filename)->first();
            foreach ($kk->penduduk as $penduduk) {
                if ($penduduk->kartu_keluarga_id === $pendudukFiles->kartu_keluarga_id) {
                    return $this->serveFile('storage_ktp', $filename);
                }
            }
        }
        abort(403, 'Forbidden');
    }

    public function storageAnnouncement(string $filename)
    {
        return $this->serveFile('storage_announcement', $filename);
    }
    public function storageLisence(string $filename)
    {
        return $this->serveFile('storage_lisence', $filename);
    }

    public function storagePublic(string $filename)
    {
        return $this->serveFile('public', $filename);
    }
}
