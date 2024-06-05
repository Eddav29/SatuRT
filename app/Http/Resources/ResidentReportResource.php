<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResidentReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->pelaporan_id,
            'jenis_laporan' => $this->jenis_pelaporan,
            'attachment' => $this->image_url,
            'accepted_by' => $this->pengajuan->acceptedBy->nama ?? '-',
            'accepted_at' => Carbon::parse($this->pengajuan->accepted_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY'),
            'created_at' => Carbon::parse($this->pengajuan->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY'),
            'created_by' => $this->pengajuan->penduduk->nama,
            'purposes' => $this->pengajuan->keperluan,
            'status' => $this->pengajuan->status->nama,
            'description' => $this->pengajuan->keterangan,
        ];
    }
}
