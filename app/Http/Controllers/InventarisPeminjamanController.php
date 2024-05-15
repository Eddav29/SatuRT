<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Inventaris_Detail;
use App\Models\Penduduk;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventarisPeminjamanController extends Controller
{
    public function list(): JsonResponse
    {
        try {

            $formattedData = Inventaris_Detail::orderBy('created_at','DESC')->get()->map(function ($detail) {
                return [
                    'inventaris_detail_id' => $detail->inventaris_detail_id,
                    'inventaris_id' => $detail->inventaris_id,
                    'penduduk_id' => $detail->penduduk_id,
                    'jumlah' => $detail->jumlah,
                    'kondisi' => $detail->kondisi,
                    'tanggal_pinjam' => $detail->tanggal_pinjam,
                    'tanggal_kembali' => $detail->tanggal_kembali,
                ];
            });

            return response()->json(['data' => $formattedData], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function index(): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Peminjaman'],
            'url' => ['home', 'inventaris.peminjaman.index'],
        ];

        $peminjaman = Inventaris_Detail::all();

        return response()->view('pages.inventaris.peminjaman.index', [
            'breadcrumb' => $breadcrumb,
            'peminjaman' => $peminjaman,
        ]);
    }

    public function show(string $id): Response
    {
        $peminjaman = Inventaris_Detail::find($id);

        $breadcrumb = [
            'list' => ['Home', 'Peminjaman', 'Detail Peminjaman'],
            'url' => ['home', 'inventaris.peminjaman.index', ['inventaris.peminjaman.show', $id]],
        ];

        return response()->view('pages.inventaris.peminjaman.show', [
            'peminjaman' => $peminjaman,
            'breadcrumb' => $breadcrumb,
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('inventaris.peminjaman.show',  $id),
                'edit' => route('inventaris.peminjaman.edit',  $id),
                'hapus' => route('inventaris.peminjaman.destroy',  $id),
            ],
        ]);
    }

    public function create(): Response
    {
        $inventaris = Inventaris::all();
        $penduduk = Penduduk::all();

        $breadcrumb = [
            'list' => ['Home', 'Peminjaman', 'Tambah Peminjaman'],
            'url' => ['home', 'inventaris.peminjaman.index', 'inventaris.peminjaman.create'],
        ];

        return response()->view('pages.inventaris.peminjaman.create', [
            'breadcrumb' => $breadcrumb,
            'inventaris' => $inventaris,
            'penduduk' => $penduduk,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'inventaris_id' => 'required|exists:inventaris,inventaris_id',
            'penduduk_id' => 'required|exists:penduduk,penduduk_id',
            'jumlah' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            Inventaris_Detail::create($validated);

            DB::commit();
            NotificationPusher::success('Peminjaman berhasil disimpan');
            return redirect()->route('inventaris.peminjaman.index')->with(['success' => 'Peminjaman berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan peminjaman: ' . $e->getMessage());
            return redirect()->route('inventaris.peminjaman.index')->with(['error' => 'Gagal menyimpan peminjaman: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id): Response
    {
        $peminjaman = Inventaris_Detail::find($id);
        $inventaris = Inventaris::all();
        $penduduk = Penduduk::all();

        $breadcrumb = [
            'list' => ['Home', 'Peminjaman', 'Edit Peminjaman'],
            'url' => ['home', 'inventaris.peminjaman.index', ['inventaris.peminjaman.edit', $id]],
        ];

        return response()->view('pages.inventaris.peminjaman.edit', [
            'breadcrumb' => $breadcrumb,
            'peminjaman' => $peminjaman,
            'inventaris' => $inventaris,
            'penduduk' => $penduduk,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $peminjaman = Inventaris_Detail::find($id);

        $validated = $request->validate([
            'inventaris_id' => 'required|exists:inventaris,inventaris_id',
            'penduduk_id' => 'required|exists:penduduk,penduduk_id',
            'jumlah' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        DB::beginTransaction();

        try {
            $peminjaman->update($validated);

            DB::commit();
            NotificationPusher::success('Perubahan berhasil disimpan');
            return redirect()->route('inventaris.peminjaman.show', $id)->with(['success' => 'Perubahan berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan perubahan: ' . $e->getMessage());
            return redirect()->route('inventaris.peminjaman.show', $id)->with(['error' => 'Gagal menyimpan perubahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $peminjaman = Inventaris_Detail::findOrFail($id);

        try {
            DB::beginTransaction();

            $peminjaman->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil dihapus',
                'timestamp' => now(),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }
}
