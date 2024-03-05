<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserStoreRequest;
use App\services\UserService;
use App\services\UserServiceInterface;

class AuthApiController extends Controller
{
    private UserServiceInterface $services;
    public function __construct(private UserService $service)
    {
        $this->services = $service;
    }

    public function register(UserStoreRequest $request)
    {
        try {
            $user = $this->services->registerUser($request->toArray());
            return response()->json([
                "message" => "User created successfully",
                'user' => $user
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function login(UserAuthRequest $request)
    {
        try {
            $token = $this->services->loginUser($request->toArray());
            return response()->json([
                "message" => "User logged in successfully",
                'token' => $token
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
