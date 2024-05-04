<?php

namespace App\Services\Authentication;

use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthService implements AuthServiceInterface
{
    public static function login(string $username, string $password): String
    {
        try {
            $validator = Validator::make([
                'username' => $username,
                'password' => $password
            ], [
                'username' => 'required|string|exists:users,username',
                'password' => 'required|string'
            ], [
                'username.exists' => 'The username does not exist'
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            if (!Auth::attempt(['username' => $username, 'password' => $password])) {
                throw new AuthenticationException('Invalid credentials');
            }

            $user = User::where('username', $username)->firstOrFail();

            return $user->createToken('auth_token', ['role:' . $user->role])->plainTextToken;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function logout(Request $request): bool
    {
        try {
            if ($request->is('api/*')) {
                $request->user()->currentAccessToken()->delete();
                return true;
            }

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }

    public static function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }
}
