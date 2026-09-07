<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\GradeSubmissionRequest;
use App\Http\Requests\Guru\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepo
    ) {
        $this->middleware(['auth', 'role:guru']);
    }

    public function index(): View
    {
        $roomIds = $this->roomRepo->getByGuruId(auth()->id())->pluck('id');
        $assignments = Assignment::with(['room', 'submissions'])
            ->whereIn('room_id', $roomIds)
            ->latest()
            ->paginate(10);

        return view('guru.assignments.index', compact('assignments'));
    }

    public function create(): View
    {
        $rooms = $this->roomRepo->getByGuruId(auth()->id());
        return view('guru.assignments.create', compact('rooms'));
    }

    public function store(StoreAssignmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $room = $this->roomRepo->findOrFail($validated['room_id']);

        if ($room->guru_id !== auth()->id()) {
            abort(403, 'Ruang kelas tidak valid.');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'room_id'     => $validated['room_id'],
            'created_by'  => auth()->id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date'    => $validated['due_date'],
            'file_path'   => $filePath,
        ]);

        return redirect()->route('guru.assignments.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Assignment $assignment): View
    {
        $this->authorizeAccess($assignment);

        $assignment->load(['room', 'submissions.user']);
        return view('guru.assignments.show', compact('assignment'));
    }

    public function grade(GradeSubmissionRequest $request, AssignmentSubmission $submission): RedirectResponse
    {
        $this->authorizeAccess($submission->assignment);

        $submission->update($request->validated());

        return back()->with('success', 'Nilai dan catatan berhasil disimpan.');
    }

    public function destroy(Assignment $assignment): RedirectResponse
    {
        $this->authorizeAccess($assignment);

        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()->route('guru.assignments.index')->with('success', 'Tugas berhasil dihapus.');
    }

    protected function authorizeAccess(Assignment $assignment): void
    {
        $roomIds = $this->roomRepo->getByGuruId(auth()->id())->pluck('id')->toArray();
        if (!in_array($assignment->room_id, $roomIds)) {
            abort(403, 'Akses tugas ditolak.');
        }
    }
}
