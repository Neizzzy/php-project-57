<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_label_index()
    {
        $response = $this->get(route('labels.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_create_label()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_create_label()
    {
        $response = $this->actingAsGuest()
            ->get(route('labels.create'));

        $response->assertStatus(403);
    }

    public function test_user_can_store_label()
    {
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $data);
    }

    public function test_guest_cannot_store_label()
    {
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAsGuest()
            ->post(route('labels.store'), $data);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('labels');
    }

    public function test_label_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => '']);

        $response->assertSessionHasErrors(['name']);

        $response->assertRedirect();

        $this->assertDatabaseEmpty('labels');
    }

    public function test_user_can_edit_label()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', $label));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_edit_label()
    {
        $label = Label::factory()->create();

        $response = $this->actingAsGuest()
            ->get(route('labels.edit', $label));

        $response->assertStatus(403);
    }

    public function test_user_can_update_label()
    {
        $label = Label::factory()->create();
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $label), $data);

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', ['id' => $label->id, ...$data]);
    }

    public function test_guest_cannot_update_label()
    {
        $label = Label::factory()->create();
        $originalName = $label->name;
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAsGuest()
            ->patch(route('labels.update', $label), $data);

        $response->assertStatus(403);

        $this->assertDatabaseHas('labels', ['id' => $label->id, 'name' => $originalName]);
    }

    public function test_user_can_delete_label_without_tasks()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function test_user_cannot_delete_label_with_tasks()
    {
        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach([$label->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function test_guest_cannot_delete_label()
    {
        $label = Label::factory()->create();

        $response = $this->actingAsGuest()
            ->delete(route('labels.destroy', $label));

        $response->assertStatus(403);

        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
