<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'students' => 'required|array|min:1',
            'students.*.name' => 'required|string|max:255',
            'students.*.image' => 'nullable|image|mimes:jpeg,png,jpg',
            'students.*.role' => 'required|string|max:255',
            'students.*.github_url' => 'nullable|url',
            'students.*.linkedin_url' => 'nullable|url',
            'students.*.instagram_url' => 'nullable|url',
        ]);

        foreach ($request->students as $studentData) {
            $imagePath = null;
            if (isset($studentData['image']) && $studentData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $studentData['image']->store('students', 'public');
            }

            Student::create([
                'name' => $studentData['name'],
                'image_path' => $imagePath,
                'role' => $studentData['role'],
                'github_url' => $studentData['github_url'] ?? null,
                'linkedin_url' => $studentData['linkedin_url'] ?? null,
                'instagram_url' => $studentData['instagram_url'] ?? null,
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'role' => 'required|string|max:255',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($student->image_path) {
                Storage::disk('public')->delete($student->image_path);
            }
            $data['image_path'] = $request->file('image')->store('students', 'public');
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        if ($student->image_path) {
            Storage::disk('public')->delete($student->image_path);
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus!');
    }
}