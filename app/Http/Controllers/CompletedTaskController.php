<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Collection;
use Illuminate\Http\Request;

class CompletedTaskController extends Controller
{
    public function update(Request $request, Task $task)
    {
        $task->update([
            'completed' => true,
        ]);

        return response()->noContent();
    }

    public function destroy(Request $request, Task $task)
    {
        $task->update([
            'completed' => false,
        ]);

        return response()->noContent();
    }
}
