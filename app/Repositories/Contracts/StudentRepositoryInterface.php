<?php

namespace App\Repositories\Contracts;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

interface StudentRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): Student;
    public function update(Student $student, array $data): bool;
    public function delete(Student $student): bool;
}
