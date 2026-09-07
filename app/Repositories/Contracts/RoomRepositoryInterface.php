<?php

namespace App\Repositories\Contracts;

use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RoomRepositoryInterface
{
    public function paginateWithGuru(int $perPage = 10): LengthAwarePaginator;
    public function getByGuruId(int $guruId): Collection;
    public function getAll(): Collection;
    public function findOrFail(int $id): Room;
    public function create(array $data): Room;
    public function update(Room $room, array $data): bool;
    public function delete(Room $room): bool;
    public function count(): int;
}
