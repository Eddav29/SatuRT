<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use App\Services\ImageManager\imageService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): Response
    {
        // $users = User::find($id);
        return response()->view('pages.profile.index');
    }

    public function completeDataForm(string $id): Response
    {
        $penduduk = Penduduk::find($id);

        return response()->view('pages.profile.complete-data', [
            'penduduk' => $penduduk,
        ]);
    }

    public function changePasswordForm(string $id): Response
    {
        $penduduk = Penduduk::find($id);
        return response()->view('pages.profile.change-password', [
            'penduduk' => $penduduk,
        ]);
    }

    // public function store(Request $request): RedirectResponse
    // {
    //     $validator =  Validator::make($request->all(), [
    //         'nama_umkm' => 'required|string|max:255',
    //         'jenis_umkm' => 'required|in:Makanan,Minuman,Pakaian,Peralatan,Jasa,Lainnya',
    //         'keterangan' => 'required|string|max:255',
    //         'alamat' => 'required|string|max:255',
    //         'nomor_telepon' => 'required|string|max:255',
    //         'lokasi_url' => 'required|string|max:255',
    //         'thumbnail_url' => 'required|file',
    //         'status' => 'required|in:Aktif,Nonaktif',
    //         'lisence_image_url' => 'required|file',
    //         'penduduk_id' => ['required', 'exists:penduduk,penduduk_id']
    //     ]);

    //     $umkm = $request->all();

    //     try {
    //         $umkm['nama_umkm'] = Str::title($request['nama_umkm']);
    //         $umkm['keterangan'] = Str::title($request['keterangan']);
    //         $umkm['alamat'] = Str::title($request['alamat']);
    //         $umkm['lokasi_url'] = Str::title($request['lokasi_url']);
    //         $umkm['nama_umkm'] = Str::title($request['nama_umkm']);

    //         $thumbnailFileName = $request->file('thumbnail_url')->store('business-thumbnail_images', 'public');
    //         $lisenceFileName = $request->file('lisence_image_url')->store('business-lisence_images', 'public');
    //         $umkm['thumbnail_url'] = basename($thumbnailFileName);
    //         $umkm['lisence_image_url'] = basename($lisenceFileName);

    //         // dd($umkm);

    //         DB::beginTransaction();
    //         $umkm = UMKM::create($umkm);
    //         if ($request->is('api/*') || $request->wantsJson()) {
    //             return response()->json([
    //                 'code' => 201,
    //                 'message' => 'Data UMKM berhasil disimpan',
    //                 'timestamp' => now(),
    //                 'data' => $umkm
    //             ]);
    //         }
    //         DB::commit();
    //         NotificationPusher::success('Data UMKM berhasil disimpan');
    //         return redirect()->route('umkm.index');
    //     } catch (\Exception $e) {
    //         if ($request->is('api/*') || $request->wantsJson()) {
    //             return response()->json([
    //                 'code' => 500,
    //                 'message' => $e->getMessage(),
    //                 'timestamp' => now()
    //             ]);
    //         }
    //         dd($e);
    //         DB::rollBack();
    //         NotificationPusher::error($e->getMessage());
    //         return redirect()->back()->withInput();
    //     }
    // }

    public function completeData(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'agama' => 'required',
            'desa' => 'required',
            'images' => 'required',
            'golongan_darah' => 'required',
            'jenis_kelamin' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required',
            'nama' => 'required',
            'nomor_rt' => 'required',
            'nomor_rw' => 'required',
            'pekerjaan' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_hubungan_dalam_keluarga' => 'required',
            'status_perkawinan' => 'required',
            'status_penduduk' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
        ]);

        $validated['desa'] = Str::title($validated['desa']);
        $validated['kecamatan'] = Str::title($validated['kecamatan']);
        $validated['kota'] = Str::title($validated['kota']);
        $validated['nama'] = Str::title($validated['nama']);
        $validated['pekerjaan'] = Str::title($validated['pekerjaan']);
        $validated['tempat_lahir'] = Str::title($validated['tempat_lahir']);

        try {
            DB::beginTransaction();
            if($request->file('images')){
                $imageName = imageService::uploadImage('storage_ktp', $request);
                $validated['foto_ktp'] = route('storage.ktp', ['filename' => $imageName]);
            }
            $penduduk = Penduduk::find($id);
            $penduduk->update($validated);
            DB::commit();
            NotificationPusher::success('Data Profile berhasil diubah');
            return redirect()->route('profile')->with(['success' => 'Data Profile berhasil diubah']);
        } catch (\Throwable $th) {
            NotificationPusher::error('Data Profile gagal diubah');
            return redirect()->route('profile')->with(['error' => 'Data Profile gagal diubah']);
        }
    }

    public function changePassword(Request $request, string $id)
    {
        $penduduk = Penduduk::find($id);
        $user = User::find($penduduk->user_id);

        $validated = $request->validate([
            'sandi_lama' => 'required',
            'sandi_baru' => 'required|min:5',
            'ulang_sandi_baru' => 'required|same:sandi_baru',
        ], [
            'sandi_lama.required' => 'Kata Sandi Lama harus diisi',
            'sandi_baru.required' => 'Kata Sandi Baru harus diisi',
            'sandi_baru.min' => 'Panjang Kata Sandi Baru minimal 5',
            'ulang_sandi_baru' => 'Ulangi Kata Sandi harus sama',
        ]);

        if (Hash::check($request->sandi_lama, $user->password)) {
            try {
                // Update password
                $user->password = Hash::make($request->sandi_baru);
                $user->update($validated);

                NotificationPusher::success('Perubahan berhasil disimpan');
                return redirect()->back()->with(['success' => 'Perubahan berhasil disimpan']);
            } catch (\Throwable $th) {
                NotificationPusher::error('Gagal menyimpan perubahan');
                return redirect()->back()->with(['error' => 'Gagal menyimpan perubahan']);
            }
        } else {
            return redirect()->back()->with('error', 'Kata Sandi Lama tidak sesuai.');
        }
    }
}
