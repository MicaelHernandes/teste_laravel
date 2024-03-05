<?php

namespace App\services;

use App\Models\User;
use App\repositories\UserRepository;
use App\repositories\UserRepositoryInterface;

interface UserServiceInterface
{
    public function registerUser(array $data): User;
    public function loginUser(array $data): array;
    public function getUserById(int $id): User;
}

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $repo;
    public function __construct(private UserRepository $repository)
    {
        $this->repo = $repository;
    }

    public function loginUser(array $data): array
    {
        try {
            if (auth()->attempt($data["email"], $data["password"])) {
                $token = auth()->user()->createToken('api_token', now()->addHours(24));
                return (array) $token->plainTextToken;
            }
        } catch (\Throwable $e) {
            throw new \Exception($e);
        }
    }

    public function registerUser(array $data): User
    {
        try {
            return $this->repo->create($data);
        } catch (\Throwable $e) {
            throw new \Exception($e);
        }
    }

    public function getUserById(int $id): User
    {
        try {
            return $this->repo->find($id);
        } catch (\Throwable $e) {
            throw new \Exception($e);
        }
    }
}
