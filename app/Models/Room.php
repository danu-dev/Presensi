<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'guru_id'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'room_user');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    
}
