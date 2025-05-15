<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Location;
use App\Models\Attendance;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $attendances = $user->attendances()
            ->with(['location', 'room'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'present' => $user->attendances()
                ->whereMonth('check_in', now()->month)
                ->whereNotNull('check_out')
                ->count(),
            'permission' => $user->permissions()
                ->whereMonth('date', now()->month)
                ->count(),
        ];

        $attendanceRecords = $user->attendances()
            ->whereBetween('check_in', [now()->startOfWeek(), now()->endOfWeek()])
            ->pluck('status', 'check_in')
            ->mapWithKeys(function ($status, $date) {
                return [date('Y-m-d', strtotime($date)) => $status];
            })->toArray();

        return view('user.dashboard', compact('attendances', 'stats', 'attendanceRecords'));
    }

    public function attendanceForm()
    {
        $locations = Location::all();
        $rooms = Room::all();
        $todayAttendance = auth()->user()->attendances()
            ->whereDate('check_in', now()->startOfDay())
            ->first();
        return view('user.attendance', compact('locations', 'rooms', 'todayAttendance'));
    }

    public function submitAttendance(Request $request)
    {
        try {
            Log::info('Attendance submission attempt', $request->all());

            $request->validate([
                'location_id' => 'required|exists:locations,id',
                'room_id' => 'required|exists:rooms,id',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'type' => 'required|in:check_in,check_out',
            ]);

            $user = auth()->user();
            $today = now()->startOfDay();
            $currentTime = now();
            $startTime = now()->setHour(5)->setMinute(0)->setSecond(0);

            if ($currentTime->lt($startTime)) {
                return $this->errorResponse('Absensi belum dibuka. Mulai jam 05:00.', 422);
            }

            $todayAttendance = Attendance::where('user_id', $user->id)
                ->whereDate('check_in', $today)
                ->first();

            if ($request->type === 'check_in') {
                if ($todayAttendance) {
                    return $this->errorResponse('Anda sudah check-in hari ini!', 422);
                }

                $location = Location::find($request->location_id);
                $distance = $this->haversineDistance(
                    $request->latitude,
                    $request->longitude,
                    $location->latitude,
                    $location->longitude
                );

                Log::info('Distance check', ['distance' => $distance, 'radius' => $location->radius]);

                if ($distance > $location->radius) {
                    return $this->errorResponse('Anda di luar radius lokasi!', 422);
                }

                Attendance::create([
                    'user_id' => $user->id,
                    'location_id' => $request->location_id,
                    'room_id' => $request->room_id,
                    'check_in' => now(),
                    'status' => 'Sudah Absen',
                ]);

                return $this->successResponse('Check-in berhasil.');
            }

            if ($request->type === 'check_out') {
                if (!$todayAttendance) {
                    return $this->errorResponse('Anda belum check-in hari ini!', 422);
                }

                if ($todayAttendance->check_out) {
                    return $this->errorResponse('Anda sudah check-out hari ini!', 422);
                }

                $todayAttendance->update([
                    'check_out' => now(),
                    'status' => 'Sudah Absen Keluar',
                ]);

                return $this->successResponse('Check-out berhasil.');
            }
        } catch (\Exception $e) {
            Log::error('Attendance submission failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $this->errorResponse('Terjadi kesalahan server: ' . $e->getMessage(), 500);
        }
    }

    public function history()
    {
        $attendances = auth()->user()->attendances()->latest()->paginate(10);
        return view('user.history', compact('attendances'));
    }

    public function permissionForm()
    {
        // Fetch the last permission for the authenticated user
        $lastPermission = Permission::where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('user.permission', compact('lastPermission'));
    }

    public function submitPermission(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'date' => 'required|date|after_or_equal:today',
                'proof_image' => 'required|image|max:2048',
            ], [
                'name.required' => 'Nama izin harus diisi.',
                'description.required' => 'Deskripsi harus diisi.',
                'date.required' => 'Tanggal harus diisi.',
                'date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
                'proof_image.required' => 'Bukti gambar harus diunggah.',
                'proof_image.image' => 'File harus berupa gambar.',
                'proof_image.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            $path = $request->file('proof_image')->store('permissions', 'public');

            Permission::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'description' => $request->description,
                'date' => $request->date,
                'proof_image' => $path,
            ]);

            return redirect()->route('user.permission')->with('success', 'Pengajuan izin berhasil.');
        } catch (\Exception $e) {
            Log::error('Permission submission failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('user.permission')->with('error', 'Terjadi kesalahan saat mengajukan izin.');
        }
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    private function successResponse($message)
    {
        return response()->json(['success' => true, 'message' => $message]);
    }

    private function errorResponse($message, $status = 422)
    {
        return response()->json(['success' => false, 'error' => $message], $status);
    }
}