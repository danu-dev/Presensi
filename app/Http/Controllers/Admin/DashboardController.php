<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
        protected LocationRepositoryInterface $locationRepo,
        protected RoomRepositoryInterface $roomRepo,
        protected AttendanceRepositoryInterface $attendanceRepo,
        protected PermissionRepositoryInterface $permissionRepo
    ) {}

    public function __invoke()
    {
        $users              = $this->userRepo->count();
        $locations          = $this->locationRepo->count();
        $rooms              = $this->roomRepo->count();
        $attendancesToday   = Attendance::whereDate('check_in', now()->startOfDay())->count();
        $pendingPermissions = $this->permissionRepo->getPendingCount();

        $startOfWeek = now()->startOfWeek();
        $endOfWeek   = now()->endOfWeek();

        $weeklyAttendance = Attendance::selectRaw('DATE(check_in) as date, COUNT(*) as total')
            ->whereBetween('check_in', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->all();

        $labels      = [];
        $data        = [];
        $currentDate = $startOfWeek->copy();

        while ($currentDate <= $endOfWeek) {
            $dateString = $currentDate->format('Y-m-d');
            $labels[]   = $currentDate->format('D');
            $data[]     = $weeklyAttendance[$dateString] ?? 0;
            $currentDate->addDay();
        }

        return view('admin.dashboard', compact(
            'users',
            'locations',
            'rooms',
            'attendancesToday',
            'pendingPermissions',
            'labels',
            'data'
        ));
    }
}
