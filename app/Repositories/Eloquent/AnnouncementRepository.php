<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Models\Announcement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    public function getActiveByRoomIds(array $roomIds): Collection
    {
        return Announcement::with(['creator', 'room'])
            ->where(function ($query) use ($roomIds) {
                $query->whereIn('room_id', $roomIds)
                      ->orWhereNull('room_id');
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now()->startOfDay());
            })
            ->latest()
            ->get();
    }

    public function paginateByCreator(int $creatorId, int $perPage = 10): LengthAwarePaginator
    {
        return Announcement::with(['creator', 'room'])
            ->where('created_by', $creatorId)
            ->latest()
            ->paginate($perPage);
    }

    public function countActiveByCreator(int $creatorId): int
    {
        return Announcement::where('created_by', $creatorId)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->count();
    }

    public function countExpiredByCreator(int $creatorId): int
    {
        return Announcement::where('created_by', $creatorId)
            ->where('expires_at', '<', now())
            ->count();
    }

    public function create(array $data): Announcement
    {
        return Announcement::create($data);
    }

    public function update(Announcement $announcement, array $data): bool
    {
        return $announcement->update($data);
    }

    public function delete(Announcement $announcement): bool
    {
        return (bool) $announcement->delete();
    }
}
