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
use Carbon\Carbon;

class InventarisPeminjamanController extends Controller
{

    public function list(): JsonResponse
    {
        try {
            $formattedData = Inventaris_Detail::with('inventaris', 'penduduk')->orderBy('updated_at', 'DESC')->get()->map(function ($detail) {
                return [
                    'inventaris_detail_id' => $detail->inventaris_detail_id,
                    'nama_inventaris' => $detail->inventaris->nama_inventaris ?? '', 
                    'nama' => $detail->penduduk->nama ??'', 
                    'jumlah' => $detail->jumlah ?? '', 
                    'kondisi' => $detail->kondisi ?? '', 
                    'status' => $detail->status ?? '',
                    'tanggal_pinjam' => $detail->tanggal_pinjam ?? '',
                    'tanggal_kembali' => $detail->tanggal_kembali ?? '',
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
        // dd($peminjaman);
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
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('inventaris.peminjaman.show',  $id),
                'edit' => route('inventaris.peminjaman.edit',  $id),
                'hapus' => route('inventaris.peminjaman.destroy',  $id),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'inventaris_id' => 'required|exists:inventaris,inventaris_id',
            'penduduk_id' => 'required|exists:penduduk,penduduk_id',
            'jumlah' => 'required|integer|min:1', // pastikan jumlah yang dipinjam valid
            'kondisi' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
        ]);
    
        // Cek ketersediaan inventaris
        $inventaris = Inventaris::findOrFail($validated['inventaris_id']);
        if ($validated['jumlah'] > $inventaris->jumlah) {
            return redirect()->back()->with(['error' => 'Jumlah yang dipinjam melebihi jumlah inventaris yang tersedia']);
        }
    
        // Mengurangi jumlah inventaris yang tersedia
        $inventaris->decrement('jumlah', $validated['jumlah']);
    
        // Mengatur tanggal kembali otomatis 1 minggu setelah tanggal pinjam
        $validated['tanggal_kembali'] = Carbon::parse($validated['tanggal_pinjam'])->addWeek();
    
        // Mengatur status secara otomatis
        $validated['status'] = 'Dipinjam';
        
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
    
    public function update(Request $request, string $id): RedirectResponse
    {
        $peminjaman = Inventaris_Detail::find($id);
    
        $validated = $request->validate([
            'inventaris_id' => 'required|exists:inventaris,inventaris_id',
            'penduduk_id' => 'required|exists:penduduk,penduduk_id',
            'jumlah' => 'required|integer|min:1', // pastikan jumlah yang dikembalikan valid
            'kondisi' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);
    
        // Mengembalikan jumlah inventaris yang tersedia sebelumnya
        $inventarisLama = $peminjaman->inventaris;
        $inventarisLama->increment('jumlah', $peminjaman->jumlah);
    
        // Cek ketersediaan inventaris baru (jika ada)
        $inventarisBaru = Inventaris::findOrFail($validated['inventaris_id']);
        if ($validated['jumlah'] > $inventarisBaru->jumlah) {
            return redirect()->back()->with(['error' => 'Jumlah yang dikembalikan melebihi jumlah inventaris yang tersedia']);
        }
    
        // Mengurangi jumlah inventaris yang tersedia
        $inventarisBaru->decrement('jumlah', $validated['jumlah']);
    
        // Mengatur status secara otomatis berdasarkan tanggal kembali
        if ($request->has('tanggal_kembali')) {
            $validated['status'] = $request->tanggal_kembali > now() ? 'Dipinjam' : 'Dikembalikan';
        }
    
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

public function selesaikan(Request $request, String $id)
{
    $peminjaman = Inventaris_Detail::findOrFail($id);

    // Pastikan status peminjaman adalah 'Dipinjam'
    DB::beginTransaction();
    if ($peminjaman->status !== 'dipinjam') {
        return redirect()->back()->with(['error' => 'Status peminjaman tidak valid']);
    }
    try {
        // Mengatur status menjadi 'Dikembalikan'
        $peminjaman->update(['status' => 'Dikembalikan']);

        // Mengembalikan jumlah inventaris yang tersedia
        $inventaris = $peminjaman->inventaris;
        $inventaris->increment('jumlah', $peminjaman->jumlah);

        DB::commit();
        NotificationPusher::success('Pengembalian barang berhasil');
        return redirect()->back()->with(['success' => 'Pengembalian barang berhasil']);
    } catch (\Exception $e) {
        DB::rollback();
        NotificationPusher::error('Gagal melakukan pengembalian barang: ' . $e->getMessage());
        return redirect()->back()->with(['error' => 'Gagal melakukan pengembalian barang: ' . $e->getMessage()]);
    }
}

}
