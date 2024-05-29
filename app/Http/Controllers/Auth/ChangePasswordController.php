<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        $user = User::find(Auth::user()->user_id);
        $status = $user->forcefill([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
            'remember_token' => Str::random(60),
        ])->save();

        if ($status) {
            // Invalidate the current session and regenerate the token
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with(NotificationPusher::success('Password berhasil diubah. Silahkan login kembali'));
        }
        return back()->with(NotificationPusher::error('Gagal mengubah password'));
    }
}
