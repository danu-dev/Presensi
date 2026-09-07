<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\AboutRepositoryInterface;
use App\Models\About;
use Illuminate\Database\Eloquent\Collection;

class AboutRepository implements AboutRepositoryInterface
{
    public function getAll(): Collection
    {
        return About::all();
    }

    public function create(array $data): About
    {
        return About::create($data);
    }

    public function update(About $about, array $data): bool
    {
        return $about->update($data);
    }

    public function delete(About $about): bool
    {
        return (bool) $about->delete();
    }
}
