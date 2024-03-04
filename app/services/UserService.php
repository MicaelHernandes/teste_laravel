<?php

namespace App\services;

use App\Models\User;
use App\repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

interface UserServiceInterface
{
    public function registerUser(array $data): User;
    public function loginUser(array $data): array;
    public function getUserById(int $id): User;
}

class UserService implements UserServiceInterface
{

    public function __construct(private UserRepositoryInterface $repo)
    {
    }

    public function loginUser(array $data): array
    {
        try {
            $user = $this->repo->findByEmail($data['email']);

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return [
                'user' => $user,
                'token' => $user->createToken('authToken')->accessToken,
            ];
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
