<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Services\FileManager\FileService;
use App\Services\ImageManager\ImageService;
use App\Services\Notification\NotificationPusher;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        try {
            $breadcrumb = [
                'list' => ['Home', 'Informasi'],
                'url' => ['home', 'informasi.index'],
            ];

            return response()->view('pages.information.index', [
                'breadcrumb' => $breadcrumb
            ]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        try {
            $breadcrumb = [
                'list' => ['Home', 'Informasi', 'Tambah Informasi'],
                'url' => ['home', 'informasi.index', 'informasi.create'],
            ];

            $informationTypes = Informasi::getListJenisInformasi();

            if (count($informationTypes) == 0) {
                NotificationPusher::warning('Tidak ada informasi yang tersedia.');
            }

            return response()->view('pages.information.create', [
                'breadcrumb' => $breadcrumb,
                'informationTypes' => $informationTypes,
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'jenis_informasi' => ['required'],
            'judul_informasi' => ['required', 'string', 'min:3', 'max:255'],
            'isi_informasi' => ['required', 'string', 'min:3'],
        ];

        $messages = [
            'jenis_informasi.required' => 'Jenis informasi harus diisi.',
            'judul_informasi.required' => 'Judul informasi harus diisi.',
            'judul_informasi.min' => 'Judul informasi minimal memiliki panjang :min karakter.',
            'judul_informasi.max' => 'Judul informasi maksimal memiliki panjang :max karakter.',
            'isi_informasi.required' => 'Isi informasi harus diisi.',
            'isi_informasi.min' => 'Isi informasi minimal memiliki panjang :min karakter.',
        ];

        if ($request->jenis_informasi !== 'Pengumuman' && $request->jenis_informasi !== 'Dokumentasi Rapat') {
            $rules['images'] = ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'];
            $messages['images.required'] = 'Thumbnail harus diisi.';
            $messages['images.mimes'] = 'File harus berupa gambar.';
            $messages['images.max'] = 'File maksimal 2048kb.';
        } elseif ($request->jenis_informasi == 'Pengumuman' || $request->jenis_informasi == 'Dokumentasi Rapat') {
            $rules['files'] = ['file', 'mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx', 'max:2048'];
            $messages['files.mimes'] = 'File harus berupa gambar.';
            $messages['files.max'] = 'File maksimal 2048kb.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            NotificationPusher::error('Gagal menambahkan informasi.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $model = Purify::clean($request['isi_informasi']);
            $cleaned_string = strip_tags(preg_replace('/(<\/p>)/', '$1 ', $model));
            $cleaned_string = preg_replace('/[^\x20-\x7E]/u', ' ', $cleaned_string);
            $request->merge(['excerpt' => Str::substr($cleaned_string, 0, 300)]);
            $request->merge(['judul_informasi' => Str::title($request['judul_informasi'])]);

            if ($request->file('images') || $request->file('files')) {
                if ($request['jenis_informasi'] == 'Pengumuman' || $request['jenis_informasi'] == 'Dokumentasi Rapat') {
                    $request->merge(['thumbnail_url' => $this->checkFile($request)]);
                } else {
                    $request->merge(['thumbnail_url' => ImageService::uploadFile('public', $request)]);
                }
            }

            $request['penduduk_id'] = Auth::user()->penduduk->penduduk_id;

            Informasi::create($request->all());

            NotificationPusher::success('Informasi baru ditambahkan');
            return redirect()->route('informasi.index');
        } catch (Exception $e) {
            NotificationPusher::error('Informasi gagal ditambahkan');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        try {
            $imageExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            $information = Informasi::with('penduduk')->findOrFail($id);
            $file_extension = pathinfo($information->thumbnail_url, PATHINFO_EXTENSION);
            $fileType = '';

            if (in_array($file_extension, $imageExtensions)) {
                $fileType = 'image';
            } elseif (in_array($file_extension, $fileExtensions)) {
                $fileType = 'file';
            }

            $breadcrumb = [
                'list' => ['Home', 'Informasi', 'Detail Informasi'],
                'url' => ['home', 'informasi.index', 'informasi.index'],
            ];

            return response()->view('pages.information.show', [
                'information' => $information,
                'breadcrumb' => $breadcrumb,
                'toolbar_id' => $id,
                'file_extension' => $file_extension,
                'fileType' => $fileType,
                'active' => 'detail',
                'toolbar_route' => [
                    'detail' => route('informasi.show', ['informasi' => $id]),
                    'edit' => route('informasi.edit', ['informasi' => $id]),
                    'hapus' => route('informasi.destroy', ['informasi' => $id]),
                ]
            ]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        try {
            $imageExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
            $breadcrumb = [
                'list' => ['Home', 'Informasi', 'Edit Informasi'],
                'url' => ['home', 'informasi.index', 'informasi.index'],
            ];

            $information = Informasi::find($id);
            $informationTypes = Informasi::getListJenisInformasi();
            $file_extension = $information->thumbnail_url ? pathinfo($information->thumbnail_url, PATHINFO_EXTENSION) : '';
            $fileType = '';

            if (count($informationTypes) == 0) {
                NotificationPusher::warning('Jenis informasi tidak tersedia.');
            }

            if (in_array($file_extension, $imageExtensions)) {
                $fileType = 'image';
            } elseif (in_array($file_extension, $fileExtensions)) {
                $fileType = 'file';
            }

            return response()->view('pages.information.edit', [
                'breadcrumb' => $breadcrumb,
                'information' => $information,
                'toolbar_id' => $id,
                'informationTypes' => $informationTypes,
                'file_extension' => $file_extension,
                'fileType' => $fileType,
                'active' => 'edit',
                'toolbar_route' => [
                    'detail' => route('informasi.show', ['informasi' => $id]),
                    'edit' => route('informasi.edit', ['informasi' => $id]),
                    'hapus' => route('informasi.destroy', ['informasi' => $id]),
                ]
            ]);
        } catch (Exception $e) {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $information = Informasi::findOrFail($id);
        $request['penduduk_id'] = Auth::user()->penduduk->penduduk_id;
        $rules = [
            'jenis_informasi' => ['required'],
            'judul_informasi' => ['required', 'string', 'min:3', 'max:255'],
            'isi_informasi' => ['required', 'string', 'min:3'],
        ];

        $messages = [
            'jenis_informasi.required' => 'Jenis informasi harus diisi.',
            'judul_informasi.required' => 'Judul informasi harus diisi.',
            'judul_informasi.min' => 'Judul informasi minimal memiliki panjang :min karakter.',
            'judul_informasi.max' => 'Judul informasi maksimal memiliki panjang :max karakter.',
            'isi_informasi.required' => 'Isi informasi harus diisi.',
            'isi_informasi.min' => 'Isi informasi minimal memiliki panjang :min karakter.',
        ];

        if ($request->jenis_informasi !== 'Pengumuman' && $request->jenis_informasi !== 'Dokumentasi Rapat') {
            $rules['images'] = ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'];
            $messages['images.required'] = 'Thumbnail harus diisi.';
            $messages['images.mimes'] = 'File harus berupa gambar.';
            $messages['images.max'] = 'File maksimal 2048kb.';
        } elseif ($request->jenis_informasi == 'Pengumuman' || $request->jenis_informasi == 'Dokumentasi Rapat') {
            $rules['files'] = ['file', 'mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx', 'max:2048'];
            $messages['files.mimes'] = 'File harus berupa gambar.';
            $messages['files.max'] = 'File maksimal 2048kb.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $model = Purify::clean($request['isi_informasi']);
            $cleaned_string = strip_tags(preg_replace('/(<\/p>)/', '$1 ', $model));
            $cleaned_string = preg_replace('/[^\x20-\x7E]/u', ' ', $cleaned_string);
            $request->merge(['excerpt' => Str::substr($cleaned_string, 0, 300)]);
            $request->merge(['judul_informasi' => Str::title($request['judul_informasi'])]);

            if ($request->file('images') || $request->file('files')) {
                if ($request['jenis_informasi'] == 'Pengumuman' || $request['jenis_informasi'] == 'Dokumentasi Rapat') {
                    $request->merge(['thumbnail_url' => $this->checkFile($request)]);
                    if ($information->thumbnail_url != null) {
                        FileService::deleteFile('storage_announcement', $information->thumbnail_url);
                    }
                } else {
                    $request->merge(['thumbnail_url' => ImageService::uploadFile('public', $request)]);
                    if ($information->thumbnail_url != null) {
                        FileService::deleteFile('public', $information->thumbnail_url);
                    }
                }
            } else {
                $request->merge(['thumbnail_url' => $information->thumbnail_url]);
            }


            $information->update($request->all());

            NotificationPusher::success('Data berhasil diperbarui');
            return redirect()->route('informasi.index');
        } catch (Exception $e) {
            NotificationPusher::error('Data gagal diperbarui');
            return redirect()->route('informasi.edit', ['informasi' => $id])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $user = Auth::user()->penduduk->penduduk_id;
            $information = Informasi::find($id);

            if ($information && $information->penduduk_id === $user) {
                $status = '';
                DB::beginTransaction();

                if ($information->thumbnail_url) {
                    if ($information->jenis_informasi == 'Pengumuman' || $information->jenis_informasi == 'Dokumentasi Rapat') {
                        $status = FileService::deleteFile('storage_announcement', $information->thumbnail_url);
                    } else {
                        $status = ImageService::deleteFile('public', $information->thumbnail_url);
                    }
                }

                if ($status || $information->thumbnail_url == null) {
                    $information->delete();
                }

                DB::commit();

                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil dihapus',
                    'timestamp' => now(),
                    'redirect' => route('informasi.index')
                ]);
            } else {
                return response()->json([
                    'code' => 403,
                    'message' => 'Anda tidak memiliki akses untuk menghapus data ini',
                    'timestamp' => now()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
                'timestamp' => now()
            ]);
        }
    }

    public function list(): JsonResponse
    {
        try {
            $data = Informasi::orderBy('updated_at', 'desc')->get()->map(function ($informasi) {
                return [
                    'informasi_id' => $informasi->informasi_id,
                    'judul_informasi' => $informasi->judul_informasi,
                    'jenis_informasi' => $informasi->jenis_informasi,
                    'created_at' => Carbon::parse($informasi->created_at)->format('d-m-Y | H:i:s'),
                    'updated_at' => Carbon::parse($informasi->updated_at)->format('d-m-Y | H:i:s'),
                ];
            });

            return response()->json([
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    private function checkFile(Request $request): string
    {
        $imageExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $fileName = '';
        $extension = $request->file('files')->getClientOriginalExtension();

        if (in_array($extension, $imageExtensions)) {
            $fileName = ImageService::uploadFile('storage_announcement', $request, 'files', 'jpg');
            return $fileName;
        } elseif (in_array($extension, $fileExtensions)) {
            $fileName = FileService::uploadFile('/storage_announcement', $request, 'files');
            return $fileName;
        }

        return 'File tidak valid';
    }

    public function getInformation(string $id): JsonResponse
    {
        try {
            $data = Informasi::find($id);
            return response()->json([
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
