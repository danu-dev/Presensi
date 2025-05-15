<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'image_path', 'description', 'team_name', 'technologies'];

    protected $casts = [
        'technologies' => 'array', // Cast kolom technologies ke array
    ];
}
