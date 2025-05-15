<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Location;
use App\Models\Attendance;
use App\Models\Permission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data untuk statistik kartu
        $users = User::count();
        $locations = Location::count();
        $rooms = Room::count();
        $attendancesToday = Attendance::whereDate('check_in', now()->startOfDay())->count();
        $pendingPermissions = Permission::whereNull('status')->count();

        // Data untuk grafik absensi mingguan
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklyAttendance = Attendance::selectRaw('DATE(check_in) as date, COUNT(*) as total')
            ->whereBetween('check_in', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->all();

        // Format data untuk grafik
        $labels = [];
        $data = [];
        $currentDate = $startOfWeek->copy();

        while ($currentDate <= $endOfWeek) {
            $dateString = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('D'); // Hari dalam format singkat (Sen, Sel, dll)
            $data[] = $weeklyAttendance[$dateString] ?? 0; // Jika tidak ada data, isi 0
            $currentDate->addDay();
        }

        // Kirim semua variabel ke view
        return view('admin.dashboard', compact(
            'users',
            'locations',
            'rooms',
            'attendancesToday',
            'pendingPermissions',
            'labels',
            'data'
        ));
    }

    // Users CRUD (Resource)
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:user,guru,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,guru,admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User dihapus.');
    }

    // Locations CRUD (Manual)
    public function indexLocations()
    {
        $locations = Location::paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    public function createLocations()
    {
        return view('admin.locations.create');
    }

    public function storeLocations(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer',
        ]);

        Location::create($request->all());
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi ditambahkan.');
    }

    public function editLocations($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.locations.edit', compact('location'));
    }

    public function updateLocations(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer',
        ]);

        $location->update($request->all());
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi diperbarui.');
    }

    public function destroyLocations($id)
    {
        Location::findOrFail($id)->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi dihapus.');
    }

    // Rooms CRUD (Manual)
    public function indexRooms()
    {
        $rooms = Room::with('guru')->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function createRooms()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.rooms.create', compact('gurus'));
    }

    public function storeRooms(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'guru_id' => 'required|exists:users,id',
        ]);

        Room::create($request->all());
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan ditambahkan.');
    }

    public function editRooms($id)
    {
        $room = Room::findOrFail($id);
        $gurus = User::where('role', 'guru')->get();
        return view('admin.rooms.edit', compact('room', 'gurus'));
    }

    public function updateRooms(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'guru_id' => 'required|exists:users,id',
        ]);

        $room->update($request->all());
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan diperbarui.');
    }

    public function destroyRooms($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan dihapus.');
    }
}