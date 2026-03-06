<?php

namespace App\Services;

use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\DatabaseManager;

readonly class DeleteTask
{
    public function __construct(
        private TaskRepositoryInterface $repository,
        private DatabaseManager         $db
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function execute(Task $task): void
    {
        $this->db->transaction(function () use ($task) {
            $this->repository->delete($task);
        });
    }
}
