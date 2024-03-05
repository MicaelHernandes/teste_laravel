<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\services\UserService;
use App\services\UserServiceInterface;
use Illuminate\Http\Request;

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
}
