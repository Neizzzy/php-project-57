<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testTaskStatusIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));

        $response->assertStatus(200);
    }

    public function testUserCanCreateTaskStatus(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.create'));

        $response->assertStatus(200);
    }

    public function testGuestCannotCreateTaskStatus(): void
    {
        $response = $this->actingAsGuest()
            ->get(route('task_statuses.create'));

        $response->assertStatus(403);
    }

    public function testUserCanStoreTaskStatus(): void
    {
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->actingAs($this->user)
            ->post(route('task_statuses.store'), $data);

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testGuestCannotStoreTaskStatus(): void
    {
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->actingAsGuest()
            ->post(route('task_statuses.store'), $data);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('task_statuses');
    }

    public function testTaskStatusValidation(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('task_statuses.store'), ['name' => '']);

        $response->assertRedirect();

        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseEmpty('task_statuses');
    }

    public function testUserCanEditTaskStatus(): void
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $taskStatus));

        $response->assertStatus(200);
    }

    public function testGuestCannotEditTaskStatus(): void
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->actingAsGuest()
            ->get(route('task_statuses.edit', $taskStatus));

        $response->assertStatus(403);
    }

    public function testUserCanUpdateTaskStatus(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $taskStatus), $data);

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->id, ...$data]);
    }

    public function testGuestCannotUpdateTaskStatus(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $originalData = $taskStatus->only('name');
        $data = TaskStatus::factory()->make()->only('name');

        $response = $this->actingAsGuest()
            ->patch(route('task_statuses.update', $taskStatus), $data);

        $response->assertStatus(403);

        $this->assertDatabaseHas('task_statuses', $originalData);
    }

    public function testUserCanDeleteStatusWithoutTasks(): void
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    }

    public function testUserCannotDeleteStatusWithTasks()
    {
        $taskStatus = TaskStatus::factory()->create();
        Task::factory()->create(['status_id' => $taskStatus->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->id]);
    }

    public function testGuestCannotDeleteTaskStatus(): void
    {
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->actingAsGuest()
            ->delete(route('task_statuses.destroy', $taskStatus));

        $response->assertStatus(403);

        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->id]);
    }
}
