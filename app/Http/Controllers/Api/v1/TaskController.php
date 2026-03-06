<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Resources\TaskResource;
use App\Services\CreateTask;
use App\Services\DeleteTask;
use App\Services\GetTasks;
use App\Services\UpdateTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

readonly class TaskController
{
    private const PER_PAGE = 10;
    public function __construct(
        private CreateTask $createTaskService,
        private UpdateTask $updateTaskService,
        private DeleteTask $deleteTask,
        private GetTasks $getTasks,
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $tasks = $this->getTasks->execute($page, self::PER_PAGE);
        return TaskResource::collection($tasks)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function store(CreateTaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $task = $this->createTaskService->execute($data);
        $url = route("api.v1.tasks.show", $task);
        return (new TaskResource($task))
            ->response()
            ->header("Location", $url)
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Task $task): JsonResponse
    {
        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function update(int $id, UpdateTaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $task = $this->updateTaskService->execute($id, $data);

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function destroy(Task $task): JsonResponse {
        $this->deleteTask->execute($task);
        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
