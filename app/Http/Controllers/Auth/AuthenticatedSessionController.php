<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('pages.auth.login');
    }

    public function store(Request $request): JsonResponse | RedirectResponse
    {
        $validator = Validator::make($request->only('username', 'password'), [
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string'
        ], [
            'username.exists' => 'The username does not exist'
        ]);
        if ($validator->fails()) {
            if ($request->is('api/*')) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            return back()->withErrors($validator)->withInput()->with('error', 'Username or password is incorrect');
        }

        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }


        if ($request->is('api/*')) {
            $user = User::where('username', $request->username)->first();

            if (!$user) {
                throw new ModelNotFoundException('User not found');
            }
            return response()->json([
                'code' => 200,
                'message' => 'Login success',
                'timestamp' => now(),
                'data' => [
                    'token' => $user->createToken('auth_token')->plainTextToken
                ]
            ], 200);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Login success');
        }
    }

    public function destroy(Request $request): JsonResponse | RedirectResponse
    {
        if ($request->is('api/*')) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'code' => 205,
                'message' => 'Logout success',
                'timestamp' => now()
            ], 205);
        }
        // web
        Auth::guard('web')->logout();

        return response()->redirectToRoute('home')->with('success', 'Logout success');
    }
}
