<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    public function getByRole(string $role): Collection
    {
        return User::where('role', $role)->get();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findOrFail(int $id): User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }

    public function count(): int
    {
        return User::count();
    }

    public function getStudentsByRoom(int $roomId): Collection
    {
        return User::whereHas('attendances', function ($q) use ($roomId) {
            $q->where('room_id', $roomId);
        })->get();
    }
}
