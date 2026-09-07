<?php

namespace App\Repositories\Contracts;

use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    public function getTodayApprovedCount(array $studentIds, string $date): int;

    public function getApprovedCountsGroupedByDate(array $studentIds, string $startDate): array;

    public function getPendingCount(): int;

    public function getPaginatedWithUser(int $perPage = 10): LengthAwarePaginator;

    public function findOrFail(int $id): Permission;

    public function updateStatus(int $id, string $status): bool;

    public function countUserApproved(int $userId, string $startDate, string $endDate): int;
}
