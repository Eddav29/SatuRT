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
                        'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->format('d-m-Y'),
                        'created_at' => Carbon::parse($persuratan->created_at)->format('d-m-Y'),
                        'updated_at' => Carbon::parse($persuratan->updated_at)->format('d-m-Y'),
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
                        'created_at' => Carbon::parse($persuratan->created_at)->format('d-m-Y'),
                        'accepted_at' => Carbon::parse($persuratan->pengajuan->accepted_at)->format('d-m-Y'),
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

        $breadcrumb = [
            'list' => ['Home', 'Permohonan Surat', 'Detail Permohonan Surat'],
            'url' => ['home', 'persuratan.index', ['persuratan.show', $id]],
        ];

        return response()->view('pages.persuratan.show', [
            'breadcrumb' => $breadcrumb,
            'persuratan' => $persuratan,
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
}
