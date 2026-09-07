<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SubmitAssignmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    public function index(): View
    {
        $userId = Auth::id();
        $roomIds = Attendance::where('user_id', $userId)->distinct()->pluck('room_id');

        $assignments = Assignment::with(['room', 'creator', 'submissions' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
            ->whereIn('room_id', $roomIds)
            ->latest('due_date')
            ->paginate(10);

        return view('user.assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment): View
    {
        $userId = Auth::id();
        $roomIds = Attendance::where('user_id', $userId)->distinct()->pluck('room_id')->toArray();

        if (!in_array($assignment->room_id, $roomIds)) {
            abort(403, 'Anda tidak terdaftar di kelas tugas ini.');
        }

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', $userId)
            ->first();

        return view('user.assignments.show', compact('assignment', 'submission'));
    }

    public function submit(SubmitAssignmentRequest $request, Assignment $assignment): RedirectResponse
    {
        $userId = Auth::id();
        $roomIds = Attendance::where('user_id', $userId)->distinct()->pluck('room_id')->toArray();

        if (!in_array($assignment->room_id, $roomIds)) {
            abort(403, 'Akses tugas ditolak.');
        }

        if (now()->gt($assignment->due_date)) {
            return back()->with('error', 'Batas waktu pengumpulan tugas telah lewat.');
        }

        $validated = $request->validated();
        $filePath = $request->file('file')->store('submissions', 'public');

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', $userId)
            ->first();

        if ($submission) {
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }
            $submission->update([
                'notes'        => $validated['notes'] ?? null,
                'file_path'    => $filePath,
                'submitted_at' => now(),
            ]);
        } else {
            AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'user_id'       => $userId,
                'notes'         => $validated['notes'] ?? null,
                'file_path'     => $filePath,
                'submitted_at'  => now(),
            ]);
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
