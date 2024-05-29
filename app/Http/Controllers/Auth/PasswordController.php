<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => 'required|string|confirmed|min:8',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        NotificationPusher::success('Password berhasil diupdate');
        return back();
    }
}
