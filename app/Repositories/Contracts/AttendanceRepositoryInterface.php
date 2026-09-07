<?php

namespace App\Repositories\Contracts;

use App\Models\Attendance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceRepositoryInterface
{
    public function getTodayPresentCount(array $roomIds, string $date): int;
    
    public function getCountsGroupedByDate(array $roomIds, string $startDate): array;
    
    public function getPaginatedReports(array $roomIds, ?string $startDate, ?string $endDate, ?int $roomId, int $perPage = 10): LengthAwarePaginator;
    
    public function findTodayAttendance(int $userId, string $date): ?Attendance;
    
    public function getWeeklyRecords(int $userId, string $startDate, string $endDate): Collection;
    
    public function getUserHistoryPaginated(int $userId, int $perPage = 10): LengthAwarePaginator;
    
    public function countUserPresent(int $userId, string $startDate, string $endDate): int;
}
