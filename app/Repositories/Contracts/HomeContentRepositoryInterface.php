<?php

namespace App\Repositories\Contracts;

use App\Models\HomeContent;
use Illuminate\Database\Eloquent\Collection;

interface HomeContentRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): HomeContent;
    public function update(HomeContent $homeContent, array $data): bool;
    public function delete(HomeContent $homeContent): bool;
}
