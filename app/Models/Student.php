<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'image_path', 'role', 'github_url', 'linkedin_url', 'instagram_url'];
}
