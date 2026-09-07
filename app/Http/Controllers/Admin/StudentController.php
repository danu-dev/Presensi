<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct(
        protected StudentRepositoryInterface $studentRepo
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $students = $this->studentRepo->getAll();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('students', 'public');
        }

        $this->studentRepo->create($validated);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($student->image_path) {
                Storage::disk('public')->delete($student->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('students', 'public');
        }

        $this->studentRepo->update($student, $validated);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        if ($student->image_path) {
            Storage::disk('public')->delete($student->image_path);
        }

        $this->studentRepo->delete($student);

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
