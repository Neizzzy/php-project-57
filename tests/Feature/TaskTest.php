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

    public function testTaskIndex(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
    }

    public function testTaskFilterByStatusId()
    {
        [$needleTask, $secondTask] = Task::factory()->count(2)->create();

        $response = $this->get(route('tasks.index', "filter[status_id]={$needleTask->status_id}"));

        $response->assertSee($needleTask->name);

        $response->assertDontSee($secondTask->name);
    }

    public function testTaskFilterByCreatedById()
    {
        [$needleTask, $secondTask] = Task::factory()->count(2)->create();

        $response = $this->get(route('tasks.index', "filter[created_by_id]={$needleTask->created_by_id}"));

        $response->assertSee($needleTask->name);

        $response->assertDontSee($secondTask->name);
    }

    public function testTaskFilterByAssignedToId()
    {
        [$needleTask, $secondTask] = Task::factory()->count(2)->create();

        $response = $this->get(route('tasks.index', "filter[assigned_to_id]={$needleTask->assigned_to_id}"));

        $response->assertSee($needleTask->name);

        $response->assertDontSee($secondTask->name);
    }

    public function testShowIndex(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));

        $response->assertStatus(200);
    }

    public function testUserCanCreateTask(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.create'));

        $response->assertStatus(200);
    }

    public function testGuestCannotCreateTask(): void
    {
        $response = $this->actingAsGuest()
            ->get(route('tasks.create'));

        $response->assertStatus(403);
    }

    public function testUserCanStoreTask(): void
    {
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [...$data, 'created_by_id' => $this->user->id]);
    }

    public function testGuestCannotStoreTask(): void
    {
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAsGuest()
            ->post(route('tasks.store'), $data);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('tasks');
    }

    public function testTaskValidation(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), ['name' => '', 'status_id' => '']);

        $response->assertRedirect();

        $response->assertSessionHasErrors(['name', 'status_id']);

        $this->assertDatabaseEmpty('tasks');
    }

    public function testUserCanEditTask(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('tasks.edit', $task));

        $response->assertStatus(200);
    }

    public function testGuestCannotEditTask(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAsGuest()
            ->get(route('tasks.edit', $task));

        $response->assertStatus(403);
    }

    public function testUserCanUpdateTask(): void
    {
        $task = Task::factory()->create();
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAs($this->user)
            ->patch(route('tasks.update', $task), $data);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, ...$data]);
    }

    public function testGuestCannotUpdateTask(): void
    {
        $task = Task::factory()->create();
        $originalName = $task->name;
        $data = Task::factory()->make()->only(['name', 'description', 'status_id', 'assigned_to_id']);

        $response = $this->actingAsGuest()
            ->patch(route('tasks.update', $task), $data);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => $originalName]);
    }

    public function testAuthorCanDeleteTask(): void
    {
        $task = Task::factory()->create(['created_by_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testUserCannotDeleteOtherUserTask(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function testGuestCannotDeleteTask(): void
    {
        $task = Task::factory()->create();

        $response = $this->actingAsGuest()
            ->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
