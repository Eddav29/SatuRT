<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinanceReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->detail_keuangan_id,
            'title' => $this->judul,
            'finance_type' => $this->jenis_keuangan,
            'financial_origin' => $this->asal_keuangan,
            'amount' => $this->nominal,
            'description' => $this->keterangan,
            'created_at' => Carbon::parse($this->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY'),
            'updated_at' => Carbon::parse($this->updated_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY'),
            'balance_before' => $this->keuangan->total_keuangan,
            'balance_now' => $this->jenis_keuangan == 'Pemasukan' ? $this->keuangan->total_keuangan + $this->nominal : $this->keuangan->total_keuangan - $this->nominal
        ];
    }
}
