<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function getByRole(string $role): Collection;
    public function findById(int $id): ?User;
    public function findOrFail(int $id): User;
    public function create(array $data): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
    public function count(): int;
    public function getStudentsByRoom(int $roomId): Collection;
}
