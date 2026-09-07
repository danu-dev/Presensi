<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\GalleryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function __construct(
        protected GalleryRepositoryInterface $galleryRepo
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $galleries = $this->galleryRepo->getAll();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(StoreGalleryRequest $request)
    {
        $validated = $request->validated();
        $validated['image_path'] = $request->file('image')->store('gallery', 'public');

        $this->galleryRepo->create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil ditambahkan!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $this->galleryRepo->update($gallery, $validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $this->galleryRepo->delete($gallery);

        return redirect()->route('admin.gallery.index')->with('success', 'Galeri berhasil dihapus!');
    }
}
