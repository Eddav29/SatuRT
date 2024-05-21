<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnnouncementResource;
use App\Models\Informasi;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnnouncementController extends Controller
{
    public function getAnnouncement(string $id): AnnouncementResource
    {
        $announcement = Informasi::with(['penduduk'])
            ->where('jenis_informasi', 'Pengumuman')
            ->orWhere('jenis_informasi', 'Dokumentasi Rapat')
            ->where('informasi_id', $id)
            ->first();
        $announcement['file_extension'] = pathinfo($announcement->thumbnail_url, PATHINFO_EXTENSION);
        $announcement['file_type'] = $this->checkFile($announcement['file_extension']);

        if (!$announcement) {
            throw new HttpResponseException(response()->json([
                'message' => 'Data not found',
            ])->setStatusCode(404));
        }

        return new AnnouncementResource($announcement);
    }

    private function checkFile(string $fileExtension): string
    {
        $imageExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

        if (in_array($fileExtension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($fileExtension, $fileExtensions)) {
            return 'file';
        }

        return '';
    }
}
