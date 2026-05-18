<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function assignableUsers(User $user): array
    {
        $query = User::query()->orderBy('name');

        if (! $user->isAdmin()) {
            $query->whereKey($user->id);
        }

        return $query->get(['id', 'name', 'email'])->toArray();
    }

    public function paginate(int $perPage = 10)
    {
        return User::query()
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): ?User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) User::destroy($id);
    }
}
