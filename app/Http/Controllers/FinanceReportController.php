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
            'data' => $data['data'] ?? [],
            'total_pemasukan' => $data['total_pemasukan'] ?? 0,
            'total_pengeluaran' => $data['total_pengeluaran'] ?? 0,
            'total_keseluruhan' => $data['total_keseluruhan'] ?? 0,
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
            // Ambil semua data dari tabel 'DetailKeuangan'
            $dataSemuaTahun = DetailKeuangan::where('created_at', 'desc')->get()->map(function ($keuangan) {
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

            // Ambil data hanya dari tahun ini
            $dataTahunIni = $dataSemuaTahun->filter(function ($keuangan) {
                return Carbon::parse($keuangan['created_at'])->year == date('Y');
            });

            // Hitung total pemasukan dan pengeluaran untuk tahun ini
            $totalPemasukan = $dataTahunIni->sum(function ($item) {
                return $item['jenis_keuangan'] === 'Pemasukan' ? $item['nominal'] : 0;
            });
            $totalPengeluaran = $dataTahunIni->sum(function ($item) {
                return $item['jenis_keuangan'] === 'Pengeluaran' ? $item['nominal'] : 0;
            });

            // Hitung total keseluruhan dari data terakhir di 'Keuangan'
            $totalKeseluruhan = Keuangan::orderBy('tanggal', 'desc')->first()->total_keuangan;

            return response()->json([
                'data' => $dataSemuaTahun,
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
        $oldKeuangan = Keuangan::where('tanggal', 'DESC')->first();
        $keuanganId = $oldKeuangan ? $oldKeuangan->keuangan_id : 0;
        $pendudukId = Auth::user()->penduduk->penduduk_id;
        $total_keuangan = $oldKeuangan ? $oldKeuangan->total_keuangan : 0;

        DB::beginTransaction();

        if (!$oldKeuangan) {
            $keuangan = new Keuangan();
            $keuangan->penduduk_id = $pendudukId;
            $keuangan->total_keuangan = $request['jenis_keuangan'] == 'Pemasukan' ? $total_keuangan + $request['nominal'] : $total_keuangan - $request['nominal'];
            $keuangan->tanggal = now();
            $keuangan->created_at = now();
            $keuangan->updated_at = now();
            $keuangan->save();

            $keuanganId = $keuangan->keuangan_id;
            $total_keuangan = $keuangan->total_keuangan;
        }

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
            // Membuat record baru di 'detail_keuangan'
            $detailKeuangan = DetailKeuangan::create($request->all());

            // Menambahkan entitas baru ke tabel 'keuangan'
            $nominal = $request->input('nominal');

            if ($oldKeuangan && $detailKeuangan->jenis_keuangan == "Pemasukan") {
                $keuangan = Keuangan::create([
                    'keuangan_id' => $keuanganId,
                    'penduduk_id' => $pendudukId,
                    'total_keuangan' => $total_keuangan + $nominal, // Tambahkan nominal ke total sebelumnya
                    'tanggal' => now(), // Set tanggal ke waktu sekarang
                ]);
            } else if ($oldKeuangan && $detailKeuangan->jenis_keuangan == "Pengeluaran") {
                $keuangan = Keuangan::create([
                    'keuangan_id' => $keuanganId,
                    'penduduk_id' => $pendudukId,
                    'total_keuangan' => $total_keuangan - $nominal, // Tambahkan nominal ke total sebelumnya
                    'tanggal' => now(), // Set tanggal ke waktu sekarang
                ]);
            }

            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil diupdate',
                    'timestamp' => now(),
                    'data' => $keuangan
                ]);
            }
            DB::commit();

            NotificationPusher::success('Data berhasil disimpan dan entitas baru ditambahkan ke tabel keuangan.');

            return redirect()->route('keuangan.index');

        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil diupdate',
                    'timestamp' => now(),
                    'data' => $keuangan
                ]);
            }
            DB::rollBack();
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
        // Temukan detail keuangan dengan ID yang diberikan
        $detailKeuangan = DetailKeuangan::findOrFail($id);
        $idKeuangan = $detailKeuangan->keuangan_id;

        // Dapatkan nominal lama
        $oldNominal = $detailKeuangan->nominal;

        // Validasi data yang diterima dari permintaan
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'jenis_keuangan' => 'required',
            'asal_keuangan' => 'required',
            'nominal' => 'required|numeric', // Pastikan nominal adalah angka
            'keterangan' => 'required',
        ]);

        // Jika validasi gagal, kembalikan dengan kesalahan
        if ($validator->fails()) {
            NotificationPusher::error("Error: " . $validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Mulai transaksi untuk integritas data

            // Perbarui data di 'detail_keuangan'
            $detailKeuangan->update($request->only(['judul', 'keuangan_id', 'jenis_keuangan', 'asal_keuangan', 'nominal', 'keterangan']));

            // Ambil data 'keuangan' terkait
            $keuangan = Keuangan::find($idKeuangan);

            if (!$keuangan) {
                DB::rollBack(); // Batalkan transaksi jika tidak ada data
                return redirect()->back()->withErrors(['keuangan_id' => 'Data keuangan tidak ditemukan'])->withInput();
            }

            // Dapatkan nominal baru dari permintaan
            $newNominal = $request->input('nominal');

            // Hitung selisih nominal
            $difference = $newNominal - $oldNominal;

            // Perbarui total_keuangan berdasarkan jenis keuangan
            if ($detailKeuangan->jenis_keuangan == "Pemasukan") {
                $keuangan->total_keuangan += $difference; // Tambahkan selisih ke total sebelumnya
            } else {
                $keuangan->total_keuangan -= $difference; // Kurangi selisih dari total sebelumnya
            }

            $keuangan->save(); // Simpan perubahan di 'keuangan'

            DB::commit(); // Selesaikan transaksi

            NotificationPusher::success('Data berhasil diperbarui.');

            return redirect()->route('keuangan.index');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi error
            NotificationPusher::error("Terjadi kesalahan: " . $e->getMessage());
            return redirect()->back()->withInput(); // Kembalikan dengan kesalahan
        }
    }


    public function destroy(string $id): JsonResponse|RedirectResponse
    {
        // Temukan detail keuangan dengan ID yang diberikan
        $detailKeuangan = DetailKeuangan::findOrFail($id);
        $keuangan = Keuangan::findOrFail($detailKeuangan->keuangan_id);

        try {
            DB::beginTransaction();

            $detailKeuangan->delete();
            $keuangan->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil dihapus',
                'timestamp' => now()
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
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
