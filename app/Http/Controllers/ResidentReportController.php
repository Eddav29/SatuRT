<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResidentReportResource;
use App\Models\Pelaporan;
use App\Models\Pengajuan;
use App\Services\ImageManager\ImageService;
use App\Services\Notification\NotificationPusher;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResidentReportController extends Controller
{
    public function getResidentReport(int $id): ResidentReportResource
    {
        try {
            $residentReport = Pelaporan::with(['pengajuan', 'pengajuan.penduduk', 'pengajuan.status', 'pengajuan.acceptedBy'])->find($id);

            if (!$residentReport) {
                throw new HttpResponseException(response()->json([
                    'message' => 'Data not found',
                ])->setStatusCode(404));
            }

            return new ResidentReportResource($residentReport);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function index(): Response
    {
        if (Auth::user()->role->role_name == 'Ketua RT') {
            $breadcrumb = [
                'list' => ['Home', 'Laporan Warga'],
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
            return response()->view('pages.resident-report.index', [
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
                'list' => ['Home', 'Laporan Warga', 'Detail Laporan'],
                'url' => ['home', 'pelaporan.index', ['pelaporan.show', $id]],
            ];

            return response()->view('pages.resident-report.show', [
                'pelaporan' => $pelaporan,
                'breadcrumb' => $breadcrumb,
            ]);
        } else {
            $pelaporan = Pelaporan::with('pengajuan')->find($id);

            $breadcrumb = [
                'list' => ['Home', 'LAPOR!', 'Detail Laporan'],
                'url' => ['home', 'pelaporan.index', ['pelaporan.show', $id]],
            ];

            return response()->view('pages.resident-report.show', [
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

            $validated = $request->validate([
                'status_id' => 'required',
            ], [
                'status_id.required' => "Status Tidak Boleh Kosong",
            ]);

            try {
                $pelaporan = Pelaporan::find($id);
                $pengajuan = Pengajuan::find($pelaporan->pengajuan_id);

                $pengajuan->update($validated);

                NotificationPusher::success('Status Pelaporan Berhasil diperbarui');
                return redirect()->route('pelaporan.index');
            } catch (\Throwable $th) {
                NotificationPusher::error('Status Pelaporan Gagal diperbarui');
                return redirect()->route('pelaporan.index');
            }

        } else {
            if ($request['status_id'] === "4") {
                $pelaporan = Pelaporan::find($id);
                $pengajuan = Pengajuan::find($pelaporan->pengajuan_id);

                try {
                    $pengajuan->update([
                        'status_id' => $request['status_id'],
                    ]);

                    NotificationPusher::success('Perubahan berhasil disimpan');
                    return redirect()->route('pelaporan.index')->with(['success' => 'Perubahan berhasil disimpan']);
                } catch (\Throwable $th) {
                    NotificationPusher::error('Gagal menyimpan perubahan');
                    return redirect()->route('pelaporan.index')->with(['error' => 'Gagal menyimpan perubahan']);
                }

            }


            $validated = $request->validate([
                'keperluan' => 'required',
                'accepted_at' => 'required|date',
                'jenis_pelaporan' => 'required',
                'image_url' => 'max:2048|image',
                'keterangan' => 'required',
            ], [
                'keperluan.required' => "Judul Tidak Boleh Kosong",
                'jenis_pelaporan.required' => "Jenis Pelaporan Tidak Boleh Kosong",
                'keterangan.required' => "Keterangan Tidak Boleh Kosong",
                'image_url.max' => "Lampiran Tidak Boleh Lebih Besar dari 2MB",
                'image_url.image' => "Lampiran Harus Berbentuk Gambar",
            ]);

            try {
                $pelaporan = Pelaporan::find($id);
                $pengajuan = Pengajuan::find($pelaporan->pengajuan_id);

                if ($request->image_url) {
                    $pelaporan['image_url'] = ImageService::uploadFile('public', $request, 'image_url');
                }

                $pelaporan->update([
                    'image_url' => $pelaporan['image_url'],
                    'jenis_pelaporan' => $validated['jenis_pelaporan'],
                ]);

                $pengajuan->update([
                    'keperluan' => $validated['keperluan'],
                    'accepted_at' => $validated['accepted_at'],
                    'keterangan' => $validated['keterangan'],
                ]);

                NotificationPusher::success('Perubahan berhasil disimpan');
                return redirect()->route('pelaporan.show', ['pelaporan' => $id]);
            } catch (\Throwable $th) {
                NotificationPusher::error('Gagal menyimpan perubahan');
                return redirect()->route('pelaporan.show', ['pelaporan' => $id]);
            }
        }
    }

    public function list(): JsonResponse
    {
        try {
            if (Auth::user()->role->role_name == 'Ketua RT') {
                $data = Pelaporan::join('pengajuan', 'pelaporan.pengajuan_id', '=', 'pengajuan.pengajuan_id')
                    ->orderBy('pengajuan.updated_at', 'desc')
                    ->where('pengajuan.status_id', '!=', '4')
                    ->get()->map(function ($pelaporan) {
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
                })
                    ->join('pengajuan', 'pelaporan.pengajuan_id', '=', 'pengajuan.pengajuan_id')
                    ->orderBy('pengajuan.updated_at', 'desc')
                    ->with('pengajuan')
                    ->get()
                    ->map(function ($pelaporan) {
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
        return response()->view('pages.resident-report.create', [
            'breadcrumb' => $breadcrumb,
            'pelaporan' => $pelaporan,
            'extension' => 'jpg,jpeg,png',
        ]);
    }

    public function edit(string $id): Response
    {
        $pelaporan = Pelaporan::find($id);

        $breadcrumb = [
            'list' => ['Home', 'LAPOR!', 'Edit Pelaporan'],
            'url' => ['home', 'pelaporan.index', ['pelaporan.edit', $id]],
        ];

        return response()->view('pages.resident-report.edit', [
            'breadcrumb' => $breadcrumb,
            'pelaporan' => $pelaporan,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('pelaporan.show', ['pelaporan' => $id]),
                'edit' => route('pelaporan.edit', ['pelaporan' => $id]),
                'hapus' => route('pelaporan.destroy', ['pelaporan' => $id]),
            ],
            'extension' => 'jpg,jpeg,png',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'keperluan' => 'required',
            'accepted_at' => 'required|date',
            'jenis_pelaporan' => 'required',
            'image_url' => 'max:2048|image',
            'keterangan' => 'required',
        ],[
            'keperluan.required' => "Judul Tidak Boleh Kosong",
            'jenis_pelaporan.required' => "Jenis Pelaporan Tidak Boleh Kosong",
            'keterangan.required' => "Keterangan Tidak Boleh Kosong",
            'image_url.max' => "Lampiran Tidak Boleh Lebih Besar dari 2MB",
            'image_url.image' => "Lampiran Harus Berbentuk Gambar",
        ]);

        try {
            $pendudukId = Auth::user()->penduduk->penduduk_id;

            if ($request->image_url) {
                $pelaporan['image_url'] = ImageService::uploadFile('public', $request, 'image_url');
            } else {
                $pelaporan['image_url'] = null;
            }

            DB::beginTransaction();

            $pengajuan = Pengajuan::create([
                'keperluan' => $validated['keperluan'],
                'accepted_at' => $validated['accepted_at'],
                'keterangan' => $validated['keterangan'],
                'penduduk_id' => $pendudukId,
            ]);

            Pelaporan::create([
                'jenis_pelaporan' => $validated['jenis_pelaporan'],
                'pengajuan_id' => $pengajuan->pengajuan_id,
                'image_url' => $pelaporan['image_url'],
            ]);

            DB::commit();

            NotificationPusher::success('Data berhasil ditambahkan');
            return redirect()->route('pelaporan.index');
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->route('pelaporan.index');
        }

    }

    public function destroy(string $id): JsonResponse | RedirectResponse
    {
        try {
            $pelaporan = Pelaporan::find($id);
            $pengajuan = Pengajuan::find($pelaporan->pengajuan_id);

            DB::beginTransaction();

            $status = '';
            if ($pelaporan->image_url) {
                $status = ImageService::deleteFile('public', $pelaporan->image_url);
            }

            if ($status) {
                $pelaporan->delete();
                $pengajuan->delete();
            }

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil dihapus',
                'timestamp' => now(),
                'redirect' => route('pelaporan.index'),
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
