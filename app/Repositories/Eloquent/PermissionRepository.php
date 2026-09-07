<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getTodayApprovedCount(array $studentIds, string $date): int
    {
        return Permission::whereIn('user_id', $studentIds)
            ->where('status', 'approved')
            ->whereDate('date', $date)
            ->count();
    }

    public function getApprovedCountsGroupedByDate(array $studentIds, string $startDate): array
    {
        return Permission::whereIn('user_id', $studentIds)
            ->where('status', 'approved')
            ->whereDate('date', '>=', $startDate)
            ->selectRaw('DATE(date) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }

    public function getPendingCount(): int
    {
        return Permission::whereNull('status')->count();
    }

    public function getPaginatedWithUser(int $perPage = 10): LengthAwarePaginator
    {
        return Permission::with('user')->latest()->paginate($perPage);
    }

    public function findOrFail(int $id): Permission
    {
        return Permission::with('user')->findOrFail($id);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $permission = Permission::findOrFail($id);
        return $permission->update(['status' => $status]);
    }

    public function countUserApproved(int $userId, string $startDate, string $endDate): int
    {
        return Permission::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereBetween('date', [$startDate, $endDate])
            ->count();
    }
}
