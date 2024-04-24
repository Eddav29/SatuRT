<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinanceReportResource;
use App\Models\DetailKeuangan;
use App\Models\Keuangan;
use App\Models\Penduduk;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FinanceReportController extends Controller
{
    public function index(): Response
    {
        $data = $this->list();
        // Check if data is empty before decoding
        if (empty($data->getContent())) {
            $data = [];
        } else {
            $data = json_decode($data->getContent(), true);
        }

        $breadcrumb = [
            'list' => ['Home', 'Keuangan'],
            'url' => ['home', 'keuangan.index'],
        ];

        return response()->view('pages.keuangan.index', [
            'breadcrumb' => $breadcrumb,
            'data' => $data['data'] ?? [], // Set default value for 'data' if empty
            'total_pemasukan' => $data['total_pemasukan'] ?? 0, // Set default value for 'total_pemasukan' if empty
            'total_pengeluaran' => $data['total_pengeluaran'] ?? 0, // Set default value for 'total_pengeluaran' if empty
            'total_keseluruhan' => $data['total_keseluruhan'] ?? 0, // Set default value for 'total_keseluruhan' if empty
        ]);
    }

    public function create(): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Keuangan', 'Tambah Keuangan'],
            'url' => ['home', 'keuangan.index', 'keuangan.create'],
        ];
        return response()->view('pages.keuangan.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }
    public function list(): JsonResponse
    {
        try {
            $data = DetailKeuangan::all()->map(function ($keuangan) {
                return [
                    'detail_keuangan_id' => $keuangan->detail_keuangan_id,
                    'keuangan_id' => $keuangan->keuangan_id,
                    'judul' => $keuangan->judul,
                    'jenis_keuangan' => $keuangan->jenis_keuangan,
                    'asal_keuangan' => $keuangan->asal_keuangan,
                    'nominal' => $keuangan->nominal,
                    'keterangan' => $keuangan->keterangan,
                    'created_at' => Carbon::parse($keuangan->created_at)->format('d-m-Y'),
                    'updated_at' => Carbon::parse($keuangan->updated_at)->format('d-m-Y'),
                ];
            });

            // Hitung total pemasukan dan pengeluaran
            $totalPemasukan = $data->sum(function ($item) {
                return $item['jenis_keuangan'] === 'Pemasukan' ? $item['nominal'] : 0;
            });
            $totalPengeluaran = $data->sum(function ($item) {
                return $item['jenis_keuangan'] === 'Pengeluaran' ? $item['nominal'] : 0;
            });

            // Hitung total keseluruhan
            $totalKeseluruhan = Keuangan::orderBy('tanggal', 'desc')->first()->total_keuangan;

            return response()->json([
                'data' => $data,
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'total_keseluruhan' => $totalKeseluruhan,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Terjadi kesalahan.'], 500);
        }
    }


    public function store(Request $request): RedirectResponse
    {
        // Mendapatkan nilai ID terbesar dari tabel 'keuangan'
        $keuangan = DB::table('keuangan')->orderBy('tanggal', 'DESC')->first(); // Mendapatkan record terakhir
        $keuanganId = $keuangan->keuangan_id; // Ambil ID terbesar
        $pendudukId = $keuangan->penduduk_id; // Ambil penduduk terkait
        $total_keuangan = $keuangan->total_keuangan;
    
        // Tambahkan ID yang didapatkan ke permintaan
        $request['keuangan_id'] = $keuanganId;
    
        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'jenis_keuangan' => 'required',
            'asal_keuangan' => 'required',
            'nominal' => 'required|numeric', // Pastikan nominal adalah angka
            'keterangan' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
            
            // Membuat record baru di 'detail_keuangan'
            $detailKeuangan = DetailKeuangan::create($request->all());
    
            // Menambahkan entitas baru ke tabel 'keuangan'
            $nominal = $request->input('nominal');
            
            $keuangan = Keuangan::create([
                'keuangan_id' => $keuanganId,
                'penduduk_id' => $pendudukId,
                'total_keuangan' => $total_keuangan + $nominal, // Tambahkan nominal ke total sebelumnya
                'tanggal' => now(), // Set tanggal ke waktu sekarang
            ]);
            
            DB::commit();
    
            NotificationPusher::success('Data berhasil disimpan dan entitas baru ditambahkan ke tabel keuangan.');
            
            return redirect()->route('keuangan.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            NotificationPusher::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    


    public function show(string $id): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Keuangan', 'Detail Keuangan'],
            'url' => ['home', 'keuangan.index', ['keuangan.show', $id]],
        ];
        
        // Temukan detail keuangan berdasarkan ID
        $detailKeuangan = DetailKeuangan::with('keuangan')->find($id);

        // Jika tidak ditemukan, kembalikan respon error atau redirect
        if (!$detailKeuangan) {
            return redirect()->route('keuangan.index')->with('error', 'Detail Keuangan tidak ditemukan');
        }

        // Dapatkan keuangan yang terkait dengan detail tersebut
        $keuangan = $detailKeuangan->keuangan;  // Ambil dari relasi, jika ada
        
        // Pastikan relasi penduduk pada keuangan tersedia
        $penduduk = $keuangan ? $keuangan->penduduk : null;

        return response()->view('pages.keuangan.show', [
            'breadcrumb' => $breadcrumb,
            'keuangan' => $keuangan,
            'detailKeuangan' => $detailKeuangan,
            'penduduk' => $penduduk,
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('keuangan.show', ['keuangan' => $id]),
                'edit' => route('keuangan.edit', ['keuangan' => $id]),
                'hapus' => route('keuangan.destroy', ['keuangan' => $id]),
            ]
        ]);
    }


    public function edit(string $id): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Keuangan', 'Edit Keuangan'],
            'url' => ['home', 'keuangan.index', ['keuangan.edit', $id]],
        ];

        $detailKeuangan = DetailKeuangan::find($id);

        return response()->view('pages.keuangan.edit', [
            'breadcrumb' => $breadcrumb,
            'detailKeuangan' => $detailKeuangan,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('keuangan.show', ['keuangan' => $id]),
                'edit' => route('keuangan.edit', ['keuangan' => $id]),
                'hapus' => route('keuangan.destroy', ['keuangan' => $id]),
            ]
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        DetailKeuangan::find($id);

         // Validasi data yang diterima dari permintaan
         $validated = $request->validate([
            'keuangan_id' => 'required',
            'judul' => 'required',
            'jenis_keuangan' => 'required',
            'asal_keuangan' => 'required',
            'nominal' => 'required',
            // 'keterangan' => 'max:255',
        ]);
        try{
            // Membuat entri baru untuk DetailKeuangan
            $detailKeuangan = DetailKeuangan::update($validated);
            // Jika berhasil, redirect ke indeks halaman dengan pesan sukses
            return redirect()->route('keuangan.index')->with(['success' => 'Informasi baru ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->route('keuangan.index')->with(['error' => 'Informasi gagal ditambahkan']);
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            DetailKeuangan::delete($id);
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

    public function financeReport(string $id): FinanceReportResource
    {
        $financeReport = DetailKeuangan::with(['keuangan'])->find($id);

        if (!$financeReport) {
            throw new HttpResponseException(response()->json([
                'message' => 'Data not found',
            ])->setStatusCode(404));
        }

        return new FinanceReportResource($financeReport);
    }
}
