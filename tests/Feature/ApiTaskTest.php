<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task(): void
    {
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Тестовая задача',
            'description' => 'Описание',
            'status' => 'pending',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title']]);
    }

    public function test_create_task_with_invalid_status(): void
    {
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Тест',
            'status' => 'invalid_status',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('status');
    }

    public function test_create_task_without_title(): void
    {
        $response = $this->postJson('/api/v1/tasks', [
            'status' => 'pending',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('title');
    }

    public function test_get_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_get_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $task->id]]);
    }

    public function test_update_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->postJson("/api/v1/tasks/{$task->id}", [
            'title' => 'Обновленный заголовок',
        ]);

        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => 'Обновленный заголовок']]);
    }

    public function test_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_validation_error(): void
    {
        $response = $this->postJson('/api/v1/tasks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('title');
    }
}
