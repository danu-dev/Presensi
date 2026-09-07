<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Models\Room;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository implements RoomRepositoryInterface
{
    public function paginateWithGuru(int $perPage = 10): LengthAwarePaginator
    {
        return Room::with('guru')->paginate($perPage);
    }

    public function getByGuruId(int $guruId): Collection
    {
        return Room::where('guru_id', $guruId)->get();
    }

    public function getAll(): Collection
    {
        return Room::all();
    }

    public function findOrFail(int $id): Room
    {
        return Room::findOrFail($id);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data): bool
    {
        return $room->update($data);
    }

    public function delete(Room $room): bool
    {
        return (bool) $room->delete();
    }

    public function count(): int
    {
        return Room::count();
    }
}
