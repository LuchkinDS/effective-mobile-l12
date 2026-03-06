<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function save(array $request): Task
    {
        return Task::create($request);
    }

    public function findById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function update(int $id, array $request): Task
    {
        $task = $this->findById($id);
        $task->update($request);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
