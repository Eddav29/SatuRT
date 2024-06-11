<?php

namespace App\Services\Authentication;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public static function login(string $username, string $password) : bool
    {
        try {
            $validator = Validator::make([
                'username' => $username,
                'password' => $password
            ], [
                'username' => 'required|string|exists:users,username',
                'password' => 'required|string|min:8'
            ], [
                'username.exists' => 'The username does not exist'
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            if (!Auth::guard('web')->attempt(['username' => $username, 'password' => $password])) {
                throw new AuthenticationException('Invalid credentials');
            }

            return Auth::guard('web')->attempt(['username' => $username, 'password' => $password]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function logout(Request $request): bool
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
