<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationPusher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }


        $request->user()->sendEmailVerificationNotification();

        NotificationPusher::success('Verifikasi email telah dikirimkan ke alamat email Anda.');

        return back()->with('status', 'verification-link-sent');

    }
}
