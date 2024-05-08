<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    public function index(): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'inventaris'],
            'url' => ['home', 'inventaris.index'],
        ];
        return response()->view('pages.inventaris.index', [
            'breadcrumb' => $breadcrumb,
        ]);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $inventaris = Inventaris::find($id);

        $breadcrumb = [
            'list' => ['Home', 'Inventaris', 'Detail inventaris'],
            'url' => ['home', 'inventaris.index', ['inventaris.show', $id]],
        ];

        return response()->view('pages.inventaris.show', [
            'inventaris' => $inventaris,
            'breadcrumb' => $breadcrumb,
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('inventaris.show',  $id),
                'edit' => route('inventaris.edit',  $id),
                'hapus' => route('inventaris.destroy',  $id),
            ],
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventaris = Inventaris::find($id);

        $validated = $request->validate([
            'nama_inventaris' => 'required',
            'merk' => 'required',
            'warna' => 'required',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'jenis' => 'required',
            'sumber' => 'required',
            'keterangan' => 'required|string|max:255',
        ]);

        if ($request->foto_inventaris) {
            Storage::delete('public/inventaris_images/' . $inventaris->foto_inventaris);

            $imageFileName = $request->file('foto_inventaris')->store('inventaris_images', 'public');
            $inventaris['foto_inventaris'] = basename($imageFileName);
        }

        try {
            $inventaris->update([
                'nama_inventaris' => $validated['nama_inventaris'],
                'merk' => $validated['merk'],
                'warna' => $validated['warna'],
                'jumlah' => $validated['jumlah'],
                'kondisi' => $validated['kondisi'],
                'jenis' => $validated['jenis'],
                'sumber' => $validated['sumber'],
                'foto_inventaris' => $inventaris['foto_inventaris'],
                'keterangan' => $validated['keterangan'],
            ]);

            NotificationPusher::success('Perubahan berhasil disimpan');
            return redirect()->route('inventaris.show', $id)->with(['success' => 'Perubahan berhasil disimpan']);
        } catch (\Throwable $th) {
            NotificationPusher::error('Gagal menyimpan perubahan');
            return redirect()->route('inventaris.show', $id)->with(['error' => 'Gagal menyimpan perubahan']);
        }
    }

    public function list(): JsonResponse
    {
        try {
            $data = Inventaris::all()->map(function ($inventaris) {
                return [
                    'inventaris_id' => $inventaris->inventaris_id,
                    'nama_inventaris' => $inventaris->nama_inventaris,
                    'jumlah' => $inventaris->jumlah,
                    'kondisi' => $inventaris->kondisi,
                ];
            });

            return response()->json([
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function edit(string $id): Response
    {
        $inventaris = Inventaris::find($id);

        $breadcrumb = [
            'list' => ['Home', 'Inventaris', 'Edit inventaris'],
            'url' => ['home', 'inventaris.index', ['inventaris.edit', $id]],
        ];

        return response()->view('pages.inventaris.edit', [
            'breadcrumb' => $breadcrumb,
            'inventaris' => $inventaris,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('inventaris.show', $id),
                'edit' => route('inventaris.edit', $id),
                'hapus' => route('inventaris.destroy', $id),
            ],
        ]);
    }

    public function create()
    {
        $inventaris = Inventaris::all();

        $breadcrumb = [
            'list' => ['Home', 'Inventaris', 'Tambah inventaris'],
            'url' => ['home', 'inventaris.index', 'inventaris.create'],
        ];
        return response()->view('pages.inventaris.create', [
            'breadcrumb' => $breadcrumb,
            'inventaris' => $inventaris,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $pendudukId = Auth::user()->penduduk->penduduk_id;

        $merk = $request->input('merk') ?? '-';
        $warna = $request->input('warna') ?? '-';

        $validated = $request->validate([
            'nama_inventaris' => 'required',
            'jumlah' => 'required|integer',
            'kondisi' => 'required',
            'jenis' => 'required',
            'sumber' => 'required',
            'foto_inventaris' => 'required|file',
            'keterangan' => 'required|string|max:255',
        ]);

        $imageFileName = $request->file('foto_inventaris')->store('inventaris_images', 'public');
        $inventaris['foto_inventaris'] = basename($imageFileName);

        DB::beginTransaction();

        try {
            Inventaris::create([
                'penduduk_id' => $pendudukId,
                'nama_inventaris' => $validated['nama_inventaris'],
                'merk' => $merk,
                'warna' => $warna,
                'jumlah' => $validated['jumlah'],
                'kondisi' => $validated['kondisi'],
                'jenis' => $validated['jenis'],
                'sumber' => $validated['sumber'],
                'foto_inventaris' => $inventaris['foto_inventaris'],
                'keterangan' => $validated['keterangan'],
            ]);

            DB::commit();

            NotificationPusher::success('Data berhasil disimpan');
            return redirect()->route('inventaris.index')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->route('inventaris.index')->with(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function destroy(String $id): JsonResponse | RedirectResponse
    {
        $inventaris = Inventaris::findOrFail($id);

        try {
            DB::beginTransaction();

            $inventaris->delete();

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
