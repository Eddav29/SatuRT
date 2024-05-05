<?php

namespace App\Services\FamilyManagement;

use App\Models\Penduduk;
use App\Services\FileManager\imageService;
use App\Services\Interfaces\DatatablesInterface;
use App\Services\Interfaces\RecordServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CitizenService implements RecordServiceInterface, DatatablesInterface
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
        $imageName = ImageService::uploadFile('storage_ktp', $request);
        $request->merge(['foto_ktp' => route('storage.ktp', ['filename' => $imageName])]);
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
        if ($request->hasFile('images')) {
            $imageName = imageService::uploadFile('storage_ktp', $request);
            $request->merge(['foto_ktp' => route('storage.ktp', ['filename' => $imageName])]);
            if ($citizen && $citizen->foto_ktp) {
                imageService::deleteFile('storage_ktp', $citizen->foto_ktp);
            }
        } else {
            $request->merge(['foto_ktp' => $citizen->foto_ktp]);
        }

        if ($request->status_hubungan_dalam_keluarga === 'Kepala Keluarga') {
            $leadCitizen = Penduduk::where('kartu_keluarga_id', $citizen->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')->first();
            $leadCitizen->update(['status_hubungan_dalam_keluarga' => null]);
        }
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
            $citizen = Penduduk::findOrFail($id)->load('kartuKeluarga');
            if ($citizen->status_hubungan_dalam_keluarga === 'Kepala Keluarga' && Penduduk::where('kartu_keluarga_id', $citizen->kartuKeluarga->kartu_keluarga_id)->count() > 1) {
                throw new \Exception('Hapus anggota keluarga terlebih dahulu');
            } else if (Penduduk::where('kartu_keluarga_id', $citizen->kartuKeluarga->kartu_keluarga_id)->count() === 1) {
                $citizen->kartuKeluarga->delete();
            }
            if ($citizen->user_id !== null) {
                $citizen->user->delete();
            }
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
