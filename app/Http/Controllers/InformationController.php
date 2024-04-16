<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Informasi'],
            'url' => ['home', 'informasi.index'],
        ];
        return response()->view('pages.information.index', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Informasi', 'Tambah Informasi'],
            'url' => ['home', 'informasi.index', 'informasi.create'],
        ];
        return response()->view('pages.information.create', [
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'penduduk_id' => ['required', 'exists:penduduk,penduduk_id'],
            'jenis_informasi' => ['required'],
            'judul_informasi' => ['required', 'string', 'min:3', 'max:255'],
            'isi_informasi' => ['required', 'string', 'min:3'],
            'thumbnail_url' => ['required', 'file'],
        ], [
            'jenis_informasi.required' => 'Jenis informasi harus diisi.',
            'judul_informasi.required' => 'Judul informasi harus diisi.',
            'judul_informasi.min' => 'Judul informasi minimal memiliki panjang :min karakter.',
            'judul_informasi.max' => 'Judul informasi maksimal memiliki panjang :max karakter.',
            'isi_informasi.required' => 'Isi informasi harus diisi.',
            'isi_informasi.min' => 'Isi informasi minimal memiliki panjang :min karakter.',
            'thumbnail_url.required' => 'Thumbnail harus diisi.',
            'thumbnail_url.file' => 'Thumbnail harus berupa gambar.',
        ]);

        try {

            if ($request->file('thumbnail_url')) {
                if ($validated['jenis_informasi'] == 'Pengumuman') {
                    $fileName = $request->file('thumbnail_url')->getClientOriginalName();
                    $request->file('thumbnail_url')->storeAs('information_images', $fileName, 'public');
                    $validated['thumbnail_url'] = $fileName;
                } else {
                    $validated['thumbnail_url'] = $request->file('thumbnail_url')->store('information_images', 'public');
                    $validated['thumbnail_url'] = basename($validated['thumbnail_url']);
                }
            }

            Informasi::create($validated);

            return redirect()->route('informasi.index')->with(['success' => 'Informasi baru ditambahkan']);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('informasi.create')->with(['error' => 'Informasi gagal ditambahkan']);
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $request->validate([
                'upload' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg'],
            ]);

            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->storeAs('information_images', $fileName, 'public');

            $url = asset('storage/information_images/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $information = Informasi::with('penduduk')->find($id);

        $breadcrumb = [
            'list' => ['Home', 'Informasi', 'Detail Informasi'],
            'url' => ['home', 'informasi.index', 'informasi.show'],
        ];
        return response()->view('pages.information.show', [
            'information' => $information,
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $breadcrumb = [
            'list' => ['Home', 'Informasi', 'Edit Informasi'],
            'url' => ['home', 'informasi.index', ''],
        ];

        $information = Informasi::find($id);

        return response()->view('pages.information.edit', [
            'breadcrumb' => $breadcrumb,
            'information' => $information
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $information = Informasi::find($id);

        $validated = $request->validate([
            'penduduk_id' => ['required', 'exists:penduduk,penduduk_id'],
            'jenis_informasi' => ['required'],
            'judul_informasi' => ['required', 'string', 'min:3', 'max:255'],
            'isi_informasi' => ['required', 'string', 'min:3'],
            'thumbnail_url' => ['required', 'file'],
        ], [
            'jenis_informasi.required' => 'Jenis informasi harus diisi.',
            'judul_informasi.required' => 'Judul informasi harus diisi.',
            'judul_informasi.min' => 'Judul informasi minimal memiliki panjang :min karakter.',
            'judul_informasi.max' => 'Judul informasi maksimal memiliki panjang :max karakter.',
            'isi_informasi.required' => 'Isi informasi harus diisi.',
            'isi_informasi.min' => 'Isi informasi minimal memiliki panjang :min karakter.',
            'thumbnail_url.required' => 'Thumbnail harus diisi.',
            'thumbnail_url.file' => 'Thumbnail harus berupa gambar.',
        ]);

        if ($request->file('thumbnail_url')) {
            Storage::delete('public/information_images/' . $information->thumbnail_url);

            if ($validated['jenis_informasi'] == 'Pengumuman') {
                $fileName = $request->file('thumbnail_url')->getClientOriginalName();
                $request->file('thumbnail_url')->storeAs('information_images', $fileName, 'public');
                $validated['thumbnail_url'] = $fileName;
            } else {
                $validated['thumbnail_url'] = $request->file('thumbnail_url')->store('information_images', 'public');
                $validated['thumbnail_url'] = basename($validated['thumbnail_url']);
            }
        }

        try {
            $information->update($validated);

            return redirect()->route('informasi.index')->with(['success' => 'Perubahan berhasila disimpan']);
        } catch (\Throwable $th) {
            return redirect()->route('informasi.index')->with(['error' => 'Gagal menyimpan perubahan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $information = Informasi::find($id);

        try {
            Storage::delete($information->thumbnail_url);
            $information->delete();

            return redirect()->route('informasi.index')->with('success', 'Informasi berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('informasi.index')->with('error', 'Gagal menghapus informasi');
        }
    }

    public function download(string $fileName)
    {
        try {
            return Storage::download('public/information_images/' . $fileName);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'File not found or an error occurred.'], 404);
        }
    }

    public function list(): JsonResponse
    {
        try {
            $data = Informasi::all()->map(function ($informasi) {
                return [
                    'informasi_id' => $informasi->informasi_id,
                    'judul_informasi' => $informasi->judul_informasi,
                    'jenis_informasi' => $informasi->jenis_informasi,
                    'created_at' => Carbon::parse($informasi->created_at)->format('d-m-Y'),
                    'updated_at' => Carbon::parse($informasi->updated_at)->format('d-m-Y'),
                ];
            });

            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
