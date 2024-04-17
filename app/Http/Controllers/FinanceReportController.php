<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinanceReportResource;
use App\Models\DetailKeuangan;
use App\Models\Keuangan;
use App\Models\Penduduk;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'keuangan_id' => ['required', 'exists:keuangan,keuangan_id'],
            'judul_keuangan' => 'required',
            'jenis_keuangan' => 'required',
            'asal_keuangan' => 'required|string',
            'nominal' => 'required|integer',

        ], [
            'keuangan_id.required' => 'ID keuangan harus diisi.',
            'judul_keuangan.required' => 'Judul keuangan harus diisi.',
            'jenis_keuangan.required' => 'Jenis keuangan harus diisi.',
            'asal_keuangan.required' => 'Asal keuangan harus diisi.',
            'nominal.required' => 'Nominal harus diisi.',

        ]);
    }

    public function show(string $id): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Keuangan', 'Detail Keuangan'],
            'url' => ['home', 'keuangan.index', ['keuangan.show', $id]],
        ];
        $detailKeuangan = DetailKeuangan::with('keuangan')->find($id);
        $keuangan = Keuangan::with('penduduk')->find($id);
        $penduduk = Penduduk::all();
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

    }

    public function destroy(string $id): RedirectResponse
    {

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
