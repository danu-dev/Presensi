<?php

namespace App\Http\Controllers\Guru;

use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\SubmitManualAttendanceRequest;
use App\Http\Requests\Guru\ValidatePermissionRequest;
use App\Http\Resources\UserResource;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Room;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function __construct(
        protected AttendanceRepositoryInterface $attendanceRepo,
        protected PermissionRepositoryInterface $permissionRepo,
        protected RoomRepositoryInterface $roomRepo,
        protected UserRepositoryInterface $userRepo
    ) {}

    public function dashboard()
    {
        $rooms = $this->roomRepo->getByGuruId(auth()->id());
        if ($rooms->isEmpty()) {
            return view('guru.dashboard', [
                'rooms'              => collect(),
                'pendingPermissions' => 0,
                'todayStats'         => ['present' => 0, 'permission' => 0, 'absent' => 0],
                'weeklyData'         => [],
                'announcements'      => collect(),
            ]);
        }

        $roomIds = $rooms->pluck('id')->toArray();

        $studentIds = Attendance::whereIn('room_id', $roomIds)
            ->distinct('user_id')
            ->pluck('user_id')
            ->toArray();

        $todayDate = now()->toDateString();
        $todayPresent = $this->attendanceRepo->getTodayPresentCount($roomIds, $todayDate);
        $todayPermission = $this->permissionRepo->getTodayApprovedCount($studentIds, $todayDate);

        $totalStudents = count($studentIds);
        $todayStats = [
            'present'    => $todayPresent,
            'permission' => $todayPermission,
            'absent'     => max(0, $totalStudents - ($todayPresent + $todayPermission)),
        ];

        $sevenDaysAgo = now()->subDays(6)->toDateString();
        $attendanceCountsByDate = $this->attendanceRepo->getCountsGroupedByDate($roomIds, $sevenDaysAgo);
        $permissionCountsByDate = $this->permissionRepo->getApprovedCountsGroupedByDate($studentIds, $sevenDaysAgo);

        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $dayObj = now()->subDays($i);
            $date = $dayObj->toDateString();
            $present = (int) ($attendanceCountsByDate[$date] ?? 0);
            $permission = (int) ($permissionCountsByDate[$date] ?? 0);
            $absent = max(0, $totalStudents - ($present + $permission));

            $weeklyData[] = [
                'day'        => $dayObj->locale('id')->format('l'),
                'present'    => $present,
                'permission' => $permission,
                'absent'     => $absent,
            ];
        }

        $pendingPermissions = $this->permissionRepo->getPendingCount();
        $announcements = Announcement::with(['creator', 'room'])
            ->active()
            ->where('created_by', auth()->id())
            ->latest()
            ->get();

        return view('guru.dashboard', compact('rooms', 'pendingPermissions', 'todayStats', 'weeklyData', 'announcements'));
    }

    public function report(Request $request)
    {
        $rooms   = $this->roomRepo->getByGuruId(auth()->id());
        $roomIds = $rooms->pluck('id')->toArray();

        $attendances = $this->attendanceRepo->getPaginatedReports(
            $roomIds,
            $request->query('start_date'),
            $request->query('end_date'),
            $request->query('room_id') ? (int) $request->query('room_id') : null,
            10
        );

        $todayStats = [
            'present' => $this->attendanceRepo->getTodayPresentCount($roomIds, now()->toDateString()),
        ];

        return view('guru.report', compact('attendances', 'rooms', 'todayStats'));
    }

    public function permissions()
    {
        $permissions = $this->permissionRepo->getPaginatedWithUser(10);
        return view('guru.permissions', compact('permissions'));
    }

    public function validatePermission(ValidatePermissionRequest $request, $id)
    {
        $permission = $this->permissionRepo->findOrFail((int) $id);
        $teacherId  = auth()->id();
        $roomIds    = $this->roomRepo->getByGuruId($teacherId)->pluck('id');
        $studentIds = Attendance::whereIn('room_id', $roomIds)->distinct('user_id')->pluck('user_id')->toArray();

        if (!in_array($permission->user_id, $studentIds)) {
            abort(403, 'Anda tidak memiliki akses untuk memvalidasi izin siswa ini.');
        }

        $this->permissionRepo->updateStatus((int) $id, $request->status);
        return back()->with('success', 'Izin telah divalidasi.');
    }

    public function export(Request $request)
    {
        $roomIds = $this->roomRepo->getByGuruId(auth()->id())->pluck('id');
        return Excel::download(new AttendanceExport($request->start_date, $request->end_date, $request->room_id, $roomIds), 'laporan_absensi.xlsx');
    }

    public function show($id)
    {
        $permission = $this->permissionRepo->findOrFail((int) $id);
        $teacherId  = auth()->id();
        $roomIds    = $this->roomRepo->getByGuruId($teacherId)->pluck('id');
        $studentIds = Attendance::whereIn('room_id', $roomIds)->distinct('user_id')->pluck('user_id')->toArray();

        if (!in_array($permission->user_id, $studentIds)) {
            abort(403, 'Anda tidak memiliki izin untuk melihat data ini.');
        }

        return view('guru.permission_show', compact('permission'));
    }

    public function manualAttendance(Request $request)
    {
        $teacherId = auth()->id();
        $rooms     = $this->roomRepo->getByGuruId($teacherId);

        $selectedRoomId = $request->room_id ?? ($rooms->first()->id ?? null);
        $date           = $request->date ?? now()->toDateString();

        $students            = collect();
        $existingAttendances = collect();
        $permissions         = collect();

        if ($selectedRoomId) {
            $students = $this->userRepo->getStudentsByRoom($selectedRoomId);

            $existingAttendances = Attendance::where('room_id', $selectedRoomId)
                ->whereDate('check_in', $date)
                ->get()
                ->keyBy('user_id');

            $permissions = Permission::whereIn('user_id', $students->pluck('id'))
                ->whereDate('date', $date)
                ->where('status', 'approved')
                ->get()
                ->keyBy('user_id');
        }

        return view('guru.manual_attendance', compact(
            'rooms',
            'students',
            'selectedRoomId',
            'date',
            'existingAttendances',
            'permissions'
        ));
    }

    public function submitManualAttendance(SubmitManualAttendanceRequest $request, AttendanceService $attendanceService)
    {
        $room = $this->roomRepo->findOrFail($request->room_id);

        if ($room->guru_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $attendanceService->recordManualAttendance(
            $room->id,
            $request->date,
            auth()->id(),
            $request->attendances
        );

        return back()->with('success', 'Attendance records updated successfully.');
    }

    public function getStudentsByRoom($roomId)
    {
        $students = $this->userRepo->getStudentsByRoom((int) $roomId);
        return UserResource::collection($students);
    }
}
