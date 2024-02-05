<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::query()
            ->with('tasks')
            ->get();

        return response()
            ->json($projects);
    }

    public function create(Request $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ];

        $project = Project::createProject($data);

        return response()
            ->json($project);
    }

    public function show(Project $project): JsonResponse
    {
    }

    public function edit()
    {

    }

    public function update() {

    }

    public function delete()
    {

    }

}
