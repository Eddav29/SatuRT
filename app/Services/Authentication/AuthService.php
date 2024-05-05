<?php

namespace App\Services\Authentication;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthService
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
}
