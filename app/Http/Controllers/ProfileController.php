<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

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
            'penduduk' => $penduduk
        ]);
    }

    public function changePasswordForm(string $id): Response
    {
        $penduduk = Penduduk::find($id);
        return response()->view('pages.profile.change-password', [
            'penduduk' => $penduduk,
        ]);
    }

    public function completeData(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:penduduk,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan' => 'nullable|string|max:255',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'agama' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu,Lainnya',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status_hubungan_dalam_keluarga' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|in:Kawin,Belum Kawin,Cerai',
            'pendidikan_terakhir' => 'nullable|string|in:SD,SMP,SMA,D3,S1,S2,S3',
            'foto_ktp' => 'nullable|string|max:255',
            'status_penduduk' => 'nullable|in:Domisili,Non Domisili',
            'nomor_rt' => 'nullable|integer',
            'nomor_rw' => 'nullable|integer',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:255',
        ]);

        $penduduk = Penduduk::find($id);
        $penduduk ->update($validated);

        try {
            return redirect()->route('profile.index')->with(['success' => 'Data Profile berhasil diubah']);
        } catch (\Throwable $th) {
            return redirect()->route('profile.index')->with(['error' => 'Data Profile gagal diubah']);
        }
    }

    public function changePassword(Request $request, string $id)
    {
        $penduduk = Penduduk::find($id);
        $user = User::find($penduduk->user_id);

        $validated = $request->validate([
            'sandi_lama' => 'required',
            'sandi_baru' => 'required|min:8', // Atur kebutuhan validasi sesuai kebutuhan Anda
            'ulang_sandi_baru' => 'required|same:sandi_baru',
        ]);

        if ($request->sandi_lama == $user->password) {
            try {
                $user->password = Hash::make($request->sandi_baru);
                $user->update($validated);

                return redirect()->route('profile')->with(['success' => 'Perubahan berhasila disimpan']);
            } catch (\Throwable $th) {
                return redirect()->route('profile')->with(['error' => 'Gagal menyimpan perubahan']);
            }
        } else {
            return redirect()->back()->with('error', 'Kata sandi lama tidak sesuai.');
        }

    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
