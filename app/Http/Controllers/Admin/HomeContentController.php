<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\HomeContentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHomeContentRequest;
use App\Models\HomeContent;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    public function __construct(
        protected HomeContentRepositoryInterface $homeContentRepo
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $homeContents = $this->homeContentRepo->getAll();
        return view('admin.home.index', compact('homeContents'));
    }

    public function create()
    {
        return view('admin.home.create');
    }

    public function store(StoreHomeContentRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('home', 'public');
        }

        $this->homeContentRepo->create($validated);

        return redirect()->route('admin.home.index')->with('success', 'Konten Home berhasil ditambahkan.');
    }

    public function edit(HomeContent $home)
    {
        $homeContent = $home;
        return view('admin.home.edit', compact('homeContent'));
    }

    public function update(StoreHomeContentRequest $request, HomeContent $home)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($home->image_path) {
                Storage::disk('public')->delete($home->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('home', 'public');
        }

        $this->homeContentRepo->update($home, $validated);

        return redirect()->route('admin.home.index')->with('success', 'Konten Home berhasil diperbarui.');
    }

    public function destroy(HomeContent $home)
    {
        if ($home->image_path) {
            Storage::disk('public')->delete($home->image_path);
        }

        $this->homeContentRepo->delete($home);

        return redirect()->route('admin.home.index')->with('success', 'Konten Home berhasil dihapus.');
    }
}
