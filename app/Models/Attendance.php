<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'location_id', 'room_id', 'status', 'check_in', 'check_out'];
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function scopeDate($query, $date)
    {
        return $query->whereDate('check_in', $date);
    }

    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('check_in', [$from, $to]);
    }

    public function scopePresent($query)
    {
        return $query->whereNotNull('check_in');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
