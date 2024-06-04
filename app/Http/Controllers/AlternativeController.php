<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\KriteriaAlternatif;
use App\Services\Notification\NotificationPusher;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\Event\Code\Throwable;

class AlternativeController extends Controller
{
    public function list(): JsonResponse
    {
        try {
            $data = Alternatif::all()->map(function ($alternatif) {
                return [
                    'alternatif_id' => $alternatif->alternatif_id,
                    'nama_alternatif' => $alternatif->nama_alternatif,
                    'created_at' => Carbon::parse($alternatif->created_at)->format('d-m-Y'),
                    'updated_at' => Carbon::parse($alternatif->updated_at)->format('d-m-Y'),
                ];
            });

            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function index()
    {
        try {
            $breadcrumb = [
                'list' => ['Home', 'SPK', 'Kegiatan'],
                'url' => ['home', 'spk.index', 'spk.index'],
            ];

            return response()->view('pages.alternatif.index', [
                'breadcrumb' => $breadcrumb
            ]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function create()
    {
        try {
            $criteria = Kriteria::all();

            if ($criteria->isEmpty()) {
                NotificationPusher::warning('Silahkan menambahkan data kriteria terlebih dahulu');
                return redirect()->back();
            }

            $breadcrumb = [
                'list' => ['Home', 'SPK', 'Tambah Kegiatan'],
                'url' => ['home', 'spk.index', 'spk.create'],
            ];

            return response()->view('pages.alternatif.create', [
                'breadcrumb' => $breadcrumb,
                'criterias' => $criteria
            ]);
        } catch (\Throwable $th) {
            NotificationPusher::error('Terjadi Kesalahan');
            return redirect()->back();
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_alternatif' => ['required', 'string', 'min:3', 'max:255'],
            'nilai_kriteria' => ['required', 'array'],
            'nilai_kriteria.*' => ['required', 'numeric'],
        ], [
            'nama_alternatif.min' => 'Nama kegiatan minimal 3 karakter.',
            'nama_alternatif.max' => 'Nama kegiatan maksimal 255 karakter.',
            'nama_alternatif.required' => 'Nama kegiatan harus diisi.',
            'nilai_kriteria.*.required' => 'Nilai harus diisi.',
            'nilai_kriteria.*.numeric' => 'Semua nilai harus berupa angka.',
        ]);

        if ($validator->fails()) {
            // Push notification
            NotificationPusher::error($validator->getMessageBag()->first());

            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            DB::beginTransaction();

            $alternatif = new Alternatif();
            $alternatif->nama_alternatif = Str::title($request['nama_alternatif']);
            $alternatif->save();

            foreach ($request['nilai_kriteria'] as $key => $value) {
                KriteriaAlternatif::create([
                    'alternatif_id' => $alternatif->alternatif_id,
                    'kriteria_id' => $key + 1,
                    'nilai' => $value
                ]);
            }

            DB::commit();
            NotificationPusher::success('Data berhasil ditambahkan');

            return redirect()->route('spk.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            NotificationPusher::error("Terjadi Kesalahan");
            return redirect()->back()->withInput();
        }
    }

    public function edit(string $id): Response|RedirectResponse
    {
        try {
            $alternatif = KriteriaAlternatif::with(['kriteria', 'alternatif'])->where('alternatif_id', $id)->get();

            if ($alternatif->isEmpty()) {
                NotificationPusher::warning('Silahkan menambahkan data kriteria terlebih dahulu');
                return redirect()->back();
            }

            $breadcrumb = [
                'list' => ['Home', 'SPK', 'Edit Data Kegiatan'],
                'url' => ['home', 'spk.index', ['spk.edit', $id]],
            ];

            return response()->view('pages.alternatif.edit', [
                'breadcrumb' => $breadcrumb,
                'alternatif' => $alternatif,
                'id' => $id,
                'active' => 'edit',
                'toolbar_id' => $id,
                'toolbar_route' => [
                    'detail' => route('spk.show', ['alternatif' => $id]),
                    'edit' => route('spk.edit', ['alternatif' => $id]),
                    'hapus' => route('spk.destroy', ['alternatif' => $id]),
                ],
            ]);
        } catch (\Throwable $th) {
            NotificationPusher::error('Terjadi Kesalahan');
            return redirect()->back();
        }

    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_alternatif' => ['required', 'string', 'min:3', 'max:255'],
            'nilai_kriteria' => ['required', 'array'],
            'nilai_kriteria.*' => ['required', 'numeric'],
        ], [
            'nama_alternatif.min' => 'Nama kegiatan minimal 3 karakter.',
            'nama_alternatif.max' => 'Nama kegiatan maksimal 255 karakter.',
            'nama_alternatif.required' => 'Nama kegiatan harus diisi.',
            'nilai_kriteria.*.required' => 'Nilai harus diisi.',
            'nilai_kriteria.*.numeric' => 'Semua nilai harus berupa angka.',
        ]);

        if ($validator->fails()) {
            NotificationPusher::error($validator->getMessageBag()->first());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            DB::beginTransaction();

            Alternatif::where('alternatif_id', $id)->update([
                'nama_alternatif' => $request['nama_alternatif'],
            ]);

            foreach ($request['nilai_kriteria'] as $key => $value) {
                KriteriaAlternatif::where('alternatif_id', $id)->where('kriteria_id', $key + 1)->update([
                    'nilai' => $value
                ]);
            }

            DB::commit();
            NotificationPusher::success('Data berhasil diperbarui');

            return redirect()->route('spk.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            NotificationPusher::error("Terjadi Kesalahan");
            return redirect()->back()->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $alternative = KriteriaAlternatif::with(['kriteria', 'alternatif'])->where('alternatif_id', $id)->get();

            if ($alternative->isEmpty()) {
                NotificationPusher::warning('Data tidak ditemukan');
                return redirect()->back();
            }

            $breadcrumb = [
                'list' => ['Home', 'SPK', 'Detail Kegiatan'],
                'url' => ['home', 'spk.index', ['spk.show', $id]],
            ];

            return response()->view('pages.alternatif.show', [
                'breadcrumb' => $breadcrumb,
                'active' => 'detail',
                'toolbar_id' => $id,
                'toolbar_route' => [
                    'detail' => route('spk.show', ['alternatif' => $id]),
                    'edit' => route('spk.edit', ['alternatif' => $id]),
                    'hapus' => route('spk.destroy', ['alternatif' => $id]),
                ],
                'alternative' => $alternative
            ]);

        } catch (\Throwable $th) {
            NotificationPusher::error('Terjadi Kesalahan');
            return redirect()->back();
        }
    }

    public function destroy(string|int $id)
    {
        try {
            DB::beginTransaction();

            DB::delete('DELETE FROM kriteria_alternatif WHERE alternatif_id = ?', [$id]);
            Alternatif::find($id)->delete();

            DB::commit();

            NotificationPusher::success('Data berhasil dihapus');

            return response()->json([
                'code' => 200,
                'message' => 'Data berhasil dihapus',
                'timestamp' => now(),
                'redirect' => route('spk.index')
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            NotificationPusher::error("Terjadi Kesalahan");
            return redirect()->back()->withInput();
        }
    }
}
