<?php

namespace App\Services\Implementation;

use App\Models\Informasi;
use App\Models\UMKM;
use App\Services\Interfaces\HomeService;
use Illuminate\Database\Eloquent\Collection;

class HomeServiceImplementation implements HomeService
{
    public function getFourLastInformation(): Collection
    {
        $informations = Informasi::where('jenis_informasi', "!=", "Pengumuman")->orderBy('created_at', 'desc')->limit(4)->get();
        return $informations;
    }
    public function getThreeLastUMKM(): Collection
    {
        $businesses = UMKM::with('penduduk')->orderBy('created_at', 'desc')->limit(3)->get();
        return $businesses;
    }
}
