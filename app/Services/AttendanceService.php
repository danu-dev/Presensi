<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function checkIn(int $userId, array $data, $distanceCalculator): array
    {
        $openTimeStr = config('attendance.open_time', '05:00');
        [$openHour, $openMinute] = explode(':', $openTimeStr);
        $startTime = now()->setHour((int) $openHour)->setMinute((int) $openMinute)->setSecond(0);

        if (now()->lt($startTime)) {
            return ['success' => false, 'status' => 422, 'error' => "Absensi belum dibuka. Mulai jam {$openTimeStr}."];
        }

        $today = now()->startOfDay()->toDateString();
        $todayAttendance = Attendance::where('user_id', $userId)->whereDate('check_in', $today)->first();

        if ($todayAttendance) {
            return ['success' => false, 'status' => 422, 'error' => 'Anda sudah check-in hari ini!'];
        }

        $location = \App\Models\Location::findOrFail($data['location_id']);
        $distance = $distanceCalculator->calculate(
            (float) $data['latitude'],
            (float) $data['longitude'],
            (float) $location->latitude,
            (float) $location->longitude
        );

        if ($distance > $location->radius) {
            return ['success' => false, 'status' => 422, 'error' => 'Anda di luar radius lokasi!'];
        }

        Attendance::create([
            'user_id'     => $userId,
            'location_id' => $data['location_id'],
            'room_id'     => $data['room_id'],
            'check_in'    => now(),
            'status'      => 'Sudah Absen',
        ]);

        return ['success' => true, 'status' => 200, 'message' => 'Check-in berhasil.'];
    }

    public function checkOut(int $userId): array
    {
        $today = now()->startOfDay()->toDateString();
        $todayAttendance = Attendance::where('user_id', $userId)->whereDate('check_in', $today)->first();

        if (!$todayAttendance) {
            return ['success' => false, 'status' => 422, 'error' => 'Anda belum check-in hari ini!'];
        }

        if ($todayAttendance->check_out) {
            return ['success' => false, 'status' => 422, 'error' => 'Anda sudah check-out hari ini!'];
        }

        $todayAttendance->update([
            'check_out' => now(),
            'status'    => 'Sudah Absen Keluar',
        ]);

        return ['success' => true, 'status' => 200, 'message' => 'Check-out berhasil.'];
    }

    public function recordManualAttendance(int $roomId, string $date, int $teacherId, array $attendances): void
    {
        // Use first location associated with room or fallback to first available location in database
        $room = \App\Models\Room::findOrFail($roomId);
        $locationId = Attendance::where('room_id', $roomId)->value('location_id')
            ?? \App\Models\Location::value('id')
            ?? 1;

        $checkInTime  = config('attendance.manual_check_in_time', '08:00:00');
        $checkOutTime = config('attendance.manual_check_out_time', '16:00:00');

        DB::transaction(function () use ($roomId, $date, $teacherId, $attendances, $locationId, $checkInTime, $checkOutTime) {
            $submittedUserIds = array_keys($attendances);

            $validUserIds = Attendance::where('room_id', $roomId)
                ->whereIn('user_id', $submittedUserIds)
                ->distinct()
                ->pluck('user_id')
                ->flip();

            foreach ($attendances as $userId => $status) {
                if (!isset($validUserIds[$userId])) {
                    continue;
                }

                if ($status === 'present') {
                    Attendance::updateOrCreate(
                        [
                            'user_id'  => $userId,
                            'room_id'  => $roomId,
                            'check_in' => $date,
                        ],
                        [
                            'location_id' => $locationId,
                            'status'      => 'manual',
                            'check_in'    => $date . ' ' . $checkInTime,
                            'check_out'   => $date . ' ' . $checkOutTime,
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
                        ->where('room_id', $roomId)
                        ->whereDate('check_in', $date)
                        ->delete();
                } elseif ($status === 'absent') {
                    Attendance::where('user_id', $userId)
                        ->where('room_id', $roomId)
                        ->whereDate('check_in', $date)
                        ->delete();
                    Permission::where('user_id', $userId)
                        ->whereDate('date', $date)
                        ->delete();
                }
            }
        });
    }
}
