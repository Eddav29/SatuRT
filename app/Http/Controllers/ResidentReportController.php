<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResidentReportResource;
use App\Models\Pelaporan;
use App\Models\Pengajuan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\Notification\NotificationPusher;

class ResidentReportController extends Controller
{
    public function getResidentReport(string $id): ResidentReportResource
    {
        $residentReport = Pelaporan::with(['pengajuan', 'pengajuan.penduduk', 'pengajuan.status', 'pengajuan.acceptedBy'])->find($id);

        if (!$residentReport) {
            throw new HttpResponseException(response()->json([
                'message' => 'Data not found',
            ])->setStatusCode(404));
        }

        return new ResidentReportResource($residentReport);
    }

    public function index(): Response
    {
        if (Auth::user()->role->role_name == 'Ketua RT') {
            $breadcrumb = [
                'list' => ['Home', 'Pelaporan Warga'],
                'url' => ['home', 'pelaporan.index'],
            ];
            return response()->view('pages.resident-report.index', [
                'breadcrumb' => $breadcrumb,
            ]);
        } else {
            $breadcrumb = [
                'list' => ['Home', 'LAPOR!'],
                'url' => ['home', 'pelaporan.index'],
            ];
            return response()->view('pages.warga.report.index', [
                'breadcrumb' => $breadcrumb,
            ]);
        }

    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        if (Auth::user()->role->role_name == 'Ketua RT') {
            $pelaporan = Pelaporan::with('pengajuan')->find($id);

            $breadcrumb = [
                'list' => ['Home', 'Pelaporan', 'Detail Pelaporan'],
                'url' => ['home', 'pelaporan.index', ['pelaporan.show', $id]],
            ];

            return response()->view('pages.resident-report.show', [
                'pelaporan' => $pelaporan,
                'breadcrumb' => $breadcrumb,
            ]);
        } else {
            $pelaporan = Pelaporan::with('pengajuan')->find($id);

            $breadcrumb = [
                'list' => ['Home', 'LAPOR!', 'Detail Pelaporan'],
                'url' => ['home', 'pelaporan.index', ['pelaporan.show', $id]],
            ];

            return response()->view('pages.warga.report.show', [
                'pelaporan' => $pelaporan,
                'breadcrumb' => $breadcrumb,
                'toolbar_id' => $id,
                'active' => 'detail',
                'toolbar_route' => [
                    'detail' => route('pelaporan.show', ['pelaporan' => $id]),
                    'edit' => route('pelaporan.edit', ['pelaporan' => $id]),
                    'hapus' => route('pelaporan.destroy', ['pelaporan' => $id]),
                ],
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->role->role_name == 'Ketua RT') {
            $pelaporan = Pelaporan::find($id);
            $pengajuan = Pengajuan::find($pelaporan->pengajuan_id);

            $validated = $request->validate([
                'status_id' => 'required',
            ]);

            try {
                $pengajuan->update($validated);

                NotificationPusher::success('Status Pelaporan Berhasil diperbarui');
                return redirect()->route('pelaporan.index')->with(['success' => 'Status Pelaporan Berhasil diperbarui']);
            } catch (\Throwable $th) {
                NotificationPusher::error('Status Pelaporan Gagal Berhasil diperbarui');
                return redirect()->route('pelaporan.index')->with(['error' => 'Status Pelaporan Gagal Berhasil diperbarui']);
            }

        } else {
            $pelaporan = Pelaporan::find($id);
            $pengajuan = Pengajuan::find($pelaporan->pengajuan_id);

            $validated = $request->validate([
                'accepted_at' => 'required|date',
                'jenis_pelaporan' => 'required',
                'keterangan' => 'required',
            ]);

            try {
                $pelaporan->update($validated);
                $pengajuan->update($validated);

                NotificationPusher::success('Perubahan berhasil disimpan');
                return redirect()->route('pelaporan.show', ['pelaporan' => $id])->with(['success' => 'Perubahan berhasil disimpan']);
            } catch (\Throwable $th) {
                NotificationPusher::error('Gagal menyimpan perubahan');
                return redirect()->route('pelaporan.show', ['pelaporan' => $id])->with(['error' => 'Gagal menyimpan perubahan']);
            }
        }
    }

    public function list(): JsonResponse
    {
        try {
            if (Auth::user()->role->role_name == 'Ketua RT') {
                $data = Pelaporan::all()->map(function ($pelaporan) {
                    return [
                        'pelaporan_id' => $pelaporan->pelaporan_id,
                        'pelapor' => $pelaporan->pengajuan->penduduk->nama,
                        'status' => $pelaporan->pengajuan->status->nama,
                        'jenis_pelaporan' => $pelaporan->jenis_pelaporan,
                        'tanggal' => Carbon::parse($pelaporan->pengajuan->accepted_at)->format('d-m-Y'),
                    ];
                });

                return response()->json([
                    'data' => $data,
                ]);
            } else {
                $data = Pelaporan::whereHas('pengajuan', function ($query) {
                    $query->where('penduduk_id', auth()->user()->penduduk->penduduk_id);
                })->with('pengajuan')->get()->map(function ($pelaporan) {
                    return [
                        'pelaporan_id' => $pelaporan->pelaporan_id,
                        'pelapor' => $pelaporan->pengajuan->penduduk->nama,
                        'jenis_pelaporan' => $pelaporan->jenis_pelaporan,
                        'tanggal' => Carbon::parse($pelaporan->pengajuan->accepted_at)->format('d-m-Y'),
                    ];
                });

                return response()->json([
                    'data' => $data,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function create()
    {
        $pelaporan = Pelaporan::all();

        $breadcrumb = [
            'list' => ['Home', 'LAPOR!', 'Tambah Pelaporan'],
            'url' => ['home', 'pelaporan.index', 'pelaporan.create'],
        ];
        return response()->view('pages.warga.report.create', [
            'breadcrumb' => $breadcrumb,
            'pelaporan' => $pelaporan,
        ]);
    }

    public function edit(string $id): Response
    {
        $pelaporan = Pelaporan::find($id);

        $breadcrumb = [
            'list' => ['Home', 'LAPOR!', 'Edit Pelaporan'],
            'url' => ['home', 'pelaporan.index', ['pelaporan.edit', $id]],
        ];

        return response()->view('pages.warga.report.edit', [
            'breadcrumb' => $breadcrumb,
            'pelaporan' => $pelaporan,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('pelaporan.show', ['pelaporan' => $id]),
                'edit' => route('pelaporan.edit', ['pelaporan' => $id]),
                'hapus' => route('pelaporan.destroy', ['pelaporan' => $id]),
            ]
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $pendudukId = Auth::user()->penduduk->penduduk_id;

        $validated = $request->validate([
            'jenis_pelaporan' => 'required',
            'accepted_at' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $pengajuan = Pengajuan::create([
                'accepted_at' => $validated['accepted_at'],
                'keterangan' => $validated['keterangan'],
                'penduduk_id' => $pendudukId,
            ]);

            Pelaporan::create([
                'jenis_pelaporan' => $validated['jenis_pelaporan'],
                'pengajuan_id' => $pengajuan->pengajuan_id,
            ]);

            DB::commit();

            NotificationPusher::success('Perubahan berhasil disimpan');
            return redirect()->route('pelaporan.index')->with(['success' => 'Perubahan berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan perubahan: ' . $e->getMessage());
            return redirect()->route('pelaporan.index')->with(['error' => 'Gagal menyimpan perubahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(String $id): JsonResponse | RedirectResponse
    {
        // Temukan detail keuangan dengan ID yang diberikan
        $pelaporan = Pelaporan::findOrFail($id);
        $pengajuan = Pengajuan::findOrFail($pelaporan->pengajuan_id);

        try {
            DB::beginTransaction();

            $pelaporan->delete();
            $pengajuan->delete();

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

}
