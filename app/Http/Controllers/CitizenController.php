<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Role;
use App\Services\AccountManagement\UserService;
use App\Services\FamilyManagement\CitizenService;
use App\Services\FamilyManagement\FamilyCardService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CitizenController extends Controller
{
    public function index($keluargaid)
    {
        $user = Auth::user();
        $url = $user->role->role_name === 'Ketua RT' ? ['home', 'data-keluarga.index', 'data-keluarga.index', ['data-anggota.show', [
            'keluargaid' => $keluargaid,
            'anggotum' => $user->penduduk->penduduk_id
        ]]] : ['dashboard', ['data-keluarga.show', [
            'keluarga' => $user->penduduk->kartu_keluarga_id,
        ]], ['data-keluarga.show', [
            'keluarga' => $user->penduduk->kartu_keluarga_id,
        ]], ['data-anggota.show', [
            'keluargaid' => $keluargaid,
            'anggotum' => $user->penduduk->penduduk_id
        ]]];
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Detail Data Penduduk'],
            'url' => $url
        ];
        return view('pages.data-penduduk.anggota.index', [
            'id' => $keluargaid,
            'active' => 'detail',
            'familyCard' => FamilyCardService::find($keluargaid),
            'breadcrumb' => $breadcrumb
        ]);
    }
    public function list($keluargaid = null)
    {
        if ($keluargaid) {
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'timestamp' => now(),
                'data' => CitizenService::getDatatable($keluargaid)
            ]);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'timestamp' => now(),
            'data' => CitizenService::getDatatable()
        ]);
    }

    public function show($keluargaid, $id)
    {
        $user = Auth::user();
        $url = $user->role->role_name === 'Ketua RT' ? ['home', 'data-keluarga.index', 'data-keluarga.index', ['data-anggota.show', [
            'keluargaid' => $keluargaid,
            'anggotum' => $id
        ]]] : ['dashboard', ['data-keluarga.show', [
            'keluarga' => $keluargaid
        ]], ['data-keluarga.show', [
            'keluarga' => $keluargaid
        ]], ['data-anggota.show', [
            'keluargaid' => $keluargaid,
            'anggotum' => $id
        ]]];
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Detail Data Penduduk'],
            'url' => $url
        ];
        return view('pages.data-penduduk.anggota.detail.index', [
            'id' => $id,
            'toolbar_id' => $keluargaid,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('data-anggota.show', ['keluargaid' => $keluargaid, 'anggotum' => $id]),
                'edit' => route('data-anggota.edit', ['keluargaid' => $keluargaid, 'anggotum' => $id]),
                'hapus' => route('data-anggota.destroy', ['keluargaid' => $keluargaid, 'anggotum' => $id])
            ],
            'citizen' => CitizenService::find($id),
            'breadcrumb' => $breadcrumb
        ]);
    }
    public function create($id)
    {
        $user = Auth::user();
        $url = $user->role->role_name === 'Ketua RT' ? ['home', 'data-keluarga.index', 'data-keluarga.index', ['data-anggota.create', $id]] : ['dashboard', ['data-keluarga.show', [
            'keluarga' => $id
        ]], ['data-keluarga.show', [
            'keluarga' => $id
        ]], ['data-anggota.create', $id]];
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Tambah Data Penduduk'],
            'url' => $url
        ];

        return view('pages.data-penduduk.anggota.tambah.index', compact('breadcrumb'))->with([
            'id' => $id,
            'jenis_kelamin' => Penduduk::getListJenisKelamin(),
            'agama' => Penduduk::getListAgama(),
            'status_hubungan_dalam_keluarga' => array_diff(Penduduk::getListStatusHubunganDalamKeluarga(), ['Kepala Keluarga']),
            'status_perkawinan' => Penduduk::getListStatusPerkawinan(),
            'pendidikan_terakhir' => Penduduk::getListPendidikanTerakhir(),
            'golongan_darah' => Penduduk::getListGolonganDarah(),
            'status_penduduk' => Penduduk::getListStatusPenduduk(),
            'familyCard' => FamilyCardService::find($id),
            'extension' => 'jpg,jpeg,png,webp',
            'canCreateAccount' => Auth::user()->role->role_name === 'Ketua RT' ? true : false,
        ]);
    }

    public function store(Request $request,  $keluargaid)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'pekerjaan' => 'required|string',
            'status_hubungan_dalam_keluarga' => 'required|string|in:Kepala Keluarga,Istri,Anak,Cucu,Ayah,Ibu,Saudara,Mertua,Menantu,Cucu Menantu,Cicit,Keluarga Lain',
            'status_perkawinan' => 'required|string|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'nomor_rt' => 'required|integer',
            'nomor_rw' => 'required|integer',
            'status_kehidupan' => $request->filled('status_kehidupan') ? 'required|string|in:Hidup,Meninggal' : '',
            'pendidikan_terakhir' => 'required|string|in:SD,SMP,SMA,D3,S1,S2,S3',
            'golongan_darah' => 'required|string|in:A,B,AB,O',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_penduduk' => 'required|string|in:Domisili,Non Domisili',
            'images' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'create_account' => 'nullable'
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                    'errors' => $validator->errors(),
                    'timestamp' => now()
                ], 400);
            }
            NotificationPusher::error('Data gagal disimpan');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $request['kartu_keluarga_id'] = $keluargaid;
            $citizen = CitizenService::create($request);
            if ($request->has('create_account')) {
                $request->merge([
                    'role_id' => Role::where('role_name', 'Penduduk')->first()->role_id,
                    'email' => null,
                    'username' => $request->nik,
                    'password' => $request->nik,
                ]);
                $account = UserService::create($request);
                $citizen->update(['user_id' => $account->user_id]);
            }
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 201,
                    'message' => 'Data berhasil disimpan',
                    'timestamp' => now(),
                    'data' => $citizen
                ], 201);
            }
            DB::commit();
            NotificationPusher::success('Data berhasil disimpan');
            if ($request->has('save_and_more')) {
                return redirect()->route('data-anggota.create', $keluargaid);
            }
            return redirect()->route('data-anggota.index', $keluargaid);
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'timestamp' => now()
                ], 500);
            }

            DB::rollBack();

            if (isset($imageName) && file_exists(storage_path('app/' . $imageName))) {
                unlink(storage_path('app/' . $imageName));
            }
            NotificationPusher::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function edit($keluargaid, $id)
    {
        $user = Auth::user();
        $url = $user->role->role_name === 'Ketua RT' ? ['home', 'data-keluarga.index', 'data-keluarga.index', ['data-anggota.show', [
            'keluargaid' => $keluargaid,
            'anggotum' => $id
        ]]] : ['dashboard', ['data-keluarga.show', [
            'keluarga' => $keluargaid
        ]], ['data-keluarga.show', [
            'keluarga' => $keluargaid
        ]], ['data-anggota.edit', [
            'keluargaid' => $keluargaid,
            'anggotum' => $id
        ]]];
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Edit Data Penduduk'],
            'url' => $url
        ];

        return view('pages.data-penduduk.anggota.edit.index', compact('breadcrumb'))->with([
            'id' => $id,
            'toolbar_id' => $keluargaid,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('data-anggota.show', ['keluargaid' => $keluargaid, 'anggotum' => $id]),
                'edit' => route('data-anggota.edit', ['keluargaid' => $keluargaid, 'anggotum' => $id]),
                'hapus' => route('data-anggota.destroy', ['keluargaid' => $keluargaid, 'anggotum' => $id])
            ],
            'jenis_kelamin' => Penduduk::getListJenisKelamin(),
            'agama' => Penduduk::getListAgama(),
            'status_hubungan_dalam_keluarga' => Penduduk::getListStatusHubunganDalamKeluarga(),
            'status_perkawinan' => Penduduk::getListStatusPerkawinan(),
            'pendidikan_terakhir' => Penduduk::getListPendidikanTerakhir(),
            'golongan_darah' => Penduduk::getListGolonganDarah(),
            'status_penduduk' => Penduduk::getListStatusPenduduk(),
            'status_kehidupan' => Penduduk::getListStatusKehidupan(),
            'citizen' => CitizenService::find($id),
            'extension' => 'jpg,jpeg,png,webp'
        ]);
    }

    public function update(Request $request, $keluargaid, $id)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'pekerjaan' => 'required|string',
            'status_hubungan_dalam_keluarga' => 'required|string|in:Kepala Keluarga,Istri,Anak,Cucu,Ayah,Ibu,Saudara,Mertua,Menantu,Cucu Menantu,Cicit,Keluarga Lain',
            'status_perkawinan' => 'required|string|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'nomor_rt' => 'required|integer',
            'nomor_rw' => 'required|integer',
            'status_kehidupan' => $request->filled('status_kehidupan') ? 'required|string|in:Hidup,Meninggal' : '',
            'pendidikan_terakhir' => 'required|string|in:SD,SMP,SMA,D3,S1,S2,S3',
            'golongan_darah' => 'required|string|in:A,B,AB,O',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_penduduk' => 'required|string|in:Domisili,Non Domisili',
            'images' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if ($validator->fails()) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                    'errors' => $validator->errors(),
                    'timestamp' => now()
                ], 400);
            }
            NotificationPusher::error('Data gagal disimpan');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $request['kartu_keluarga_id'] = $keluargaid;
            $citizen = CitizenService::update($id, $request);
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil diupdate',
                    'timestamp' => now(),
                    'data' => $citizen
                ]);
            }
            DB::commit();
            NotificationPusher::success('Data berhasil diupdate');
            return redirect()->route('data-anggota.index', $keluargaid);
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'timestamp' => now()
                ], 500);
            }
            DB::rollBack();
            if (isset($imageName) && file_exists(storage_path('app/' . $imageName))) {
                unlink(storage_path('app/' . $imageName));
            }
            NotificationPusher::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function destroy($keluargaid, $id)
    {
        try {
            $user = Auth::user();
            $service = CitizenService::find($id);
            $count = Penduduk::where('kartu_keluarga_id', $service->kartu_keluarga_id)->count();

            if ($service && $service->user_id !== $user->user_id) {

                CitizenService::delete($id);
                $response = [
                    'code' => 200,
                    'message' => 'Data berhasil dihapus',
                    'timestamp' => now(),
                ];
                if ($count === 1) {
                    $response['redirect'] = route('data-keluarga.index');
                }
                return response()->json($response);
            } else {
                return response()->json([
                    'code' => 403,
                    'message' => 'Anda tidak memiliki akses untuk menghapus data ini',
                    'timestamp' => now()
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now()
            ], 500);
        }
    }
}
