<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use App\Services\ImageManager\ImageService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): Response
    {
        return response()->view('pages.profile.index');
    }

    public function account(): Response
    {
        return response()->view('pages.profile.account');
    }

    public function completeDataForm(string $id): Response
    {
        $penduduk = Penduduk::find($id);

        return response()->view('pages.profile.complete-data', [
            'penduduk' => $penduduk,
            'extension' => 'jpg,jpeg,png',
        ]);
    }

    public function changePasswordForm(string $id): Response
    {
        $penduduk = Penduduk::find($id);
        return response()->view('pages.profile.change-password', [
            'penduduk' => $penduduk,
        ]);
    }

    public function accountForm(string $id): Response
    {
        $penduduk = Penduduk::find($id);
        return response()->view('pages.profile.account-edit', [
            'penduduk' => $penduduk,
            'extension' => 'jpg,jpeg,png',
        ]);
    }

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
        ], [
            'agama.required' => 'Agama harus diisi',
            'desa.required' => 'Desa harus diisi',
            'images.required' => 'Foto KTP harus diisi',
            'golongan_darah.required' => 'Golongan Darah harus diisi',
            'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kota.required' => 'Kota harus diisi',
            'nama.required' => 'Nama harus diisi',
            'nomor_rt.required' => 'Nomor RT harus diisi',
            'nomor_rw.required' => 'Nomor RW harus diisi',
            'pekerjaan.required' => 'Pekerjaan harus diisi',
            'pendidikan_terakhir.required' => 'Pendidikan Terakhir harus diisi',
            'status_hubungan_dalam_keluarga.required' => 'Status Hubungan dalam Keluarga harus diisi',
            'status_perkawinan.required' => 'Status Perkawinan harus diisi',
            'status_penduduk.required' => 'Status Penduduk harus diisi',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
        ]);

        $validated['desa'] = Str::title($validated['desa']);
        $validated['kecamatan'] = Str::title($validated['kecamatan']);
        $validated['kota'] = Str::title($validated['kota']);
        $validated['nama'] = Str::title($validated['nama']);
        $validated['pekerjaan'] = Str::title($validated['pekerjaan']);
        $validated['tempat_lahir'] = Str::title($validated['tempat_lahir']);

        try {
            DB::beginTransaction();
            if ($request->file('images')) {
                $imageName = ImageService::uploadFile('storage_ktp', $request, 'images', 'webp');
                $validated['foto_ktp'] = $imageName;
            }
            $penduduk = Penduduk::find($id);
            $penduduk->update($validated);
            DB::commit();
            NotificationPusher::success('Data Profile berhasil diubah');
            return redirect()->route('profile');
        } catch (\Throwable $th) {
            NotificationPusher::error('Data Profile gagal diubah');
            return redirect()->route('profile');
        }
    }

    public function changePassword(Request $request, string $id)
    {
        $penduduk = Penduduk::find($id);
        $user = User::find($penduduk->user_id);

        $validated = $request->validate([
            'sandi_lama' => 'required',
            'sandi_baru' => 'required|min:8',
            'ulang_sandi_baru' => 'required|same:sandi_baru',
        ], [
            'sandi_lama.required' => 'Kata Sandi Lama harus diisi',
            'sandi_baru.required' => 'Kata Sandi Baru harus diisi',
            'sandi_baru.min' => 'Panjang Kata Sandi Baru minimal 8',
            'ulang_sandi_baru' => 'Ulangi Kata Sandi harus sama',
            'ulang_sandi_baru.same' => 'Ulangi Kata Sandi harus sama dengan Kata Sandi Baru',
        ]);

        if (Hash::check($request->sandi_lama, $user->password)) {
            try {
                // Update password
                $user->password = Hash::make($request->sandi_baru);
                $user->password_changed_at = now();
                $user->update($validated);

                NotificationPusher::success('Perubahan berhasil disimpan');
                return redirect()->back()->with(['success' => 'Perubahan berhasil disimpan']);
            } catch (\Throwable $th) {
                NotificationPusher::error('Gagal menyimpan perubahan');
                return redirect()->back()->with(['error' => 'Gagal menyimpan perubahan']);
            }
        } else {
            NotificationPusher::error('Kata Sandi Lama tidak sesuai');
            return redirect()->back()->with('error', 'Kata Sandi Lama tidak sesuai');
        }
    }

    public function accountStore(Request $request): RedirectResponse
    {
        $userid = Auth::user()->penduduk->user->user_id;
        $user = User::find($userid);

        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'profile' => 'required|image',
        ], [
            'username.required' => 'Username harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'profile.required' => 'Foto Profil harus diisi',
            'profile.image' => 'Foto Profil harus berupa gambar',
        ]);

        if ($request->profile) {
            $user['profile'] = ImageService::uploadFile('public', $request, 'profile');
        }

        DB::beginTransaction();

        try {
            $user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'profile' => $user['profile'],
            ]);

            DB::commit();

            NotificationPusher::success('Data berhasil disimpan');
            return redirect()->route('profile.account');
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan perubahan data akun: ' . $e->getMessage());
            return redirect()->route('profile.account');
        }

    }
}
