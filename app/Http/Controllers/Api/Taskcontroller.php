<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTasksJob;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Str;

class Taskcontroller extends Controller
{
    public function store(Request $request)
    {
        $task = Task::create([
            'type' => 'heavy',
            'payload' => null,
            'status' => 'pending'
        ]);

        ProcessTasksJob::dispatch($task);

        return response()->json($task);
    }

    public function index()
    {
        return Task::latest()->get();
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }
}
