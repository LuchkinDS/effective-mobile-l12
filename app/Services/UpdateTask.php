<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Throwable;

readonly class UpdateTask
{
    public function __construct(
        private TaskRepositoryInterface $repository,
        private DatabaseManager         $db
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(int $id, array $request): Task
    {
        return $this->db->transaction(function () use ($id, $request) {
            return $this->repository->update($id, $request);
        });
    }
}
