<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function dashboard()
    {
        $rooms = Room::where('guru_id', auth()->id())->get();
        $roomIds = $rooms->pluck('id');

        $studentIds = Attendance::whereIn('room_id', $roomIds)
            ->distinct('user_id')
            ->pluck('user_id');

        // Calculate weekly attendance data
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $present = Attendance::whereIn('room_id', $roomIds)
                ->whereDate('check_in', $date)
                ->whereNotNull('check_in')
                ->count();
            $permission = Permission::whereIn('user_id', $studentIds)
                ->where('status', 'approved')
                ->whereDate('date', $date)
                ->count();
            $totalStudents = $studentIds->count();
            $absent = max(0, $totalStudents - ($present + $permission));
            $weeklyData[] = [
                'day' => now()->subDays($i)->locale('id')->format('l'),
                'present' => $present,
                'permission' => $permission,
                'absent' => $absent
            ];
        }

        $pendingPermissions = Permission::whereNull('status')->count();

        $todayStats = [
            'present' => Attendance::whereIn('room_id', $roomIds)
                ->whereDate('check_in', now()->toDateString())
                ->whereNotNull('check_in')
                ->count(),
            'permission' => Permission::whereIn('user_id', $studentIds)
                ->where('status', 'approved')
                ->whereDate('date', now()->toDateString())
                ->count(),
            'absent' => $studentIds->count() - (
                Attendance::whereIn('room_id', $roomIds)
                    ->whereDate('check_in', now()->toDateString())
                    ->whereNotNull('check_in')
                    ->count() +
                Permission::whereIn('user_id', $studentIds)
                    ->where('status', 'approved')
                    ->whereDate('date', now()->toDateString())
                    ->count()
            )
        ];

        return view('guru.dashboard', compact('rooms', 'pendingPermissions', 'todayStats', 'weeklyData'));
    }

    public function report(Request $request)
    {
        $rooms = Room::where('guru_id', auth()->id())->get();
        $roomIds = $rooms->pluck('id');

        $query = Attendance::whereIn('room_id', $roomIds)
            ->with('user', 'location', 'room');

        if ($startDate = $request->query('start_date')) {
            $query->whereDate('check_in', '>=', $startDate);
        }
        if ($endDate = $request->query('end_date')) {
            $query->whereDate('check_in', '<=', $endDate);
        }
        if ($roomId = $request->query('room_id')) {
            $query->where('room_id', $roomId);
        }

        $attendances = $query->orderBy('check_in', 'desc')->paginate(10);

        $todayStats = [
            'present' => Attendance::whereIn('room_id', $roomIds)
                ->whereDate('check_in', now()->toDateString())
                ->whereNotNull('check_in')
                ->count(),
        ];

        return view('guru.report', compact('attendances', 'rooms', 'todayStats'));
    }

    public function permissions()
    {
        $permissions = Permission::with('user')->latest()->paginate(10);
        return view('guru.permissions', compact('permissions'));
    }

    public function validatePermission(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $permission = Permission::findOrFail($id);
        $permission->update(['status' => $request->status]);
        return back()->with('success', 'Izin telah divalidasi.');
    }

    public function export(Request $request)
    {
        $roomIds = Room::where('guru_id', auth()->id())->pluck('id');
        return Excel::download(new AttendanceExport($request->start_date, $request->end_date, $request->room_id, $roomIds), 'laporan_absensi.xlsx');
    }

    public function show($id)
    {
        $permission = Permission::with('user')->findOrFail($id);
        return view('guru.permission_show', compact('permission'));
    }
    
}