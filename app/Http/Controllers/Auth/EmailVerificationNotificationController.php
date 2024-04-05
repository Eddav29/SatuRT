<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {

        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'The email does not exist'
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response()->redirectToRoute('login')->with('error', 'Email already verified');
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->redirectToRoute('login')->with('success', 'Email verification link sent');
    }
}
