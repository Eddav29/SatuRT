<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\UMKM;
use App\Services\ImageManager\ImageService;
use App\Services\Notification\NotificationPusher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BusinessUserController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::all();
        $breadcrumb = [
            'list' => ['Home', 'UMKM'],
            'url' => ['home', 'umkm.index'],
        ];
        return response()->view('pages.umkm.index', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function list(): JsonResponse
    {
        try {

            if (Auth::user()->role->role_name === 'Ketua RT') {
                $data = UMKM::orderBy('updated_at', 'desc')->get()->map(function ($umkm) {
                    return [
                        'nik' => $umkm->penduduk->nik,
                        'nama' => $umkm->penduduk->nama,
                        'umkm_id' => $umkm->umkm_id,
                        'nama_umkm' => $umkm->nama_umkm,
                        'status' => $umkm->status,
                        'jenis_umkm' => $umkm->jenis_umkm,
                        'created_at' => Carbon::parse($umkm->created_at)->format('d-m-Y'),
                        'updated_at' => Carbon::parse($umkm->updated_at)->format('d-m-Y'),
                    ];
                });
            } else {
                $penduduk_id = Auth::user()->penduduk->penduduk_id;
                $data = UMKM::where('penduduk_id', $penduduk_id)->get()->map(function ($umkm) {
                    return [
                        'nik' => $umkm->penduduk->nik,
                        'nama' => $umkm->penduduk->nama,
                        'umkm_id' => $umkm->umkm_id,
                        'nama_umkm' => $umkm->nama_umkm,
                        'status' => $umkm->status,
                        'jenis_umkm' => $umkm->jenis_umkm,
                        'created_at' => Carbon::parse($umkm->created_at)->format('d-m-Y'),
                        'updated_at' => Carbon::parse($umkm->updated_at)->format('d-m-Y'),
                    ];
                });
            }


            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function create()
    {
        $penduduk = Penduduk::all();

        $breadcrumb = [
            'list' => ['Home', 'UMKM', 'Tambah UMKM'],
            'url' => ['home', 'umkm.index', 'umkm.create'],
        ];
        return response()->view('pages.umkm.create', [
            'breadcrumb' => $breadcrumb,
            'penduduk' => $penduduk,
            'extension' => 'jpg,jpeg,png,webp',
        ]);
    }



    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_umkm' => 'required|string|max:255',
            'jenis_umkm' => 'required|in:Makanan dan Minuman,Pakaian,Peralatan,Jasa,Lainnya',
            'keterangan' => 'required',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:255',
            'lokasi_url' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Aktif,Nonaktif',
            'lisence_image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nik' => ['required', 'exists:penduduk,nik']
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

        $request->merge(['penduduk_id' => Penduduk::where('nik', $request['nik'])->first()->penduduk_id]);
        $umkm = $request->all();

        try {
            $umkm['nama_umkm'] = Str::title($request['nama_umkm']);
            $umkm['alamat'] = Str::title($request['alamat']);
            $umkm['nama_umkm'] = Str::title($request['nama_umkm']);


            if ($request->hasFile('lisence_image_url')) {
                $imageName = ImageService::uploadFile('storage_lisence', $request, 'lisence_image_url', 'webp');
                $umkm['lisence_image_url'] = $imageName;
            } else {
                $umkm['lisence_image_url'] = null;
            }
            if ($request->hasFile('thumbnail_url')) {
                $umkm['thumbnail_url'] = ImageService::uploadFile('public', $request, 'thumbnail_url', 'webp');
            } else {
                $umkm['thumbnail_url'] = null;
            }

            DB::beginTransaction();
            $umkm = UMKM::create($umkm);
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 201,
                    'message' => 'Data UMKM berhasil disimpan',
                    'timestamp' => now(),
                    'data' => $umkm
                ]);
            }
            DB::commit();
            NotificationPusher::success('Data UMKM berhasil disimpan');
            return redirect()->route('umkm.index');
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'timestamp' => now()
                ]);
            }
            DB::rollBack();
            NotificationPusher::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(string $id)
    {
        $umkm = UMKM::with('penduduk')->find($id);
        $penduduk = Penduduk::all();

        $breadcrumb = [
            'list' => ['Home', 'UMKM', 'Detail UMKM'],
            'url' => ['home', 'umkm.index', 'umkm.index'],
        ];
        return response()->view('pages.umkm.show', [
            'breadcrumb' => $breadcrumb,
            'penduduk' => $penduduk,
            'umkm' => $umkm,
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('umkm.show', ['umkm' => $id]),
                'edit' => route('umkm.edit', ['umkm' => $id]),
                'hapus' => route('umkm.destroy', ['umkm' => $id]),
            ]
        ]);
    }

    public function edit(string $id): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'UMKM', 'Edit Data UMKM'],
            'url' => ['home', 'umkm.index', 'umkm.index'],
        ];
        $penduduk = Penduduk::all();
        $umkm = UMKM::find($id);

        return response()->view('pages.umkm.edit', [
            'breadcrumb' => $breadcrumb,
            'umkm' => $umkm,
            'penduduk' => $penduduk,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('umkm.show', ['umkm' => $id]),
                'edit' => route('umkm.edit', ['umkm' => $id]),
                'hapus' => route('umkm.destroy', ['umkm' => $id]),
            ],
            'extension' => 'jpg,jpeg,png,webp',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_umkm' => 'required|string|max:255',
            'jenis_umkm' => 'required|in:Makanan dan Minuman,Pakaian,Peralatan,Jasa,Lainnya',
            'keterangan' => 'required|string',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:255',
            'lokasi_url' => 'required|string|max:255',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Aktif,Nonaktif',
            'lisence_image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nik' => ['required', 'exists:penduduk,nik']
        ]);


        if ($validator->fails()) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                    'errors' => $validator->errors(),
                    'timestamp' => now()
                ]);
            }
            NotificationPusher::error('data gagal disimpan');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $request->merge(['penduduk_id' => Penduduk::where('nik', $request->nik)->first()->penduduk_id]);

        $umkmUpdate = $request->all();
        try {

            $umkmUpdate['nama_umkm'] = Str::title($request['nama_umkm']);
            $umkmUpdate['alamat'] = Str::title($request['alamat']);
            $umkmUpdate['nama_umkm'] = Str::title($request['nama_umkm']);
            DB::beginTransaction();
            $umkm = UMKM::find($id);

            if ($request->file('lisence_image_url')) {
                if (!empty($umkm->lisence_image_url)) {
                    ImageService::deleteFile('storage_lisence', $umkm->lisence_image_url);
                }
                $imageName = ImageService::uploadFile('storage_lisence', $request, 'lisence_image_url', 'webp');
                $umkmUpdate['lisence_image_url'] = $imageName;
            }
            if ($request->file('thumbnail_url')) {
                if (!empty($umkm->thumbnail_url)) {
                    ImageService::deleteFile('public', $umkm->thumbnail_url);
                }
                $umkmUpdate['thumbnail_url'] = ImageService::uploadFile('public', $request, 'thumbnail_url', 'webp');
            }


            $umkm->update($umkmUpdate);
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil diupdate',
                    'timestamp' => now(),
                    'data' => $umkm
                ]);
            }
            DB::commit();
            NotificationPusher::success('Data Berhasil diupdate');
            return redirect()->route('umkm.index')->with(['success' => 'Perubahan berhasil']);
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'timestamp' => now(),
                ]);
            }
            DB::rollBack();
            NotificationPusher::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {

        $check = UMKM::find($id);
        if (!$check) {
            return response()->json([
                'code' => 200,
                'message' => 'Data Tidak Ditemukan',
                'timestamp' => now(),
                'redirect' => route('umkm.index')
            ]);
        }

        try {

            UMKM::destroy($id);
            ImageService::deleteFile('public', $check->thumbnail_url);
            ImageService::deleteFile('storage_lisence', $check->lisence_image_url);
            return response()->json([
                'code' => 200,
                'message' => 'Data Berhasil Dihapus',
                'timestamp' => now(),
                'redirect' => route('umkm.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now()
            ]);
        }
    }
}
