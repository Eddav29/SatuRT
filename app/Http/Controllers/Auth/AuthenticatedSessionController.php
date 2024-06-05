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
use Illuminate\Support\Facades\Auth;

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
            AuthService::login($request->username, $request->password);
            $request->session()->regenerate();

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
            NotificationPusher::success('Logout success');
            return response()->redirectTo('/');
        } catch (\Exception $e) {
            NotificationPusher::error($e->getMessage());
            return back();
        }
    }
}
