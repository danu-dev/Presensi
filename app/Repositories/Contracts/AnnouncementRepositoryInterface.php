<?php

namespace App\Repositories\Contracts;

use App\Models\Announcement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AnnouncementRepositoryInterface
{
    public function getActiveByRoomIds(array $roomIds): Collection;
    public function paginateByCreator(int $creatorId, int $perPage = 10): LengthAwarePaginator;
    public function countActiveByCreator(int $creatorId): int;
    public function countExpiredByCreator(int $creatorId): int;
    public function create(array $data): Announcement;
    public function update(Announcement $announcement, array $data): bool;
    public function delete(Announcement $announcement): bool;
}
