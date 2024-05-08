<?php

namespace App\Services\Implementation;

use App\Models\Informasi;
use App\Models\Penduduk;
use App\Models\UMKM;
use App\Services\HomeService;
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

    public function getLeader(): Penduduk
    {
        $leader = Penduduk::whereHas('user', function ($query) {
            $query->whereHas('role', function ($roleQuery) {
                $roleQuery->where('role_name', 'Ketua RT');
            });
        })->with('user.role')->first();

        return $leader;
    }
}
