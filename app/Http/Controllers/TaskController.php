<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller {
    public function __construct() {
    }

    public function store(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:TODO,IN_PROGRESS,DONE',
            'due_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task = new Task($request->all());
        $task->user_id = Auth::id();
        $task->save();
        event(new TaskCreated("hola"));

        return response()->json($task->load('user'), 201);
    }

    public function index(Request $request): JsonResponse {
        $sortDirection = $request->query('sort', 'asc');
        $status = $request->query('status');

        $query = Task::with('user');

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('due_date', $sortDirection)->get();
        return response()->json($tasks);
    }

    public function search(Request $request): JsonResponse {
        $query = $request->get('q');
        $status = $request->get('status');
        $sortDirection = $request->query('sort', 'asc');

        $tasks = Task::with('user')
            ->where('status', $status)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('due_date', $sortDirection)
            ->get();

        return response()->json($tasks);
    }

    public function show(Task $task): JsonResponse {
        return response()->json($task);
    }

    public function update(Request $request, Task $task): JsonResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
            'status' => 'in:TODO,IN_PROGRESS,DONE',
            'due_date' => 'date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy(Task $task): JsonResponse {
        $task->delete();
        return response()->json(null, 204);
    }

    public function globalSearch(Request $request): JsonResponse {
        $query = $request->get('q');

        $tasks = Task::with('user')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tasks);
    }
}
