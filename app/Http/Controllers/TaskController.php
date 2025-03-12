<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller {
    public function __construct() {
        // Fix: Use middleware through the route instead of in the controller
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
        $task->user_id = Auth::id(); // Associate the task with the authenticated user
        $task->save();

        return response()->json($task->load('user'), 201);
    }

    public function index(): JsonResponse {
        $tasks = Task::with('user')->orderBy('created_at', 'desc')->get();
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
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        return response()->json($tasks);
    }
}
