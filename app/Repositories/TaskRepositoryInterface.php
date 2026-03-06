<?php

namespace App\Repositories;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function save(array $request): Task;
    public function update(int $id, array $request): Task;
    public function findById(int $id): Task;
    public function delete(Task $task): void;
}
