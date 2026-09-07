<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\GalleryRepositoryInterface;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

class GalleryRepository implements GalleryRepositoryInterface
{
    public function getAll(): Collection
    {
        return Gallery::all();
    }

    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }

    public function update(Gallery $gallery, array $data): bool
    {
        return $gallery->update($data);
    }

    public function delete(Gallery $gallery): bool
    {
        return (bool) $gallery->delete();
    }
}
