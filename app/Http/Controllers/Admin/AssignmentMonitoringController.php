<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentMonitoringController extends Controller
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepo
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request): View
    {
        $rooms = $this->roomRepo->getAll();
        $query = Assignment::with(['room', 'creator', 'submissions']);

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        $assignments = $query->latest()->paginate(15);

        $stats = [
            'total_assignments' => Assignment::count(),
            'total_submissions' => AssignmentSubmission::count(),
            'graded_submissions'=> AssignmentSubmission::whereNotNull('score')->count(),
        ];

        return view('admin.assignments.index', compact('assignments', 'rooms', 'stats'));
    }
}
