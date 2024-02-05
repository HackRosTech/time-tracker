<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\table;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::all();

        return response()
            ->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
        ];

        $task = Task::create($data);

        return response()
            ->json($task);
    }

    public function show(Task $task): JsonResponse
    {
        return response()
            ->json($task);
    }
}
