<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetTasks
{
    public function execute(int $page, int $perPage): LengthAwarePaginator
    {
        return Task::query()->paginate(perPage: $perPage, page: $page);
    }
}
