<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Authentication\AuthService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{


    public function create(): View
    {
        return view('pages.auth.login');
    }

    public function store(Request $request): JsonResponse | RedirectResponse
    {
        try {
            NotificationPusher::success('Login success');
            $token = AuthService::login($request->username, $request->password);

            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Login success',
                    'timestamp' => now(),
                    'data' => [
                        'token' => $token
                    ]
                ], 200);
            }

            NotificationPusher::success('Login success');
            return response()->redirectToRoute('dashboard');

        } catch (\Exception  $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                throw new AuthenticationException($e->getMessage());
            }
            NotificationPusher::error($e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(Request $request): JsonResponse | RedirectResponse
    {
        try {
            $repsonse = AuthService::logout($request);
            if (!$repsonse) {
                throw new AuthenticationException('Logout failed');
            }
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Logout success',
                    'timestamp' => now()
                ], 200);
            }
            NotificationPusher::success('Logout success');
            return response()->redirectTo('/');
        } catch (\Exception $e) {
            if ($request->is('api/*') || $request->wantsJson()) {
                throw new AuthenticationException($e->getMessage());
            }
            NotificationPusher::error($e->getMessage());
            return back();
        }

    }
}
