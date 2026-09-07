<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepo
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $projects = $this->projectRepo->getAll();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $this->projectRepo->create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Projek berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $this->projectRepo->update($project, $validated);

        return redirect()->route('admin.projects.index')->with('success', 'Projek berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        $this->projectRepo->delete($project);

        return redirect()->route('admin.projects.index')->with('success', 'Projek berhasil dihapus!');
    }
}
