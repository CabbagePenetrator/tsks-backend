<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectionTasksController extends Controller
{
    public function index(Collection $collection)
    {
        return response()->json([
            'tasks' => $collection->tasks,
        ]);
    }

    public function store(Request $request, Collection $collection)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'completed' => ['required', 'boolean'],
            'due_date' => ['nullable', 'date'],
        ]);

        $collection->tasks()->create(
            $request->only(
                'title',
                'completed',
                'due_date'
            )
        );

        return response(null, Response::HTTP_CREATED);
    }

    public function show(Collection $collection, Task $task)
    {
        return response()->json([
            'task' => $task,
        ]);
    }

    public function update(Request $request, Collection $collection, Task $task)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'completed' => ['required', 'boolean'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update(
            $request->only(
                'title',
                'completed',
                'due_date'
            )
        );

        return response()->noContent();
    }

    public function destroy(Collection $collection, Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
