<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\HomeContentRepositoryInterface;
use App\Models\HomeContent;
use Illuminate\Database\Eloquent\Collection;

class HomeContentRepository implements HomeContentRepositoryInterface
{
    public function getAll(): Collection
    {
        return HomeContent::all();
    }

    public function create(array $data): HomeContent
    {
        return HomeContent::create($data);
    }

    public function update(HomeContent $homeContent, array $data): bool
    {
        return $homeContent->update($data);
    }

    public function delete(HomeContent $homeContent): bool
    {
        return (bool) $homeContent->delete();
    }
}
