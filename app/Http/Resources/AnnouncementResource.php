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
            'file_type' => $this->file_type,
            'file' => $this->thumbnail_url ?? null,
            'title' => $this->judul_informasi,
            'created_by' => $this->penduduk->nama,
            'created_at' => Carbon::parse($this->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY - HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY - HH:mm:ss'),
            'description' => $this->isi_informasi,
        ];
    }
}
