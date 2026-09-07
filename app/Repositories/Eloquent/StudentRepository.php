<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAll(): Collection
    {
        return Student::all();
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data): bool
    {
        return $student->update($data);
    }

    public function delete(Student $student): bool
    {
        return (bool) $student->delete();
    }
}
