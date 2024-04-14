<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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

    // public function edit(string $id): Response
    // {
    //     $breadcrumb = [
    //         'list' => ['Home', 'Informasi', 'Edit Informasi'],
    //         'url' => ['home', 'informasi.index', ''],
    //     ];

    //     $information = Informasi::find($id);

    //     return response()->view('pages.information.edit', [
    //         'breadcrumb' => $breadcrumb,
    //         'information' => $information
    //     ]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     $information = Informasi::find($id);

    //     $validated = $request->validate([
    //         'penduduk_id' => ['required', 'exists:penduduk,penduduk_id'],
    //         'jenis_informasi' => ['required'],
    //         'judul_informasi' => ['required', 'string', 'min:3', 'max:255'],
    //         'isi_informasi' => ['required', 'string', 'min:3'],
    //         'thumbnail_url' => ['required', 'file'],
    //     ], [
    //         'jenis_informasi.required' => 'Jenis informasi harus diisi.',
    //         'judul_informasi.required' => 'Judul informasi harus diisi.',
    //         'judul_informasi.min' => 'Judul informasi minimal memiliki panjang :min karakter.',
    //         'judul_informasi.max' => 'Judul informasi maksimal memiliki panjang :max karakter.',
    //         'isi_informasi.required' => 'Isi informasi harus diisi.',
    //         'isi_informasi.min' => 'Isi informasi minimal memiliki panjang :min karakter.',
    //         'thumbnail_url.required' => 'Thumbnail harus diisi.',
    //         'thumbnail_url.file' => 'Thumbnail harus berupa gambar.',
    //     ]);

    //     if ($request->file('thumbnail_url')) {
    //         Storage::delete('public/information_images/' . $information->thumbnail_url);

    //         if ($validated['jenis_informasi'] == 'Pengumuman') {
    //             $fileName = $request->file('thumbnail_url')->getClientOriginalName();
    //             $request->file('thumbnail_url')->storeAs('information_images', $fileName, 'public');
    //             $validated['thumbnail_url'] = $fileName;
    //         } else {
    //             $validated['thumbnail_url'] = $request->file('thumbnail_url')->store('information_images', 'public');
    //             $validated['thumbnail_url'] = basename($validated['thumbnail_url']);
    //         }
    //     }

    //     try {
    //         $information->update($validated);

    //         return redirect()->route('informasi.index')->with(['success' => 'Perubahan berhasila disimpan']);
    //     } catch (\Throwable $th) {
    //         return redirect()->route('informasi.index')->with(['error' => 'Gagal menyimpan perubahan']);
    //     }
    // }

    //  public function edit(Request $request): View
    // {
    //     return view('pages.profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    // /**
    //  * Update the user's profile information.
    //  */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */
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
