<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserService $userService): JsonResponse
    {
        $user = $userService->createUser([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        if ($user) {
            UserCreated::dispatch($user);
            return response()->json(['message' => 'Registered successfully'], Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Issue registering'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $jwt = JWT::encode(['sub' => $user->id], config('auth.jwt_secret'), 'HS256');
            return response()->json(['token' => $jwt]);
        }
        return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function requestPassword(): JsonResponse
    {

    }

    public function resetPassword(): JsonResponse
    {

    }

    public function getProfile(): JsonResponse
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
