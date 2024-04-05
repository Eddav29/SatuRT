<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required|email|exists:users,email'
        ]);



        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );



        return $status === Password::RESET_LINK_SENT
                    ? response()->json([
                        'code' => 200,
                        'message' => 'Password reset link sent',
                        'timestamp' => now()
                    ], 200)
                    : throw new \Illuminate\Validation\ValidationException($validator);
    }
}
