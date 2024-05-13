<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinanceReportResource;
use App\Models\Persuratan;
use App\Models\Pengajuan;
use App\Models\Penduduk;
use App\Models\Status;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Services\Notification\NotificationPusher;
use PDF;
use Exception;
use Illuminate\Support\Facades\View;

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
            'data' => $data['data'] ?? []
        ]);
    }

    public function list(): JsonResponse
    {
        try {

            if (Auth::user()->role->role_name === 'Ketua RT') {
                $pengajuan = Pengajuan::all();
                $pengajuan->load(
                    ['status', 'penduduk', 'acceptedBy']
                );

                $data = Persuratan::all()->map(function ($persuratan) {
                    return [
                        'persuratan_id' => $persuratan->persuratan_id,
                        'nik' => $persuratan->pengajuan->penduduk->nik,
                        'nama' => $persuratan->pengajuan->penduduk->nama,
                        'status' => $persuratan->pengajuan->status->nama,
                        'keperluan' => $persuratan->pengajuan->keperluan,
                        'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->startOfDay()->formatLocalized('%d %B %Y'),
                        'created_at' => Carbon::parse($persuratan->created_at)->startOfDay()->formatLocalized('%d %B %Y'),
                        'updated_at' => Carbon::parse($persuratan->updated_at)->startOfDay()->formatLocalized('%d %B %Y'),
                    ];
                });
            } else {
                $data = Persuratan::whereHas('pengajuan', function ($query) {
                    $query->where('penduduk_id', auth()->user()->penduduk->penduduk_id);
                })->with('pengajuan')->get()->map(function ($persuratan) {
                    return [
                        'persuratan_id' => $persuratan->persuratan_id,
                        'nik' => $persuratan->pengajuan->penduduk->nik,
                        'nama' => $persuratan->pengajuan->penduduk->nama,
                        'status' => $persuratan->pengajuan->status->nama,
                        'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->startOfDay()->formatLocalized('%d %B %Y'),
                        'created_at' => Carbon::parse($persuratan->created_at)->startOfDay()->formatLocalized('%d %B %Y'),
                        'keperluan' => $persuratan->pengajuan->keperluan,
                    ];
                });
            }

            return response()->json([
                'data' => $data,
            ]);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Terjadi kesalahan.'], 500);
        }
    }

        public function show(string $id): Response|JsonResponse
        {
            $persuratan = Persuratan::with('pengajuan')->find($id);

            if (!$persuratan) {
                return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
            }

            $breadcrumb = [
                'list' => ['Home', 'Permohonan Surat', 'Detail Permohonan Surat'],
                'url' => ['home', 'persuratan.index', ['persuratan.show', $id]],
            ];

            $userRole = Auth::user()->role->role_name;

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
                throw new Exception('Permohonan tidak ditemukan');
            }

            // Pastikan pengguna memiliki hak untuk menyetujui
            if (Auth::user()->role->role_name !== 'Ketua RT' && Auth::user()->role->role_name !== 'Admin') {
                throw new Exception('Anda tidak memiliki izin untuk menyetujui permohonan ini');
            }

            // Ubah status pengajuan menjadi Disetujui dengan status_id = 2
            $pengajuan = $persuratan->pengajuan;

            // Pastikan persuratan memiliki pengajuan
            if (!$pengajuan) {
                throw new Exception('Pengajuan terkait tidak ditemukan');
            }

            $pengajuan->update([
                'status_id' => 2, // Set status menjadi Disetujui
                'accepted_by' => Auth::user()->id,
                'accepted_at' => now(), // Waktu saat persetujuan
            ]);

            

            DB::commit(); // Selesaikan transaksi

            NotificationPusher::success('Permohonan disetujui.');
    
            return redirect()->route('persuratan.index');

        } catch (Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    public function reject(Request $request, string $persuratan_id)
    {
        try {
            DB::beginTransaction(); // Mulai transaksi untuk menjaga integritas data

            // Cari permohonan surat berdasarkan ID
            $persuratan = Persuratan::find($persuratan_id);

            if (!$persuratan) {
                throw new Exception('Permohonan tidak ditemukan');
            }

            // Pastikan pengguna memiliki hak untuk menyetujui
            if (Auth::user()->role->role_name !== 'Ketua RT' && Auth::user()->role->role_name !== 'Admin') {
                throw new Exception('Anda tidak memiliki izin untuk menolak permohonan ini');
            }

            // Ubah status pengajuan menjadi Disetujui dengan status_id = 2
            $pengajuan = $persuratan->pengajuan;

            // Pastikan persuratan memiliki pengajuan
            if (!$pengajuan) {
                throw new Exception('Pengajuan terkait tidak ditemukan');
            }

            $pengajuan->update([
                'status_id' => 3, // Set status menjadi Disetujui
                'accepted_by' => Auth::user()->id,
                'accepted_at' => now(), // Waktu saat persetujuan
            ]);

            DB::commit(); // Selesaikan transaksi

            NotificationPusher::success('Permohonan ditolak.');
    
            return redirect()->route('persuratan.index');

        } catch (Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
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
            $pengajuan->penduduk_id = $request->input('pemohon');
            $pengajuan->status_id = 1;
            $pengajuan->keperluan = $request->input('jenis_surat');
            $pengajuan->keterangan = $request->input('keperluan_lainnya') ?? 'Tidak ada keterangan'; // Nilai default
            $pengajuan->save();
    
            $persuratan = new Persuratan();
            $persuratan->pengajuan_id = $pengajuan->pengajuan_id;
            $persuratan->jenis_surat = $request->input('jenis_surat');
            $persuratan->pengajuan->created_by = Auth::user()->id;
            $persuratan->save();
    
            DB::commit();
    
            return redirect()->route('persuratan.index')->with('success', 'Permohonan berhasil diajukan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengajukan permohonan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(string $id): Response
    {
        $persuratan = Persuratan::with('pengajuan')->find($id);

        if (!$persuratan) {
            return redirect()->route('persuratan.index')->with('error', 'Permohonan tidak ditemukan');
        }

        // Mendapatkan data penduduk, misalnya semua penduduk atau anggota keluarga tertentu
        $penduduk = Penduduk::all(); // Anda bisa mengganti ini dengan query yang sesuai untuk mendapatkan daftar penduduk

        // Buat breadcrumb untuk navigasi
        $breadcrumb = [
            'list' => ['Home', 'Permohonan Surat', 'Edit Permohonan Surat'],
            'url' => ['home', 'persuratan.index', ['persuratan.edit', $id]],
        ];

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
            return redirect()->route('persuratan.index')->with('error', 'Permohonan tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            // Dapatkan pengajuan terkait
            $pengajuan = $persuratan->pengajuan;

            // Pastikan nilai yang akan diperbarui
            $pengajuan->penduduk_id = $request->input('pemohon');
            $pengajuan->keperluan = $request->input('jenis_surat');
            $pengajuan->keterangan = $request->input('keperluan_lainnya') ?? 'Tidak ada keterangan'; // Jika kosong, berikan nilai default
            $pengajuan->save();

            // Perbarui data persuratan
            $persuratan->jenis_surat = $request->input('jenis_surat');
            $persuratan->save();

            DB::commit(); // Selesaikan transaksi jika tidak ada kesalahan

            return redirect()->route('persuratan.index')->with('success', 'Permohonan berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui permohonan: ' . $e->getMessage())->withInput(); // Kembalikan input sebelumnya
        }
    }

    public function destroy(string $id): JsonResponse | RedirectResponse
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
    
        // Unduh file PDF
        return $pdf->stream('document.pdf'); // Nama file untuk unduhan
    }

}
