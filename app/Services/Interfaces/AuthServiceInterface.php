<?php

namespace App\Services\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public static function login (string $username, string $password): String;
    public static function logout (Request $request) : bool;

    public static function forgotPassword (Request $request): RedirectResponse | JsonResponse;
    public static function resetPassword (Request $request): RedirectResponse | JsonResponse;
}
