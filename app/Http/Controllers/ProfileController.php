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
use Illuminate\Support\Facades\Storage;

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
                $imageName = ImageService::uploadFile('storage_ktp', $request);
                $validated['foto_ktp'] = $imageName;
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
        // dd($request->all());

        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
        ]);

        if ($request->profile) {
            Storage::delete('public/account_images/' . $user->profile);

            $imageFileName = $request->file('profile')->store('account_images', 'public');
            $user['profile'] = basename($imageFileName);
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
            return redirect()->route('profile.account')->with(['success' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollback();
            NotificationPusher::error('Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->route('profile.account')->with(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

}
