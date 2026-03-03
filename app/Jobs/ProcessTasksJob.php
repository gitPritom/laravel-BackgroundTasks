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
        $this->task->update([
            'status' => 'processing'
        ]);

        // Simulate heavy task
        sleep(10);

        $this->task->update([
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
