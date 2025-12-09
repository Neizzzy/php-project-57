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

    public function testLabelIndex()
    {
        $response = $this->get(route('labels.index'));

        $response->assertStatus(200);
    }

    public function testUserCanCreateLabel()
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));

        $response->assertStatus(200);
    }

    public function testGuestCannotCreateLabel()
    {
        $response = $this->actingAsGuest()
            ->get(route('labels.create'));

        $response->assertStatus(403);
    }

    public function testUserCanStoreLabel()
    {
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $data);

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $data);
    }

    public function testGuestCannotStoreLabel()
    {
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAsGuest()
            ->post(route('labels.store'), $data);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('labels');
    }

    public function testLabelValidation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => '']);

        $response->assertSessionHasErrors(['name']);

        $response->assertRedirect();

        $this->assertDatabaseEmpty('labels');
    }

    public function testUserCanEditLabel()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', $label));

        $response->assertStatus(200);
    }

    public function testGuestCannotEditLabel()
    {
        $label = Label::factory()->create();

        $response = $this->actingAsGuest()
            ->get(route('labels.edit', $label));

        $response->assertStatus(403);
    }

    public function testUserCanUpdateLabel()
    {
        $label = Label::factory()->create();
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $label), $data);

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', ['id' => $label->id, ...$data]);
    }

    public function testGuestCannotUpdateLabel()
    {
        $label = Label::factory()->create();
        $originalName = $label->name;
        $data = Label::factory()->make()->toArray();

        $response = $this->actingAsGuest()
            ->patch(route('labels.update', $label), $data);

        $response->assertStatus(403);

        $this->assertDatabaseHas('labels', ['id' => $label->id, 'name' => $originalName]);
    }

    public function testUserCanDeleteLabelWithoutTasks()
    {
        $label = Label::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testUserCannotDeleteLabelWithTasks()
    {
        $label = Label::factory()->create();
        $task = Task::factory()->create();
        $task->labels()->attach([$label->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testGuestCannotDeleteLabel()
    {
        $label = Label::factory()->create();

        $response = $this->actingAsGuest()
            ->delete(route('labels.destroy', $label));

        $response->assertStatus(403);

        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
