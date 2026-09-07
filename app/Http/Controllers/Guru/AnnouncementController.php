<?php

namespace App\Http\Controllers\Guru;

use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\StoreAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function __construct(
        protected AnnouncementRepositoryInterface $announcementRepo,
        protected RoomRepositoryInterface $roomRepo
    ) {}

    public function index()
    {
        $announcements = $this->announcementRepo->paginateByCreator(Auth::id(), 10);
        $activeCount   = $this->announcementRepo->countActiveByCreator(Auth::id());
        $expiredCount  = $this->announcementRepo->countExpiredByCreator(Auth::id());

        return view('guru.announcements.index', compact('announcements', 'activeCount', 'expiredCount'));
    }

    public function create()
    {
        $rooms = $this->roomRepo->getAll();
        return view('guru.announcements.create', compact('rooms'));
    }

    public function store(StoreAnnouncementRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['created_by'] = Auth::id();

            $this->announcementRepo->create($validated);

            return redirect()->route('guru.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Failed to create announcement:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan pengumuman.');
        }
    }

    public function edit(Announcement $announcement)
    {
        if ($announcement->created_by != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $rooms = $this->roomRepo->getAll();
        return view('guru.announcements.edit', compact('announcement', 'rooms'));
    }

    public function update(StoreAnnouncementRequest $request, Announcement $announcement)
    {
        try {
            if ($announcement->created_by != Auth::id()) {
                return back()->with('error', 'Unauthorized action.');
            }

            $this->announcementRepo->update($announcement, $request->validated());

            return redirect()->route('guru.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Failed to update announcement:', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui pengumuman.');
        }
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->created_by != Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $this->announcementRepo->delete($announcement);
        return redirect()->route('guru.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
