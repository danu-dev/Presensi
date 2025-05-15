<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $roomId;
    protected $roomIds;

    public function __construct($startDate, $endDate, $roomId, $roomIds)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->roomId = $roomId;
        $this->roomIds = $roomIds;
    }

    public function collection()
    {
        $query = Attendance::with(['user', 'location', 'room'])
            ->whereIn('room_id', $this->roomIds);

        if ($this->startDate) {
            $query->whereDate('check_in', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('check_in', '<=', $this->endDate);
        }
        if ($this->roomId) {
            $query->where('room_id', $this->roomId);
        }

        return $query->orderBy('check_in', 'desc')->get()->map(function ($attendance) {
            return [
                'Nama Siswa' => $attendance->user->name,
                'Lokasi' => $attendance->location->name,
                'Ruangan' => $attendance->room->name,
                'Check-In' => $attendance->check_in->toDateTimeString(),
                'Check-Out' => $attendance->check_out ? $attendance->check_out->toDateTimeString() : '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Siswa', 'Lokasi', 'Ruangan', 'Check-In', 'Check-Out'];
    }
}
