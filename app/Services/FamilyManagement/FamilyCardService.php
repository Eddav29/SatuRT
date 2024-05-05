<?php

namespace App\Services\FamilyManagement;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Services\Interfaces\DatatablesInterface;
use App\Services\Interfaces\RecordServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FamilyCardService implements RecordServiceInterface, DatatablesInterface
{

    public static function find(string $id): KartuKeluarga
    {
        return KartuKeluarga::findOrFail($id)->load('penduduk');
    }

    public static function all(): Collection
    {
        return KartuKeluarga::all();
    }

    public static function create(Request $request): Collection | Model
    {

        return KartuKeluarga::create([
            'nomor_kartu_keluarga' => $request->nomor_kartu_keluarga,
            'kota' => $request->kk_kota,
            'kecamatan' => $request->kk_kecamatan,
            'desa' => $request->kk_desa,
            'nomor_rt' => $request->kk_nomor_rt,
            'nomor_rw' => $request->kk_nomor_rw,
        ]);
    }

    public static function update(string $id, Request $request): Collection | Model
    {
        $familyCard = KartuKeluarga::findOrFail($id);
        $familyCard->update([
            'nomor_kartu_keluarga' => $request->nomor_kartu_keluarga,
            'kota' => $request->kk_kota,
            'kecamatan' => $request->kk_kecamatan,
            'desa' => $request->kk_desa,
            'nomor_rt' => $request->kk_nomor_rt,
            'nomor_rw' => $request->kk_nomor_rw,
        ]);
        return $familyCard;
    }

    public static function delete(string $id): bool
    {
        try {
            $familyCard = KartuKeluarga::findOrFail($id);
            if ($familyCard->penduduk()->count() > 0) {
                throw new \Exception('Kartu Keluarga ini memiliki anggota keluarga');
            }
            $familyCard->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getDatatable($id = null): Collection
    {
        $penduduk = Penduduk::with(['kartuKeluarga'])
        ->where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')
        ->get();
        $penduduk->map(function ($item) {
            $item->penduduk_count = Penduduk::where('kartu_keluarga_id', $item->kartu_keluarga_id)->count();
        });
        return $penduduk;
    }
}
