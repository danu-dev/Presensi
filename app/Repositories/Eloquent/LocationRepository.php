<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class LocationRepository implements LocationRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Location::paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Location::all();
    }

    public function findOrFail(int $id): Location
    {
        return Location::findOrFail($id);
    }

    public function create(array $data): Location
    {
        return Location::create($data);
    }

    public function update(Location $location, array $data): bool
    {
        return $location->update($data);
    }

    public function delete(Location $location): bool
    {
        return (bool) $location->delete();
    }

    public function count(): int
    {
        return Location::count();
    }
}
