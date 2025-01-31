<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::paginate();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request): Task
    {
        $data = $request->validated();
        if (empty($data["status"])) {
            $data["status"] = "pending";
        }
        return Task::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): Task
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task): Task
    {
        $data = $request->validated();

        $task->update($data);

        return $task;
    }

    public function destroy(Task $task): Response
    {
        if ($task->created_by !== Auth::user()->id) {
            return response()->json(['message'=> __('You are not authorized to delete this task')]);
        }

        $task->delete();

        return response()->noContent();
    }
}
