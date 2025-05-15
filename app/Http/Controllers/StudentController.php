<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']); // Ubah ke role:admin agar hanya admin yang bisa akses
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
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|string|max:255',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('students', 'public') : null;

        Student::create([
            'name' => $request->name,
            'image_path' => $imagePath,
            'role' => $request->role,
            'github_url' => $request->github_url,
            'linkedin_url' => $request->linkedin_url,
            'instagram_url' => $request->instagram_url,
        ]);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|string|max:255',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
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
        // Hapus gambar dari storage jika ada
        if ($student->image_path) {
            Storage::disk('public')->delete($student->image_path);
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
