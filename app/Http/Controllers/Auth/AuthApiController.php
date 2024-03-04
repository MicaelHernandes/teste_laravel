<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
}
