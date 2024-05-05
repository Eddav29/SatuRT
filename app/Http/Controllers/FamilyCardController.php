<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Services\FamilyManagement\CitizenService;
use App\Services\FamilyManagement\FamilyCardService;
use App\Services\FileManager\imageService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FamilyCardController extends Controller
{
    public function index()
    {
    $breadcrumb = [
        'list' => ['Menu', 'Penduduk', 'Data Penduduk'],
        'url' => ['dashboard', 'data-keluarga.index']
    ];
        return view('pages.data-penduduk.index', compact('breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Tambah Data Penduduk'],
            'url' => ['home', 'data-keluarga.index', 'data-keluarga.index', 'data-keluarga.create']
        ];
        return view('pages.data-penduduk.keluarga.tambah.index', compact('breadcrumb'))->with([
            'jenis_kelamin' => Penduduk::getListJenisKelamin(),
            'agama' => Penduduk::getListAgama(),
            'status_hubungan_dalam_keluarga' => ['Kepala Keluarga'],
            'status_perkawinan' => Penduduk::getListStatusPerkawinan(),
            'pendidikan_terakhir' => Penduduk::getListPendidikanTerakhir(),
            'golongan_darah' => Penduduk::getListGolonganDarah(),
            'status_penduduk' => Penduduk::getListStatusPenduduk()
        ]);
    }

    public function list()
    {
        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'timestamp' => now(),
            'data' => FamilyCardService::getDatatable()
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $url = $user->role->role_name === 'Ketua RT' ? ['home', 'data-keluarga.index', 'data-keluarga.index'] : ['dashboard', ['data-keluarga.show', [
            'keluarga' => $id
        ]], ['data-keluarga.show', [
            'keluarga' => $id
        ]]];
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Detail Data Keluarga'],
            'url' => $url
        ];
        $toolbar_route = $user->role->role_name === 'Ketua RT' ? [
            'detail' => route('data-keluarga.show', ['keluarga' => $id]),
            'edit' => route('data-keluarga.edit', ['keluarga' => $id]),
            'hapus' => route('data-keluarga.destroy', ['keluarga' => $id])
        ] : [
            'detail' => route('data-keluarga.show', ['keluarga' => $id])
        ];
        return view('pages.data-penduduk.keluarga.detail.index', [
            'id' => $id,
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => $toolbar_route,
            'familyCard' => FamilyCardService::find($id),
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nomor_kartu_keluarga' => 'required|numeric|digits:16|unique:kartu_keluarga,nomor_kartu_keluarga',
            'kk_kota' => 'required|string',
            'kk_kecamatan' => 'required|string',
            'kk_desa' => 'required|string',
            'kk_nomor_rt' => 'required|integer',
            'kk_nomor_rw' => 'required|integer',
            'nik' => 'required|numeric|digits:16',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'pekerjaan' => 'required|string',
            'status_hubungan_dalam_keluarga' => 'required|string|in:Kepala Keluarga,Istri,Anak,Cucu,Ayah,Ibu,Saudara,Mertua,Menantu,Cucu Menantu,Cicit,Keluarga Lain',
            'status_perkawinan' => 'required|string|in:Kawin,Belum Kawin,Cerai',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'nomor_rt' => 'required|integer',
            'nomor_rw' => 'required|integer',
            'pendidikan_terakhir' => 'required|string|in:SD,SMP,SMA,D3,S1,S2,S3',
            'golongan_darah' => 'required|string|in:A,B,AB,O',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_penduduk' => 'required|string|in:Domisili,Non Domisili',
            'images' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }
            NotificationPusher::error('Data gagal ditambahkan');
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $familyCard = FamilyCardService::create($request);
            $request['kartu_keluarga_id'] = $familyCard->kartu_keluarga_id;

            $imageName = imageService::uploadFile('storage_ktp', $request);
            $request->merge(['foto_ktp' => route('storage.ktp', ['filename' => $imageName])]);
            CitizenService::create($request);

            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil ditambahkan',
                    'timestamp' => now(),
                    'data' => $familyCard->load('penduduk')
                ], 200);
            }
            DB::commit();
            NotificationPusher::success('Data berhasil ditambahkan');
            if ($request->has('save_and_more')) {
                return redirect()->route('data-keluarga.create');
            }
            return redirect()->route('data-keluarga.index');
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                throw $e;
            }
            DB::rollBack();
            if (isset($imageName) && file_exists(storage_path('app/' . $imageName))) {
                unlink(storage_path('app/' . $imageName));
            }
            NotificationPusher::error($e->getMessage());
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $url = $user->role->role_name === 'Ketua RT' ? ['home', 'data-keluarga.index', 'data-keluarga.index'] : ['dashboard', ['data-keluarga.show', [
            'keluarga' => $id
        ]], ['data-keluarga.show', [
            'keluarga' => $id
        ]], ['data-keluarga.edit', [
            'keluarga' => $id
        ]]];
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Edit Data Keluarga'],
            'url' => $url
        ];
        return view('pages.data-penduduk.keluarga.edit.index', [
            'id' => $id,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('data-keluarga.show', ['keluarga' => $id]),
                'edit' => route('data-keluarga.edit', ['keluarga' => $id]),
                'hapus' => route('data-keluarga.destroy', ['keluarga' => $id])
            ],
            'familyCard' => FamilyCardService::find($id),
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make([
            'nomor_kartu_keluarga' => $request->nomor_kartu_keluarga,
            'kk_kota' => $request->kk_kota,
            'kk_kecamatan' => $request->kk_kecamatan,
            'kk_desa' => $request->kk_desa,
            'kk_nomor_rt' => $request->kk_nomor_rt,
            'kk_nomor_rw' => $request->kk_nomor_rw,
        ], [
            'nomor_kartu_keluarga' => 'unique:kartu_keluarga,nomor_kartu_keluarga,' . $id . ',kartu_keluarga_id',
            'kk_kota' => 'required|string',
            'kk_kecamatan' => 'required|string',
            'kk_desa' => 'required|string',
            'kk_nomor_rt' => 'required|integer',
            'kk_nomor_rw' => 'required|integer',
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }
            NotificationPusher::error('Data gagal diubah');
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $familyCard = FamilyCardService::update($id, $request);
            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil diubah',
                    'timestamp' => now(),
                    'data' => $familyCard
                ], 200);
            }
            DB::commit();
            NotificationPusher::success('Data berhasil diubah');
            return redirect()->route('data-keluarga.index');
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->ajax() || $request->wantsJson()) {
                throw $e;
            }
            DB::rollBack();
            NotificationPusher::error($e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy($id): JsonResponse | RedirectResponse
    {
        try {
            FamilyCardService::delete($id);
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil dihapus',
                'timestamp' => now()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now()
            ], 500);
        }
    }
}
