<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Room;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuruController extends Controller
{
    public function dashboard()
    {
        // Get rooms managed by the authenticated teacher
        $rooms = Room::where('guru_id', auth()->id())->get();
        if ($rooms->isEmpty()) {
            return view('guru.dashboard', [
                'rooms'              => collect(),
                'pendingPermissions' => 0,
                'todayStats'         => ['present' => 0, 'permission' => 0, 'absent' => 0],
                'weeklyData'         => [],
                'announcements'      => collect(),
            ]);
        }

        $roomIds = $rooms->pluck('id');

        // Get distinct student IDs who have attended these rooms
        $studentIds = Attendance::whereIn('room_id', $roomIds)
            ->distinct('user_id')
            ->pluck('user_id');

        // Cache today's attendance and permission counts
        $todayDate    = now()->toDateString();
        $todayPresent = Attendance::whereIn('room_id', $roomIds)
            ->whereDate('check_in', $todayDate)
            ->whereNotNull('check_in')
            ->count();
        $todayPermission = Permission::whereIn('user_id', $studentIds)
            ->where('status', 'approved')
            ->whereDate('date', $todayDate)
            ->count();

        // Calculate today's stats: Sudah Hadir (present), Izin (permission), Alpa (absent)
        $totalStudents = $studentIds->count();
        $todayStats    = [
            'present'    => $todayPresent,
            'permission' => $todayPermission,
            'absent'     => max(0, $totalStudents - ($todayPresent + $todayPermission)),
        ];

        // Calculate weekly attendance data (Sudah Hadir, Izin, Alpa)
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date    = now()->subDays($i)->toDateString();
            $present = Attendance::whereIn('room_id', $roomIds)
                ->whereDate('check_in', $date)
                ->whereNotNull('check_in')
                ->count();
            $permission = Permission::whereIn('user_id', $studentIds)
                ->where('status', 'approved')
                ->whereDate('date', $date)
                ->count();
            $absent       = max(0, $totalStudents - ($present + $permission));
            $weeklyData[] = [
                'day'        => now()->subDays($i)->locale('id')->format('l'),
                'present'    => $present,
                'permission' => $permission,
                'absent'     => $absent,
            ];
        }

        // Count pending permissions
        $pendingPermissions = Permission::whereNull('status')->count();

        // Get active announcements created by this teacher
        $announcements = Announcement::active()->where('created_by', auth()->id())->latest()->get();

        return view('guru.dashboard', compact('rooms', 'pendingPermissions', 'todayStats', 'weeklyData', 'announcements'));
    }

    public function report(Request $request)
    {
        $rooms   = Room::where('guru_id', auth()->id())->get();
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

    public function manualAttendance(Request $request)
    {
        $teacherId = auth()->id();
        $rooms     = Room::where('guru_id', $teacherId)->get();

        $selectedRoomId = $request->room_id ?? ($rooms->first()->id ?? null);
        $date           = $request->date ?? now()->toDateString();

        $students            = collect();
        $existingAttendances = collect();
        $permissions         = collect();

        if ($selectedRoomId) {
            $students = User::whereHas('attendances', function ($q) use ($selectedRoomId) {
                $q->where('room_id', $selectedRoomId);
            })->paginate(10);

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

    public function submitManualAttendance(Request $request)
    {
        $request->validate([
            'room_id'       => 'required|exists:rooms,id',
            'date'          => 'required|date',
            'attendances'   => 'required|array',
            'attendances.*' => 'in:present,permission,absent',
        ]);

        $teacherId = auth()->id();
        $room      = Room::findOrFail($request->room_id);

        // Verify the teacher owns this room
        if ($room->guru_id != $teacherId) {
            return back()->with('error', 'Unauthorized action.');
        }

        $date = $request->date;

        // Map room_id to location_id (based on seeder)
        $locationId = $room->id === 1 ? 1 : 2; // Ruang 10A -> Kelas A, Ruang 10B -> Kelas B

        foreach ($request->attendances as $userId => $status) {
            // Check if user has an attendance record for this room
            if (! Attendance::where('room_id', $room->id)->where('user_id', $userId)->exists()) {
                continue;
            }

            if ($status === 'present') {
                Attendance::updateOrCreate(
                    [
                        'user_id'  => $userId,
                        'room_id'  => $room->id,
                        'check_in' => $date,
                    ],
                    [
                        'location_id' => $locationId,
                        'status'      => 'manual',
                        'check_in'    => $date . ' 08:00:00',
                        'check_out'   => $date . ' 16:00:00',
                    ]
                );
                Permission::where('user_id', $userId)
                    ->whereDate('date', $date)
                    ->delete();
            } elseif ($status === 'permission') {
                Permission::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'date'    => $date,
                    ],
                    [
                        'name'         => 'Manual Permission',
                        'description'  => 'Entered by teacher',
                        'proof_image'  => 'no_image.jpg',
                        'status'       => 'approved',
                        'validated_by' => $teacherId,
                        'validated_at' => now(),
                    ]
                );
                Attendance::where('user_id', $userId)
                    ->where('room_id', $room->id)
                    ->whereDate('check_in', $date)
                    ->delete();
            } elseif ($status === 'absent') {
                Attendance::where('user_id', $userId)
                    ->where('room_id', $room->id)
                    ->whereDate('check_in', $date)
                    ->delete();
                Permission::where('user_id', $userId)
                    ->whereDate('date', $date)
                    ->delete();
            }
        }

        return back()->with('success', 'Attendance records updated successfully.');
    }

    public function getStudentsByRoom($roomId)
    {
        // Query students who have attended the specified room
        $students = User::whereHas('attendances', function ($q) use ($roomId) {
            $q->where('room_id', $roomId);
        })->get();

        return response()->json($students);
    }

    // Announcement Methods
    public function announcements()
    {
        $announcements = Announcement::with(['creator', 'room'])
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        // Calculate active and expired counts
        $activeCount = Announcement::where('created_by', Auth::id())
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->count();

        $expiredCount = Announcement::where('created_by', Auth::id())
            ->where('expires_at', '<', now())
            ->count();

        return view('guru.announcements.index', compact('announcements', 'activeCount', 'expiredCount'));
    }

    public function createAnnouncement()
    {
        $rooms = Room::all();
        return view('guru.announcements.create', compact('rooms'));
    }

    public function storeAnnouncement(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'urgency' => 'required|in:low,medium,high',
                'expires_at' => 'nullable|date|after_or_equal:today',
                'room_id' => 'nullable|exists:rooms,id',
            ], [
                'title.required' => 'Judul pengumuman harus diisi.',
                'description.required' => 'Isi pengumuman harus diisi.',
                'urgency.required' => 'Tingkat urgensi harus dipilih.',
                'expires_at.after_or_equal' => 'Tanggal kadaluarsa tidak boleh sebelum hari ini.',
                'room_id.exists' => 'Ruangan yang dipilih tidak valid.',
            ]);

            Announcement::create([
                'title' => $request->title,
                'description' => $request->description,
                'urgency' => $request->urgency,
                'expires_at' => $request->expires_at,
                'room_id' => $request->room_id,
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('guru.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Failed to create announcement:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pengumuman.');
        }
    }

    public function editAnnouncement(Announcement $announcement)
    {
        if ($announcement->created_by != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $rooms = Room::all();
        return view('guru.announcements.edit', compact('announcement', 'rooms'));
    }

    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        try {
            if ($announcement->created_by != Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'urgency' => 'required|in:low,medium,high',
                'expires_at' => 'nullable|date|after_or_equal:today',
                'room_id' => 'nullable|exists:rooms,id',
            ], [
                'title.required' => 'Judul pengumuman harus diisi.',
                'description.required' => 'Isi pengumuman harus diisi.',
                'urgency.required' => 'Tingkat urgensi harus dipilih.',
                'expires_at.after_or_equal' => 'Tanggal kadaluarsa tidak boleh sebelum hari ini.',
                'room_id.exists' => 'Ruangan yang dipilih tidak valid.',
            ]);

            $announcement->update([
                'title' => $request->title,
                'description' => $request->description,
                'urgency' => $request->urgency,
                'expires_at' => $request->expires_at,
                'room_id' => $request->room_id,
            ]);

            return redirect()->route('guru.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Failed to update announcement:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengumuman.');
        }
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        if ($announcement->created_by != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $announcement->delete();
        return redirect()->route('guru.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
