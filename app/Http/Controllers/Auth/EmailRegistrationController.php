<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('email') ,[
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $request->user()->update([
            'email' => $request->email,
            'email_verified_at' => null
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'Email registered',
            'timestamp' => now(),
            'data' => [
                'email' => $request->email
            ]
        ], 201);
    }
}
