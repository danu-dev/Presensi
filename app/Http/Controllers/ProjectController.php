<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'projects' => 'required|array|min:1',
            'projects.*.title' => 'required|string|max:255',
            'projects.*.image' => 'nullable',
            'projects.*.description' => 'required|string',
            'projects.*.team_name' => 'required|string|max:255',
            'projects.*.technologies' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->projects as $projectData) {
                $imagePath = null;
                if (isset($projectData['image']) && $projectData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $projectData['image']->store('projects', 'public');
                }

                Project::create([
                    'title' => $projectData['title'],
                    'image_path' => $imagePath,
                    'description' => $projectData['description'],
                    'team_name' => $projectData['team_name'],
                    'technologies' => $projectData['technologies'],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally log the error: \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan proyek. Silakan coba lagi.');
        }

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable',
            'description' => 'required|string',
            'team_name' => 'required|string|max:255',
            'technologies' => 'required|string|max:255',
        ]);

        $data = $request->only(['title', 'description', 'team_name', 'technologies']);

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus!');
    }
}