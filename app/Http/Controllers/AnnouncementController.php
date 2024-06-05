<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnnouncementResource;
use App\Models\Informasi;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnnouncementController extends Controller
{
    public function getAnnouncement(string $id): AnnouncementResource
    {
        try {
            $announcement = Informasi::with(['penduduk'])
                ->where('informasi_id', $id)
                ->first();
            $announcement['file_extension'] = $announcement->thumbnail_url ? pathinfo($announcement->thumbnail_url, PATHINFO_EXTENSION) : '';
            $announcement['file_type'] = $announcement->thumbnail_url ? $this->checkFile($announcement['file_extension']) : '';
    
            if (!$announcement) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Data not found',
                ])->setStatusCode(404));
            }
    
            return new AnnouncementResource($announcement);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
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
