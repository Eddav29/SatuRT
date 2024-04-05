<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash) : RedirectResponse
    {
        $validator = Validator::make(['id' => $id, 'hash' => $hash], [
            'id' => 'required|uuid|exists:users,user_id',
            'hash' => 'required|string',
        ]);

        if ($validator->fails()) {

            throw new \Illuminate\Validation\ValidationException($validator);
        }
        $user = User::where('user_id', $id)->first();
        if (!sha1($user->email) === $hash) {
            return response()->redirectToRoute('login')->with('error', 'Invalid verification link');
        }

        if ($user->hasVerifiedEmail()) {
            return response()->redirectToRoute('login')->with('error', 'Email already verified');
        }

        $user->markEmailAsVerified();

        return response()->redirectToRoute('login')->with('success', 'Email verified successfully');
    }
}
