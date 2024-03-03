<?php

namespace App\repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function find(int $id): User;
    public function findByEmail(string $email): User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): void;
    public function all(): array;
}

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Model $model)
    {
    }
    public function find(int $id): User
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function all(): array
    {
        return $this->model->all();
    }
}
