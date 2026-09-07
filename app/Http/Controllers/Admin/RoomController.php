<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepo,
        protected UserRepositoryInterface $userRepo
    ) {}

    public function index()
    {
        $rooms = $this->roomRepo->paginateWithGuru(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $gurus = $this->userRepo->getByRole('guru');
        return view('admin.rooms.create', compact('gurus'));
    }

    public function store(StoreRoomRequest $request)
    {
        $this->roomRepo->create($request->validated());
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan ditambahkan.');
    }

    public function edit(Room $room)
    {
        $gurus = $this->userRepo->getByRole('guru');
        return view('admin.rooms.edit', compact('room', 'gurus'));
    }

    public function update(StoreRoomRequest $request, Room $room)
    {
        $this->roomRepo->update($room, $request->validated());
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan diperbarui.');
    }

    public function destroy(Room $room)
    {
        $this->roomRepo->delete($room);
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan dihapus.');
    }
}
