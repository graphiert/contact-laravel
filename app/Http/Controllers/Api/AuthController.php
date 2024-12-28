<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function token(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $credentials['email'])->first();

        if($user && Auth::attempt($credentials)) {
            $user->tokens()->delete();
            $token = $user->createToken($credentials['email']);

            return response()->json([
                'message' => 'API token key successfully generated.',
                'data' => [
                    'token' => $token->plainTextToken
                ]
            ], 201);
        } else {
            return response()->json([
                'message' => 'These credentials do not match our records.'
            ], 401);
        }
    }

    public function revoke(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'API token key successfully revoked.',
        ], 201);
    }
}
