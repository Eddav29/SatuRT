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

    // KETUA RT
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
        $pelaporan = Pelaporan::find($id);

        $validated = $request->validate([
            'pelaporan_id' => ['required', 'exists:penduduk,penduduk_id'],
            'jenis_pelaporan' => ['required'],
            'image_url' => ['required', 'file'],
            'pengajuan_id' => ['required', 'exists:pengajuan,id'],
        ], [
            'pelaporan_id.required' => 'ID pelaporan harus diisi.',
            'pelaporan_id.exists' => 'ID pelaporan yang diberikan tidak valid.',
            'jenis_pelaporan.required' => 'Jenis pelaporan harus diisi.',
            'image_url.required' => 'Gambar harus diunggah.',
            'image_url.file' => 'File gambar tidak valid.',
            'pengajuan_id.required' => 'ID pengajuan harus diisi.',
            'pengajuan_id.exists' => 'ID pengajuan yang diberikan tidak valid.',
        ]);

        if ($request->file('image_url')) {
            Storage::delete('public/resident-report_images/' . $pelaporan->image_url);

            if (
                $validated['jenis_pelaporan'] == 'Pengaduan' ||
                $validated['jenis_pelaporan'] == 'Kritik' ||
                $validated['jenis_pelaporan'] == 'Saran'
            ) {

                $fileName = $request->file('image_url')->getClientOriginalName();
                $request->file('image_url')->storeAs('resident-report_images', $fileName, 'public');
                $validated['image_url'] = $fileName;
            } else {
                $validated['image_url'] = $request->file('image_url')->store('resident-report_images', 'public');
                $validated['image_url'] = basename($validated['image_url']);
            }
        }

        try {
            $pelaporan->update($validated);

            return redirect()->route('pelaporan.index')->with(['success' => 'Perubahan berhasil disimpan']);
        } catch (\Throwable $th) {
            return redirect()->route('pelaporan.index')->with(['error' => 'Gagal menyimpan perubahan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $pelaporan = Pelaporan::find($id);

        try {
            Storage::delete($pelaporan->image_url);
            $pelaporan->delete();

            return redirect()->route('pelaporan.index')->with('success', 'Pelaporan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('pelaporan.index')->with('error', 'Gagal menghapus pelaporan');
        }
    }

    public function list(): JsonResponse
    {
        try {

            if (Auth::user()->role->role_name == 'Ketua RT') {
                $data = Pelaporan::all()->map(function ($pelaporan) {
                    return [
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
                        'id_laporan' => $pelaporan->pelaporan_id,
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
            'url' => ['home', 'pelaporan.index', 'pelaporan.index'],
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

}
