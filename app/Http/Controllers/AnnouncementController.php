<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Informasi;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function getAnnouncement(string $id): AnnouncementResource
    {
        $announcement = Informasi::with(['penduduk'])
            ->where('jenis_informasi', 'Pengumuman')
            ->where('informasi_id', $id)
            ->first();

        if (!$announcement) {
            throw new HttpResponseException(response()->json([
                'message' => 'Data not found',
            ])->setStatusCode(404));
        }

        return new AnnouncementResource($announcement);
    }
}
