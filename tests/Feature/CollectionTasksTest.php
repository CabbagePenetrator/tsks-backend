<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_can_be_viewed()
    {
        $collection = Collection::factory()->create();

        $tasks = Task::factory()->count(3)->create([
            'collection_id' => $collection->id,
        ]);

        $this->get(route('collections.tasks', $collection))
            ->assertOk()
            ->assertJson([
                'tasks' => $tasks->toArray(),
            ]);
    }

    public function test_a_task_can_be_viewed()
    {
        $task = Task::factory()->create();

        $this->get(route('collections.tasks.show', [$task->collection, $task]))
            ->assertOk()
            ->assertJson([
                'task' => $task->attributesToArray(),
            ]);
    }

    public function test_a_task_can_be_created()
    {
        $task = Task::factory()->create();

        $this->post(route('collections.tasks.store', $task->collection), $task->toArray())
            ->assertCreated();

        $this->assertDatabaseHas(Task::class, [
            'collection_id' => $task->collection->id,
            'title' => $task->title,
            'completed' => $task->completed,
            'due_date' => $task->due_date,
        ]);
    }

    public function test_a_task_can_be_updated()
    {
        $old = Task::factory()->create();
        $new = Task::factory()->make(['collection_id' => 1]);

        $this->put(route('collections.tasks.update', [$old->collection, $old]), $new->toArray())
            ->assertNoContent();

        $this->assertDatabaseHas(Task::class, [
            'collection_id' => $new->collection->id,
            'title' => $new->title,
            'completed' => $new->completed,
            'due_date' => $new->due_date,
        ]);
    }

    public function test_a_task_can_be_deleted()
    {
        $task = Task::factory()->create();

        $this->delete(route('collections.tasks.destroy', [$task->collection, $task]))
            ->assertNoContent();

        $this->assertDatabaseMissing(Task::class, [
            'id' => $task->id,
        ]);
    }

    public function test_a_task_can_be_completed()
    {
        $task = Task::factory()->create([
            'completed' => false,
        ]);

        $this->put(route('tasks.complete', $task))
            ->assertNoContent();

        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'completed' => true,
        ]);
    }

    public function test_a_task_can_be_uncompleted()
    {
        $task = Task::factory()->create([
            'completed' => true,
        ]);

        $this->delete(route('tasks.uncomplete', $task))
            ->assertNoContent();

        $this->assertDatabaseHas(Task::class, [
            'id' => $task->id,
            'completed' => false,
        ]);
    }
}
