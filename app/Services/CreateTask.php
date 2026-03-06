<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Database\DatabaseManager;

readonly class CreateTask
{
    public function __construct(
        private TaskRepositoryInterface $repository,
        private DatabaseManager $db
    ) {

    }

    /**
     * @throws \Throwable
     */
    public function execute(array $data): Task
    {
        return $this->db->transaction(function () use ($data) {
            return $this->repository->save($data);
        });
    }

}
