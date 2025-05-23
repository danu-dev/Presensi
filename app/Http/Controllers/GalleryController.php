<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gallery' => 'required|array|min:1',
            'gallery.*.title' => 'nullable|string|max:255',
            'gallery.*.image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*.description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->gallery as $galleryData) {
                $imagePath = $galleryData['image']->store('galleries', 'public');

                Gallery::create([
                    'title' => $galleryData['title'] ?? null,
                    'image_path' => $imagePath,
                    'description' => $galleryData['description'] ?? null,
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally log the error: \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan galeri. Silakan coba lagi.');
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diunggah!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->image_path = $request->file('image')->store('galleries', 'public');
        }

        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus!');
    }
}