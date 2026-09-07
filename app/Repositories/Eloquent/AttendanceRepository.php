<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Models\Attendance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function getTodayPresentCount(array $roomIds, string $date): int
    {
        return Attendance::whereIn('room_id', $roomIds)
            ->whereDate('check_in', $date)
            ->whereNotNull('check_in')
            ->count();
    }

    public function getCountsGroupedByDate(array $roomIds, string $startDate): array
    {
        return Attendance::whereIn('room_id', $roomIds)
            ->whereDate('check_in', '>=', $startDate)
            ->whereNotNull('check_in')
            ->selectRaw('DATE(check_in) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }

    public function getPaginatedReports(array $roomIds, ?string $startDate, ?string $endDate, ?int $roomId, int $perPage = 10): LengthAwarePaginator
    {
        $query = Attendance::whereIn('room_id', $roomIds)
            ->with(['user', 'location', 'room']);

        if ($startDate) {
            $query->whereDate('check_in', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('check_in', '<=', $endDate);
        }
        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        return $query->orderBy('check_in', 'desc')->paginate($perPage);
    }

    public function findTodayAttendance(int $userId, string $date): ?Attendance
    {
        return Attendance::where('user_id', $userId)
            ->whereDate('check_in', $date)
            ->first();
    }

    public function getWeeklyRecords(int $userId, string $startDate, string $endDate): Collection
    {
        return Attendance::where('user_id', $userId)
            ->whereBetween('check_in', [$startDate, $endDate])
            ->get();
    }

    public function getUserHistoryPaginated(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Attendance::where('user_id', $userId)
            ->with(['location', 'room'])
            ->latest()
            ->paginate($perPage);
    }

    public function countUserPresent(int $userId, string $startDate, string $endDate): int
    {
        return Attendance::where('user_id', $userId)
            ->whereBetween('check_in', [$startDate, $endDate])
            ->whereNotNull('check_in')
            ->count();
    }
}
