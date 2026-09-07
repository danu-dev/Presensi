<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Gallery;
use App\Models\HomeContent;
use App\Models\Project;
use App\Models\Student;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'homeContents' => HomeContent::all(),
            'abouts'       => About::all(),
            'galleries'    => Gallery::all(),
            'projects'     => Project::all(),
            'students'     => Student::all(),
        ]);
    }
}
