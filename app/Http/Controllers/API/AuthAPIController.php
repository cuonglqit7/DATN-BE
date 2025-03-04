<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthAPIController extends Controller
{
    public function login()
    {
        try {
            request()->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $user = User::where('email', request('email'))->first();

            if (!$user || !Hash::check(request('password'), $user->password) || !$user->hasRole(['user'])) {
                throw ValidationException::withMessages([
                    'email' => ['The provider credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('access_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successfully',
                'access_token' => $token,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                return response()->json([
                    'errors' => [$th->getMessage()],
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'errors' => [$th->getMessage()],
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function register(UserRequest $request)
    {
        try {

            $user = User::create($request->all());
            $user->syncRoles('user');
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Register user successfully',
                'access_token' => $token,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                return response()->json([
                    'errors' => [$th->getMessage()],
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'errors' => $th->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout()
    {
        try {
            request()->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
