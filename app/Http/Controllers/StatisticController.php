<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function start(Request $request): JsonResponse
    {
        $data = [
            'user_id' => Auth::id(),
            'project_id' => $request->project_id,
            'task_id' => $request->task_id,
            'start_at' => now(),
        ];

        $statistic = Statistic::query()
            ->create($data);

        return response()
            ->json($statistic);
    }

    public function stop(Request $request): JsonResponse
    {
        $statistic = Statistic::query()
            ->where('user_id', '=', Auth::id())
            ->where('task_id', '=', $request->task_id)
            ->where('end_at', '=', null)
            ->first();

        $statistic?->update(['end_at' => now()]);

        return response()
            ->json($statistic);
    }

    public function getTaskTimeInfo(Request $request): JsonResponse
    {
        $taskId = $request->task_id;

        $taskInfo = Statistic::query()
            ->selectRaw('COALESCE(FLOOR(SUM(EXTRACT(EPOCH FROM (COALESCE(end_at, CURRENT_TIMESTAMP) - start_at)))), 0) as totalTime')
            ->selectRaw('COUNT(CASE WHEN end_at IS NULL THEN 1 END) > 0 as isTimerRunning')
            ->where('task_id', $taskId)
            ->first();

        return response()
            ->json($taskInfo);
    }

    public function getTaskStatistics(Request $request): JsonResponse
    {
        $results = DB::table('statistics')
            ->join('tasks', 'statistics.task_id', '=', 'tasks.id')
            ->select(
                'statistics.task_id',
                'tasks.name',
                DB::raw("TO_CHAR(INTERVAL '1 second' * SUM(EXTRACT(EPOCH FROM (statistics.end_at - statistics.start_at))), 'HH24:MI:SS') as total_time")
            )
            ->where('statistics.project_id', $request->project_id)
            ->groupBy('statistics.task_id', 'tasks.name')
            ->get();

        return response()
            ->json($results);
    }

    public function getProjectsWithStatistics(): JsonResponse
    {
        $results = DB::table('statistics')
            ->join('projects', 'statistics.project_id', '=', 'projects.id')
            ->select(
                'statistics.project_id',
                'projects.name',
                DB::raw("TO_CHAR(INTERVAL '1 second' * SUM(EXTRACT(EPOCH FROM (statistics.end_at - statistics.start_at))), 'HH24:MI:SS') as total_time")
            )
            ->groupBy('statistics.project_id', 'projects.name')
            ->get();

        return response()
            ->json($results);
    }
}
