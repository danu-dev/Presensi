<?php

namespace App\Http\Controllers\User;

use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Services\AttendanceService;
use App\Services\DistanceCalculator;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SubmitAttendanceRequest;
use App\Http\Requests\User\SubmitPermissionRequest;
use App\Models\Attendance;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(
        protected AttendanceRepositoryInterface $attendanceRepo,
        protected PermissionRepositoryInterface $permissionRepo,
        protected LocationRepositoryInterface $locationRepo,
        protected RoomRepositoryInterface $roomRepo,
        protected AnnouncementRepositoryInterface $announcementRepo
    ) {}

    public function dashboard()
    {
        $userId = Auth::id();

        $roomIds = Attendance::where('user_id', $userId)
            ->distinct('room_id')
            ->pluck('room_id')
            ->toArray();

        $announcements = $this->announcementRepo->getActiveByRoomIds($roomIds);

        $attendances = Attendance::where('user_id', $userId)
            ->with(['location', 'room'])
            ->orderBy('check_in', 'desc')
            ->take(5)
            ->get();

        $startOfWeek = now()->startOfWeek()->toDateTimeString();
        $endOfWeek   = now()->endOfWeek()->toDateTimeString();
        $attendanceRecords = $this->attendanceRepo->getWeeklyRecords($userId, $startOfWeek, $endOfWeek)
            ->keyBy(fn ($item) => $item->check_in->format('Y-m-d'))
            ->map(function ($item) {
                if ($item->check_in && $item->check_out) {
                    return 'Sudah Absen Keluar';
                } elseif ($item->check_in) {
                    return 'partial';
                }
                return 'absent';
            });

        $startOfMonth = now()->startOfMonth()->toDateTimeString();
        $endOfMonth   = now()->endOfMonth()->toDateTimeString();
        $stats = [
            'present'    => $this->attendanceRepo->countUserPresent($userId, $startOfMonth, $endOfMonth),
            'permission' => $this->permissionRepo->countUserApproved($userId, $startOfMonth, $endOfMonth),
        ];

        return view('user.dashboard', compact('announcements', 'attendances', 'attendanceRecords', 'stats'));
    }

    public function attendanceForm()
    {
        $locations = $this->locationRepo->getAll();
        $rooms     = $this->roomRepo->getAll();
        $todayAttendance = $this->attendanceRepo->findTodayAttendance(Auth::id(), now()->startOfDay()->toDateString());

        return view('user.attendance', compact('locations', 'rooms', 'todayAttendance'));
    }

    public function submitAttendance(
        SubmitAttendanceRequest $request,
        AttendanceService $attendanceService,
        DistanceCalculator $distanceCalculator
    ): JsonResponse {
        try {
            $validated = $request->validated();
            $userId    = Auth::id();

            $result = $validated['type'] === 'check_in'
                ? $attendanceService->checkIn($userId, $validated, $distanceCalculator)
                : $attendanceService->checkOut($userId);

            return response()->json(
                $result['success']
                    ? ['success' => true, 'message' => $result['message']]
                    : ['success' => false, 'error' => $result['error']],
                $result['status']
            );
        } catch (\Exception $e) {
            Log::error('Attendance submission failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
        }
    }

    public function history()
    {
        $attendances = $this->attendanceRepo->getUserHistoryPaginated(Auth::id(), 10);
        return view('user.history', compact('attendances'));
    }

    public function permissionForm()
    {
        $lastPermission = Permission::where('user_id', Auth::id())->latest()->first();
        return view('user.permission', compact('lastPermission'));
    }

    public function submitPermission(SubmitPermissionRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $path = $request->file('proof_image')->store('permissions', 'public');

            Permission::create([
                'user_id'     => Auth::id(),
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'date'        => $validated['date'],
                'proof_image' => $path,
            ]);

            return redirect()->route('user.permission')->with('success', 'Pengajuan izin berhasil.');
        } catch (\Exception $e) {
            Log::error('Permission submission failed', ['error' => $e->getMessage()]);
            return redirect()->route('user.permission')->with('error', 'Terjadi kesalahan saat mengajukan izin.');
        }
    }
}
