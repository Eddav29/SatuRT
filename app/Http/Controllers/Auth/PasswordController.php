<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only('current_password', 'password', 'password_confirmation'), [
            'current_password' => ['required', 'password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }


        $request->user()->update([
            'password' => Hash::make($validator['password']),
        ]);

        return response()->json([
            'code' => 200,
            'message' => 'Password updated',
            'timestamp' => now()
        ], 200);

    }
}
