<?php

namespace App\Repositories\Contracts;

use App\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface LocationRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function getAll(): Collection;
    public function findOrFail(int $id): Location;
    public function create(array $data): Location;
    public function update(Location $location, array $data): bool;
    public function delete(Location $location): bool;
    public function count(): int;
}
