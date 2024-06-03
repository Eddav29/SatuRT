<?php

namespace App\Services\Implementation;

use App\Models\Informasi;
use App\Models\Penduduk;
use App\Models\UMKM;
use App\Services\HomeService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Database\Eloquent\Collection;

class HomeServiceImplementation implements HomeService
{
    public function getFourLastInformation(): Collection
    {
        try {
            $informations = Informasi::where('jenis_informasi', "!=", "Pengumuman")->orderBy('created_at', 'desc')->limit(4)->get();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $informations;
    }
    public function getThreeLastUMKM(): Collection
    {
        try {
            $businesses = UMKM::with('penduduk')->orderBy('created_at', 'desc')->limit(3)->get();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $businesses;
    }

    public function getLeader(): Penduduk
    {
        try {
            $leader = Penduduk::whereHas('user', function ($query) {
                $query->whereHas('role', function ($roleQuery) {
                    $roleQuery->where('role_name', 'Ketua RT');
                });
            })->with('user.role')->first();
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            abort(500, $e->getMessage());
        }

        return $leader;
    }
}
