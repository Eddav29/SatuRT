<?php

namespace App\Services\FamilyManagement;

use App\Models\Penduduk;
use App\Services\Interfaces\CRUDServiceInterface;
use App\Services\Interfaces\DatatablesInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CitizenService implements CRUDServiceInterface, DatatablesInterface
{
    public static function all(): Collection
    {
        return Penduduk::all();
    }

    public static function find(string $id): Penduduk
    {
        return Penduduk::findOrFail($id);
    }

    public static function create(Request $request): Collection | Model
    {
        return Penduduk::create($request->only([
            'kartu_keluarga_id',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'agama',
            'status_hubungan_dalam_keluarga',
            'status_perkawinan',
            'kota',
            'kecamatan',
            'desa',
            'nomor_rt',
            'nomor_rw',
            'pekerjaan',
            'pendidikan_terakhir',
            'gologan_darah',
            'status_penduduk',
            'foto_ktp'
        ]));
    }

    public static function update(string $id, Request $request): Collection | Model
    {
        $citizen = Penduduk::findOrFail($id);
        $citizen->update($request->only([
            'kartu_keluarga_id',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'golongan_darah',
            'agama',
            'status_hubungan_dalam_keluarga',
            'status_perkawinan',
            'kota',
            'kecamatan',
            'desa',
            'nomor_rt',
            'nomor_rw',
            'pekerjaan',
            'pendidikan_terakhir',
            'gologan_darah',
            'status_penduduk',
            'foto_ktp'
        ]));
        return $citizen;
    }

    public static function delete(string $id): bool
    {
        try {
            $citizen = Penduduk::findOrFail($id);
            $citizen->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getDatatable($id = null): Collection
    {
        return Penduduk::where('kartu_keluarga_id', $id)->get();
    }
}
