<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->informasi_id,
            'file_extension' => $this->file_extension,
            'file' => $this->thumbnail_url,
            'title' => $this->judul_informasi,
            'created_by' => $this->penduduk->nama,
            'created_at' => Carbon::parse($this->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY'),
            'description' => $this->isi_informasi,
        ];
    }
}
