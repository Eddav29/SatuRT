<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\UMKM;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessUserController extends Controller
{
    public function index(){
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
            $data = UMKM::all()->map(function ($umkm) {
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

            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function create(){
        $penduduk = Penduduk::all();

        $breadcrumb = [
            'list' => ['Home', 'UMKM', 'Tambah UMKM'],
            'url' => ['home', 'umkm.index','umkm.create'],
        ];
        return response()->view('pages.umkm.create', [
            'breadcrumb' => $breadcrumb, 'penduduk'=>$penduduk
        ]);
    }



    public function store(Request $request){
        $request->validate([
            'umkm_id' => 'required|char|max:36|unique:umkm,umkm_id',
            'nama_umkm'         => 'required|string|max:255',
            'jenis_umkm'        => 'required|in:Makanan,Minuman,Pakaian,Peralatan,Jasa,Lainnya',
            'keterangan'        => 'required|string|max:255',
            'alamat'            => 'required|string|max:255',
            'nomor_telepon'     => 'required|string|max:255',
            'lokasi_url'        => 'required|string|max:255',
            'thumbnail_url'     => 'required|string|max:255',
            'status'            => 'required|in:Aktif,Nonaktif',
            'license_image_url' => 'required|string|max:255',
            'penduduk_id'       => 'required|char',
        ]);

        UMKM::create([
            'umkm_id'           => $request->umkm_id,
            'nama_umkm'         => $request->nama_umkm,
            'jenis_umkm'        => $request->jenis_umkm,
            'keterangan'        => $request->keterangan,
            'alamat'            => $request->alamat,
            'nomor_telepeon'    => $request->nomor_telepon,
            'lokasi_url'        => $request->lokasi_url,
            'thumbnail_url'     => $request->thumbnail_url,
            'status'            => $request->status,
            'license_image_url' => $request->license_image_url,
            'penduduk_id'       => $request->penduduk_id
        ]);

        return redirect('umkm.index')->with('success', 'Data UMKM berhasil ditambah');


    }

    public function show(string $id){
        $umkm = UMKM::with('penduduk')->find($id);
        $penduduk = Penduduk::all();

        $breadcrumb = [
            'list' => ['Home', 'UMKM', 'Detail UMKM'],
            'url' => ['home', 'umkm.index',['umkm.show', $id]],
        ];
        return response()->view('pages.umkm.show', [
            'breadcrumb' => $breadcrumb, 'penduduk'=>$penduduk, 'umkm'=>$umkm
        ]);
    }

    public function edit(string $id): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'UMKM', 'Edit Data UMKM'],
            'url' => ['home', 'umkm.index', 'umkm.edit'],
        ];
        $penduduk = Penduduk::all();
        $umkm = UMKM::find($id);

        return response()->view('pages.umkm.edit', [
            'breadcrumb' => $breadcrumb, 'umkm' => $umkm, 'penduduk'=> $penduduk
        ]);
    }

    public function update(Request $request,string $id)
    {
        $umkm = UMKM::find($id);

        $validated = $request->validate([

        ]);
    }

    public function destroy(string $id){
        $check = UMKM::find($id);
        if(!$check){
            return redirect()->route('umkm.index')->with('error','Data UMKM tidak ditemukan');
        }

        try{
            UMKM::destroy($id);

            return redirect()->route('umkm.index')->with('success', 'Data UMKM berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('umkm.index')->with('errror', 'Data UMKM gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

}
