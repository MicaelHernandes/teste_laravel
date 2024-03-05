<?php

namespace App\repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RuntimeException;

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
    private Model $model;
    public function __construct(private User $user)
    {
        $this->model = $user;
    }
    public function find(int $id): User
    {
        DB::beginTransaction();
        try {
            DB::commit();
            return $this->model->find($id);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th);
        }
    }

    public function findByEmail(string $email): User
    {
        DB::beginTransaction();
        try {
            DB::commit();
            return $this->model->where('email', $email)->first();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th);
        }
    }

    public function create(array $data): User
    {
        DB::beginTransaction();
        try {
            $user =  $this->model->create($data);
            DB::commit();
            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \RuntimeException($e);
        }
    }

    public function update(User $user, array $data): User
    {
        DB::beginTransaction();
        try {
            $user->update($data);
            DB::commit();
            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new RuntimeException($e);
        }
    }

    public function delete(User $user): void
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \RuntimeException($e);
        }
    }

    public function all(): array
    {
        DB::beginTransaction();
        try {
            DB::commit();
            return (array) $this->model->all();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }
}
