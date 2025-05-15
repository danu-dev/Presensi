<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HomeContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $homeContents = HomeContent::all();
        return view('admin.home.index', compact('homeContents'));
    }

    public function create()
    {
        return view('admin.home.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('home', 'public');
        }

        HomeContent::create($data);

        return redirect()->route('admin.home.index')->with('success', 'Konten Home berhasil ditambahkan.');
    }

    public function edit(HomeContent $homeContent)
    {
        return view('admin.home.edit', compact('homeContent'));
    }

    public function update(Request $request, HomeContent $homeContent)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($homeContent->image_path) {
                Storage::disk('public')->delete($homeContent->image_path);
            }
            $data['image_path'] = $request->file('image')->store('home', 'public');
        }

        $homeContent->update($data);

        return redirect()->route('admin.home.index')->with('success', 'Konten Home berhasil diperbarui.');
    }

    public function destroy(HomeContent $homeContent)
    {
        // Hapus gambar dari storage jika ada
        if ($homeContent->image_path) {
            Storage::disk('public')->delete($homeContent->image_path);
        }

        $homeContent->delete();

        return redirect()->route('admin.home.index')->with('success', 'Konten Home berhasil dihapus.');
    }
}
