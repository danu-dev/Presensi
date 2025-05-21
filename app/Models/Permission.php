<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts =['date'=>'datetime'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
