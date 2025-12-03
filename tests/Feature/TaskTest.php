<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_task_index(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
    }

    public function test_show_index(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));

        $response->assertStatus(200);
    }

    public function test_user_can_create_task(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_create_task(): void
    {
        $response = $this->actingAsGuest()
            ->get(route('tasks.create'));

        $response->assertStatus(403);
    }

    public function test_user_can_store_task(): void
    {
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [...$data, 'created_by_id' => $this->user->id]);
    }

    public function test_guest_cannot_store_task(): void
    {
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAsGuest()
            ->post(route('tasks.store'), $data);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('tasks');
    }

    public function test_task_validation(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), ['name' => '', 'status_id' => '']);

        $response->assertRedirect();

        $response->assertSessionHasErrors(['name', 'status_id']);

        $this->assertDatabaseEmpty('tasks');
    }

    public function test_user_can_edit_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', $task));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_edit_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAsGuest()
            ->get(route('tasks.edit', $task));

        $response->assertStatus(403);
    }

    public function test_user_can_update_task(): void
    {
        $task = Task::factory()->create();
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, ...$data]);
    }

    public function test_guest_cannot_update_task(): void
    {
        $task = Task::factory()->create();
        $originalName = $task->name;
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAsGuest()
            ->patch(route('tasks.update', $task), $data);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => $originalName]);
    }

    public function test_author_can_delete_task(): void
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_delete_other_user_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function test_guest_cannot_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAsGuest()
            ->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
