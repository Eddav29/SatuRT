<?php

namespace App\Services\FamilyManagement;

use App\Models\Penduduk;
use App\Services\ImageManager\ImageService;
use App\Services\Interfaces\DatatablesInterface;
use App\Services\Interfaces\RecordServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $request->merge(['status_kehidupan' => $request->has('status_kehidupan') ? $request->status_kehidupan : 'Hidup']);


        // Penanganan upload gambar
        if ($request->hasFile('images')) {
            try {
                $imageName = ImageService::uploadFile('storage_ktp', $request, 'images', 'webp');
                $request->merge(['foto_ktp' => $imageName]);
            } catch (\Exception $e) {
                throw new \Exception('Error uploading image: ' . $e->getMessage());
            }
        }

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
            'status_kehidupan',
            'pekerjaan',
            'pendidikan_terakhir',
            'status_penduduk',
            'foto_ktp'
        ]));
    }

    public static function update(string $id, Request $request): Collection | Model
    {
        $request->merge(['status_kehidupan' => $request->has('status_kehidupan') ? $request->status_kehidupan : 'Hidup']);

        $citizen = Penduduk::findOrFail($id);
        if ($request->hasFile('images')) {
            $newImage = $request->file('images')->getClientOriginalName();
            if ($citizen->foto_ktp !== $newImage) {
                $imageName = ImageService::uploadFile('storage_ktp', $request, 'images', 'webp');
                $request->merge(['foto_ktp' => $imageName]);
                if ($citizen->foto_ktp) {
                    ImageService::deleteFile('storage_ktp', $citizen->foto_ktp);
                }
            } else {
                $request->merge(['foto_ktp' => $citizen->foto_ktp]);
            }
        } else {
            if ($citizen->foto_ktp) {
                ImageService::deleteFile('storage_ktp', $citizen->foto_ktp);
            }
            $request->merge(['foto_ktp' => null]);
        }


        if ($request->status_hubungan_dalam_keluarga !== 'Kepala Keluarga' && Penduduk::where('kartu_keluarga_id', $citizen->kartu_keluarga_id)->where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')->count() === 1 && $citizen->status_hubungan_dalam_keluarga === 'Kepala Keluarga') {
            throw new \Exception('Kartu Keluarga harus memiliki kepala keluarga');
        }

        if ($request->status_hubungan_dalam_keluarga === 'Kepala Keluarga' && $citizen->status_hubungan_dalam_keluarga !== 'Kepala Keluarga') {
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
            'status_kehidupan',
            'pekerjaan',
            'pendidikan_terakhir',
            'status_penduduk',
            'foto_ktp'
        ]));
        return $citizen;
    }

    public static function delete(string $id): bool
    {
        DB::beginTransaction();

        try {
            $citizen = Penduduk::with(['kartuKeluarga', 'user'])->findOrFail($id);
            $familyMembersCount = Penduduk::where('kartu_keluarga_id', $citizen->kartu_keluarga_id)->count();

            if ($citizen->status_hubungan_dalam_keluarga === 'Kepala Keluarga' && $familyMembersCount > 1) {
                throw new \Exception('Hapus anggota keluarga terlebih dahulu');
            }
            if ($citizen->user && $citizen->user->role && $citizen->user->role->role_name === 'Ketua RT') {
                throw new \Exception('Ketua RT tidak dapat dihapus');
            }
            if ($citizen->status_hubungan_dalam_keluarga !== 'Kepala Keluarga' && $familyMembersCount === 1) {
                $citizen->kartuKeluarga->delete();
            } else {
                $citizen->delete();
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function getDatatable($id = null): Collection
    {
        $role = Auth::user()->role->role_name;
        return $role === "Ketua RT" ? Penduduk::select(
            'penduduk_id',
            'nama',
            'nik',
            'jenis_kelamin',
            'status_hubungan_dalam_keluarga'
        )->where('kartu_keluarga_id', $id)->get()->map(function ($penduduk) {
            $penduduk->nik = Str::mask($penduduk->nik, '*', 6);
            return $penduduk;
        })
            : Penduduk::select(
                'penduduk_id',
                'nama',
                'nik',
                'jenis_kelamin',
                'status_hubungan_dalam_keluarga'
            )->where('kartu_keluarga_id', $id)
            ->where('status_kehidupan', 'Hidup')->get()
            ->map(function ($penduduk) {
                $penduduk->nik = Str::mask($penduduk->nik, '*', 6);
                return $penduduk;
            });
    }
}
