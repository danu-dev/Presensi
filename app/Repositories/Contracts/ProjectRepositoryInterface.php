<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAll(): Collection;
    public function create(array $data): Project;
    public function update(Project $project, array $data): bool;
    public function delete(Project $project): bool;
}
