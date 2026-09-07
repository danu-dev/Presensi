<?php

namespace App\Repositories\Contracts;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

interface GalleryRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): Gallery;
    public function update(Gallery $gallery, array $data): bool;
    public function delete(Gallery $gallery): bool;
}
