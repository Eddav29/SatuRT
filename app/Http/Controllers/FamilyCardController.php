<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use App\Services\Implementation\FamilyCardServiceImplementation;
use Illuminate\Http\Request;

class FamilyCardController extends Controller
{
    private FamilyCardServiceImplementation $familyCardService;

    public function __construct(FamilyCardServiceImplementation $familyCardService)
    {
        $this->familyCardService = $familyCardService;
    }

    public function index()
    {
        $breadcrumb = [
            'list' => ['Menu', 'Penduduk', 'Data Penduduk'],
            'url' => ['dashboard', 'family-card.index']
        ];
        return view('pages.data-keluarga.index', compact('breadcrumb'));
    }

    public function create()
    {
        $breadcrumb = [
            'list' => ['Home', 'Penduduk', 'Data Penduduk', 'Tambah'],
            'url' => ['home', 'family-card.index', 'family-card.index', 'family-card.create']
        ];

        $jenis_kelamin = Penduduk::getListJenisKelamin();
        $agama = Penduduk::getListAgama();
        $status_keluarga = Penduduk::getListStatusHubunganDalamKeluarga();
        $status_perkawinan = Penduduk::getListStatusPerkawinan();
        $pendidikan_terakhir = Penduduk::getListPendidikanTerakhir();
        $golongan_darah = Penduduk::getListGolonganDarah();
        $status_penduduk = Penduduk::getListStatusPenduduk();
        return view('pages.data-keluarga.tambah.index', compact('breadcrumb'))->with([
            'jenis_kelamin' => $jenis_kelamin,
            'agama' => $agama,
            'status_keluarga' => $status_keluarga,
            'status_perkawinan' => $status_perkawinan,
            'pendidikan_terakhir' => $pendidikan_terakhir,
            'golongan_darah' => $golongan_darah,
            'status_penduduk' => $status_penduduk
        ]);
    }

    public function list()
    {
        return response()->json([
            'data' => $this->familyCardService->getFamilyCardList()
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => KartuKeluarga::find($id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string',
            'kepala_keluarga' => 'required|string',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|string',
        ]);

        $familyCard = KartuKeluarga::create($request->all());

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $familyCard
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kk' => 'required|string',
            'kepala_keluarga' => 'required|string',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'kode_pos' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'required|string',
        ]);

        $familyCard = KartuKeluarga::find($id);
        $familyCard->update($request->all());

        return response()->json([
            'message' => 'Data berhasil diubah',
            'data' => $familyCard
        ]);
    }

    public function destroy($id)
    {
        $familyCard = KartuKeluarga::find($id);
        $familyCard->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
