<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPUnit\Event\Code\Throwable;

class ProcessTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    public $tries = 3;
    public $timeout = 60;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        $task = Task::findOrFail($this->task->id);

        $task->update([
            'status' => 'processing'
        ]);

        sleep(5);

        $task->update([
            'status' => 'completed'
        ]);
    }

    public function failed(Throwable $exception)
    {
        $this->task->update([
            'status' => 'failed',
            'error_message' => $exception->asString()
        ]);
    }

}
