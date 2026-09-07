<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\AboutRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAboutRequest;
use App\Models\About;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct(
        protected AboutRepositoryInterface $aboutRepo
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $abouts = $this->aboutRepo->getAll();
        return view('admin.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(StoreAboutRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('about', 'public');
        }

        $this->aboutRepo->create($validated);

        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil ditambahkan.');
    }

    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(StoreAboutRequest $request, About $about)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($about->image_path) {
                Storage::disk('public')->delete($about->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('about', 'public');
        }

        $this->aboutRepo->update($about, $validated);

        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil diperbarui.');
    }

    public function destroy(About $about)
    {
        if ($about->image_path) {
            Storage::disk('public')->delete($about->image_path);
        }

        $this->aboutRepo->delete($about);

        return redirect()->route('admin.about.index')->with('success', 'Konten About berhasil dihapus.');
    }
}
