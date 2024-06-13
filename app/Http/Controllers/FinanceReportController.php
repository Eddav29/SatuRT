<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinanceReportResource;
use App\Models\DetailKeuangan;
use App\Models\Keuangan;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $dataSemuaTahun = DetailKeuangan::orderBy('updated_at', 'DESC')->get()->map(function ($keuangan) {
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
            $totalKeseluruhan = Keuangan::orderBy('keuangan_id', 'DESC')->first()->total_keuangan ?? 0;

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
        $oldKeuangan = $previousKeuangan = Keuangan::orderBy('keuangan_id', 'desc')->first();
        $keuanganId = $oldKeuangan ? $oldKeuangan->keuangan_id : 0;
        $pendudukId = Auth::user()->penduduk->penduduk_id;
        $total_keuangan = $oldKeuangan ? $oldKeuangan->total_keuangan : 0;
        // dd($total_keuangan);

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

        $nominal = $detailKeuangan->nominal;

        
        $previousKeuangan = Keuangan::orderBy('keuangan_id', 'desc')->skip(1)->first();
        $saldoSebelum = $previousKeuangan ? $previousKeuangan->total_keuangan : 0;
        $saldoSesudah =   Keuangan::orderBy('keuangan_id', 'DESC')->first()->total_keuangan ?? 0;
    
        return response()->view('pages.keuangan.show', [
            'saldoSebelum' => $saldoSebelum,
            'saldoSesudah' => $saldoSesudah,
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
            $keuangan = Keuangan::latest()->first();

            // Dapatkan nominal baru dari permintaan
            $newNominal = $request->input('nominal');

            // Hitung selisih nominal
            $difference = $newNominal - $oldNominal;
            $total_keuangan = $keuangan->total_keuangan;

            // Perbarui total_keuangan berdasarkan jenis keuangan
            if ($detailKeuangan->jenis_keuangan == "Pemasukan") {
                $total_keuangan += $difference; // Tambahkan selisih ke total sebelumnya
            } else {
                $total_keuangan -= $difference; // Kurangi selisih dari total sebelumnya
            }

            Keuangan::create([
                'penduduk_id' => $keuangan->penduduk_id,
                'total_keuangan' => $total_keuangan,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]); // Simpan perubahan di 'keuangan'

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
        
        $keuangan = Keuangan::latest()->first();
    
        try {
            DB::beginTransaction();
            
            // Sesuaikan total_keuangan berdasarkan jenis transaksi
            if ($detailKeuangan->jenis_keuangan === 'Pemasukan') {
                $keuangan->total_keuangan -= $detailKeuangan->nominal;
            } elseif ($detailKeuangan->jenis_keuangan === 'Pengeluaran') {
                $keuangan->total_keuangan += $detailKeuangan->nominal;
            }
    
            // Simpan total_keuangan yang sudah disesuaikan
            $keuangan->save();
    
            // Hapus entri detail_keuangan
            $detailKeuangan->delete();
    
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil dihapus',
                'timestamp' => now(),
                'redirect' => route('keuangan.index')
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
        try {
            $financeReport = DetailKeuangan::with(['keuangan'])->find($id);

            if (!$financeReport) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Data not found',
                ])->setStatusCode(404));
            }

            return new FinanceReportResource($financeReport);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function listByYear(string $year): JsonResponse
    {
        try {
            $data = $this->filterFinanceTrend($year);

            return response()->json(
                [
                    'code' => 200,
                    'data' => $data
                ]
            );

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage(),
                'timestamp' => now()
            ], 500);
        }
    }

    private function filterFinanceTrend(string $year): array
    {
        if ($year != '5 Tahun Terakhir') {
            return $this->getMonthlyFinanceReport($year);
        }

        return $this->getTotalFinanceFiveYearAgo();
    }

    private function getMonthlyFinanceReport(string $year): array
    {
        $results = DB::select("
        SELECT jenis_keuangan, MONTH(created_at) as month, SUM(nominal) as nominal
        FROM detail_keuangan
        WHERE jenis_keuangan IN ('Pemasukan', 'Pengeluaran') AND YEAR(created_at) = $year
        GROUP BY jenis_keuangan, MONTH(created_at)");

        $monthly = [];

        $range = range(1, 12);

        foreach ($range as $month) {
            $monthly['expenses'][$month] = 0;
            $monthly['incomes'][$month] = 0;

            foreach ($results as $result) {
                if ($result->month == $month) {
                    if ($result->jenis_keuangan == 'Pemasukan') {
                        $monthly['incomes'][$month] = $result->nominal;
                    } elseif ($result->jenis_keuangan == 'Pengeluaran') {
                        $monthly['expenses'][$month] = $result->nominal;
                    }
                }
            }
        }

        return $monthly;
    }

    private function getTotalFinanceFiveYearAgo(): array
    {
        $currentYear = date('Y');
        $startYear = $currentYear - 4;

        $yearly = [
            'expenses' => array_fill_keys(range($startYear, $currentYear), 0),
            'incomes' => array_fill_keys(range($startYear, $currentYear), 0)
        ];

        $results = DB::select("
        SELECT
            jenis_keuangan as 'Jenis_Keuangan',
            SUM(nominal) as 'Nominal',
            YEAR(created_at) as 'YEAR'
        FROM detail_keuangan
        WHERE
            YEAR(created_at) >= YEAR(NOW()) - 4
        GROUP BY YEAR(created_at), jenis_keuangan
        ORDER BY YEAR(created_at)");

        foreach ($results as $result) {
            if ($result->Jenis_Keuangan == 'Pengeluaran') {
                $yearly['expenses'][$result->YEAR] = $result->Nominal;
            } else {
                $yearly['incomes'][$result->YEAR] = $result->Nominal;
            }
        }

        return $yearly;
    }
}
