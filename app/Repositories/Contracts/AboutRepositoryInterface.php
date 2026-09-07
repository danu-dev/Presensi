<?php

namespace App\Repositories\Contracts;

use App\Models\About;
use Illuminate\Database\Eloquent\Collection;

interface AboutRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): About;
    public function update(About $about, array $data): bool;
    public function delete(About $about): bool;
}
