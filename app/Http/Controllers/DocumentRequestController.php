<?php

namespace App\Http\Controllers;

use App\Models\Persuratan;
use App\Models\Pengajuan;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Notification\NotificationPusher;
use PDF;
use Exception;

class DocumentRequestController extends Controller
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
            'list' => ['Home', 'Permohonan Surat'],
            'url' => ['home', 'persuratan.index'],
        ];
        return response()->view('pages.persuratan.index', [
            'breadcrumb' => $breadcrumb,
            'data' => $data['data'] ?? [],
        ]);
    }

    public function list(): JsonResponse
    {
        try {
            // $query = Persuratan::join('pengajuan', 'persuratan.pengajuan_id', '=', 'pengajuan.pengajuan_id')
            // ->orderBy('pengajuan.updated_at', 'desc')
            // ->with('pengajuan.penduduk', 'pengajuan.status');
            if (Auth::user()->role->role_name === 'Ketua RT') {
                $data = Persuratan::join('pengajuan', 'persuratan.pengajuan_id', '=', 'pengajuan.pengajuan_id')
                    // ->whereHas('pengajuan.status', function ($query) {
                    //     $query->where('nama', '!==', 'Dibatalkan');
                    // })
                    ->whereHas('pengajuan', function ($query) {
                        $query->where('status_id', '!=', function ($query) {
                            $query->select('status_id')
                                  ->from('status')
                                  ->where('nama', 'Dibatalkan')
                                  ->limit(1);
                        });
                    })
                    ->orderBy('pengajuan.updated_at', 'desc')
                    ->with('pengajuan.penduduk', 'pengajuan.status')
                    ->get()->map(function ($persuratan) {
                        return [
                            'persuratan_id' => $persuratan->persuratan_id,
                            'nik' => $persuratan->pemohon()->nik,
                            'nama' => $persuratan->pemohon()->nama,
                            'status' => $persuratan->pengajuan->status->nama,
                            'keperluan' => $persuratan->pengajuan->keperluan,
                            'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->format('d-m-Y'),
                            'created_at' => Carbon::parse($persuratan->pengajuan->created_at)->format('d-m-Y'),
                            'updated_at' => Carbon::parse($persuratan->pengajuan->updated_at)->format('d-m-Y'),
                        ];
                    });
                $pengajuan = Pengajuan::all();
                $pengajuan->load(
                    ['status', 'penduduk', 'acceptedBy']
                );

                $data = Persuratan::all()->map(function ($persuratan) {
                    return [
                        'persuratan_id' => $persuratan->persuratan_id,
                        'nik' => $persuratan->pengajuan->penduduk->nik,
                        'nama' => $persuratan->pemohon()->nama,
                        'status' => $persuratan->pengajuan->status->nama,
                        'keperluan' => $persuratan->pengajuan->keperluan,
                        'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->startOfDay()->formatLocalized('%d %B %Y'),
                        'created_at' => Carbon::parse($persuratan->created_at)->startOfDay()->formatLocalized('%d %B %Y'),
                        'updated_at' => Carbon::parse($persuratan->updated_at)->startOfDay()->formatLocalized('%d %B %Y'),
                    ];
                });
            } else {
                $data = Persuratan::join('pengajuan', 'persuratan.pengajuan_id', '=', 'pengajuan.pengajuan_id')->whereHas('pengajuan', function ($query) {
                    $query->where('penduduk_id', auth()->user()->penduduk->penduduk_id);
                })->orderBy('pengajuan.updated_at', 'desc')->with('pengajuan')->get()->map(function ($persuratan) {
                    return [
                        'persuratan_id' => $persuratan->persuratan_id ?? '',
                        'nik' => $persuratan->pemohon()->nik?? '',
                        'nama' => $persuratan->pemohon()->nama?? '',
                        'status' => $persuratan->pengajuan->status->nama?? '',
                        'created_at' => Carbon::parse($persuratan->pengajuan->created_at)->format('d-m-Y')?? '',
                        'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->format('d-m-Y')?? '',
                        'keperluan' => $persuratan->pengajuan->keperluan?? '',
                    ];
                });
            }

            return response()->json([
                'code' => 201,
                'data' => $data,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => $th->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }

    public function show(string $id): Response|JsonResponse
    {
        $persuratan = Persuratan::with('pengajuan')->find($id);

        if (!$persuratan) {
            NotificationPusher::error('Permohonan tidak ditemukan');
            return redirect()->route('persuratan.index');
        }

        $breadcrumb = [
            'list' => ['Home', 'Permohonan Surat', 'Detail Permohonan Surat'],
            'url' => ['home', 'persuratan.index', ['persuratan.show', $id]],
        ];

        $userRole = Auth::user()->role->role_name;

        if ($persuratan->pengajuan->accepted_by !== null) {
            return response()->view('pages.persuratan.show', [
                'breadcrumb' => $breadcrumb,
                'persuratan' => $persuratan,
                'toolbar_id' => $id,
                'active' => 'detail',
                'toolbar_route' => [
                    'detail' => route('persuratan.show', ['persuratan' => $id]),
                    'hapus' => route('persuratan.destroy', ['persuratan' => $id]),
                ],
                'canApproveOrReject' => $userRole === 'Ketua RT' || $userRole === 'Admin',
            ]);
        }

        return response()->view('pages.persuratan.show', [
            'breadcrumb' => $breadcrumb,
            'persuratan' => $persuratan,
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('persuratan.show', ['persuratan' => $id]),
                'edit' => route('persuratan.edit', ['persuratan' => $id]),
                'hapus' => route('persuratan.destroy', ['persuratan' => $id]),
            ],
            'canApproveOrReject' => $userRole === 'Ketua RT' || $userRole === 'Admin',
        ]);
    }


    public function create()
    {
        $breadcrumb = [
            'list' => ['Home', 'Permohonan Surat', 'Permohonan Surat'],
            'url' => ['home', 'persuratan.index', 'persuratan.create'],
        ];


        return response()->view('pages.persuratan.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function approve(Request $request, string $persuratan_id)
    {
        try {
            DB::beginTransaction(); // Mulai transaksi untuk menjaga integritas data

            // Cari permohonan surat berdasarkan ID
            $persuratan = Persuratan::find($persuratan_id);

            if (!$persuratan) {
                NotificationPusher::error('Permohonan tidak ditemukan');
                return redirect()->route('persuratan.index');
            }

            // Pastikan pengguna memiliki hak untuk menyetujui
            if (Auth::user()->role->role_name !== 'Ketua RT' && Auth::user()->role->role_name !== 'Admin') {
                NotificationPusher::error('Anda tidak memiliki izin untuk permohonan ini');
                return redirect()->route('persuratan.index');
            }

            // Ubah status pengajuan menjadi Disetujui dengan status_id = 2
            $pengajuan = $persuratan->pengajuan;

            // Pastikan persuratan memiliki pengajuan
            if (!$pengajuan) {
                NotificationPusher::error('Pengajuan tidak ditemukan');
                return redirect()->route('persuratan.index');
            }

            $pengajuan->update([
                'status_id' => 2, // Set status menjadi Disetujui
                'accepted_by' => Auth::user()->penduduk->penduduk_id,
                'accepted_at' => now(), // Waktu saat persetujuan
                'updated_at' => now(),
            ]);

            DB::commit(); // Selesaikan transaksi

            NotificationPusher::success('Permohonan disetujui.');

            return redirect()->route('persuratan.index');

        } catch (Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }
    public function reject(Request $request, string $persuratan_id)
    {
        try {
            DB::beginTransaction(); // Mulai transaksi untuk menjaga integritas data

            // Cari permohonan surat berdasarkan ID
            $persuratan = Persuratan::find($persuratan_id);

            if (!$persuratan) {
                NotificationPusher::error('Permohonan tidak ditemukan');
                return redirect()->route('persuratan.index');
            }

            // Pastikan pengguna memiliki hak untuk menyetujui
            if (Auth::user()->role->role_name !== 'Ketua RT' && Auth::user()->role->role_name !== 'Admin') {
                NotificationPusher::error('anda tidak memiliki hak untuk melakukan ini');
                return redirect()->route('persuratan.index');
            }

            // Ubah status pengajuan menjadi Disetujui dengan status_id = 2
            $pengajuan = $persuratan->pengajuan;

            // Pastikan persuratan memiliki pengajuan
            if (!$pengajuan) {
                NotificationPusher::error('Pengajuan tidak ditemukan');
                return redirect()->route('persuratan.index');
            }

            $pengajuan->update([
                'status_id' => 3, // Set status menjadi Disetujui
                'accepted_by' => Auth::user()->id,
                'accepted_at' => now(), // Waktu saat persetujuan
                'updated_at' => now(),
            ]);

            DB::commit(); // Selesaikan transaksi

            NotificationPusher::success('Permohonan ditolak.');

            return redirect()->route('persuratan.index');

        } catch (Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemohon' => 'required|exists:penduduk,penduduk_id',
            'keperluan_lainnya' => 'nullable|string|max:255',
            'jenis_surat' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $pengajuan = new Pengajuan();
            $pengajuan->penduduk_id = Auth::user()->penduduk->penduduk_id;
            $pengajuan->status_id = 1;
            $pengajuan->keperluan = $request->input('jenis_surat') === 'Lainnya' ? $request->input('keperluan_lainnya') : $request->input('jenis_surat');
            $pengajuan->keterangan = $request->input('keperluan_lainnya') ?? 'Tidak ada keterangan'; // Nilai default
            $pengajuan->save();

            $persuratan = new Persuratan();
            $persuratan->pemohon = $request->input('pemohon');
            $persuratan->pengajuan_id = $pengajuan->pengajuan_id;
            $persuratan->jenis_surat = $request->input('jenis_surat');
            $persuratan->pengajuan->created_by = Auth::user()->id;
            $persuratan->save();

            DB::commit();

            NotificationPusher::success('Permohonan berhasil diajukan.');
            return redirect()->route('persuratan.index')->with('success', 'Permohonan berhasil diajukan.');
        } catch (Exception $e) {
            DB::rollBack();
            NotificationPusher::error('Terjadi kesalahan saat mengajukan permohonan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengajukan permohonan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(string $id): Response|RedirectResponse
    {
        $persuratan = Persuratan::with('pengajuan')->find($id);


        if (!$persuratan) {
            NotificationPusher::error('Permohonan tidak ditemukan');
            return redirect()->route('persuratan.index')->with('error', 'Permohonan tidak ditemukan');
        }

        // Mendapatkan data penduduk, misalnya semua penduduk atau anggota keluarga tertentu
        $penduduk = Penduduk::all(); // Anda bisa mengganti ini dengan query yang sesuai untuk mendapatkan daftar penduduk

        // Buat breadcrumb untuk navigasi
        $breadcrumb = [
            'list' => ['Home', 'Permohonan Surat', 'Edit Permohonan Surat'],
            'url' => ['home', 'persuratan.index', ['persuratan.edit', $id]],
        ];

        if ($persuratan->pengajuan->accepted_by !== null) {
            return response()->view('pages.persuratan.edit', [
                'breadcrumb' => $breadcrumb,
                'persuratan' => $persuratan,
                'penduduk' => $penduduk, // Kirim variabel penduduk ke tampilan
                'toolbar_id' => $id,
                'active' => 'edit',
                'toolbar_route' => [
                    'detail' => route('persuratan.show', ['persuratan' => $id]),
                    'hapus' => route('persuratan.destroy', ['persuratan' => $id]),
                ],
            ]);
        }

        return response()->view('pages.persuratan.edit', [
            'breadcrumb' => $breadcrumb,
            'persuratan' => $persuratan,
            'penduduk' => $penduduk, // Kirim variabel penduduk ke tampilan
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('persuratan.show', ['persuratan' => $id]),
                'edit' => route('persuratan.edit', ['persuratan' => $id]),
                'hapus' => route('persuratan.destroy', ['persuratan' => $id]),
            ],
        ]);
    }


    public function update(Request $request, string $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'pemohon' => 'required|exists:penduduk,penduduk_id',
            'jenis_surat' => 'required|string|max:255',
            'keperluan_lainnya' => 'nullable|string|max:255',
        ]);

        $persuratan = Persuratan::with('pengajuan')->find($id);

        if (!$persuratan) {
            NotificationPusher::error('Permohonan tidak ditemukan');
            return redirect()->route('persuratan.index');
        }

        try {
            DB::beginTransaction();

            // Dapatkan pengajuan terkait
            $pengajuan = $persuratan->pengajuan;

            // Pastikan nilai yang akan diperbarui
            $pengajuan->keperluan = $request->input('jenis_surat');
            $pengajuan->keterangan = $request->input('keperluan_lainnya') ?? 'Tidak ada keterangan'; // Jika kosong, berikan nilai default
            $pengajuan->save();

            // Perbarui data persuratan
            $persuratan->pemohon = $request->input('pemohon');
            $persuratan->jenis_surat = $request->input('jenis_surat');
            $persuratan->save();

            DB::commit(); // Selesaikan transaksi jika tidak ada kesalahan

            NotificationPusher::success('Permohonan berhasil diperbarui.');
            return redirect()->route('persuratan.index')->with('success', 'Permohonan berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada kesalahan
            NotificationPusher::error('Terjadi kesalahan saat memperbarui permohonan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui permohonan: ' . $e->getMessage())->withInput(); // Kembalikan input sebelumnya
        }
    }

    public function destroy(string $id): JsonResponse|RedirectResponse
    {
        $persuratan = Persuratan::find($id);

        if (!$persuratan) {
            return response()->json([
                'code' => 404,
                'message' => 'Persuratan tidak ditemukan',
                'timestamp' => now(),
            ], 404);
        }

        try {
            DB::beginTransaction(); // Mulai transaksi

            // Hapus entitas yang memiliki hubungan dengan kunci asing terlebih dahulu
            if ($persuratan->pengajuan) {
                $persuratan->delete(); // Hapus persuratan terlebih dahulu
            }

            DB::commit(); // Selesaikan transaksi jika berhasil

            return response()->json([
                'code' => 200,
                'message' => 'Persuratan berhasil dihapus',
                'timestamp' => now(),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback(); // Batalkan transaksi jika ada kesalahan
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }


    public function generatePdf($id)
    {
        $persuratan = Persuratan::findOrFail($id);

        // Load tampilan Blade dengan data yang diperlukan
        $pdf = PDF::loadView('pages.pdf.surat', compact('persuratan'));

        $pdf->setPaper('a4');

        // Unduh file PDF
        return $pdf->stream('document.pdf'); // Nama file untuk unduhan
    }

}
