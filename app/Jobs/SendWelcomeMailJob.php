<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\{User};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;

    public function __construct(
        private readonly string $userId 
    ) {}

    public function handle(): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            \Log::warning("User {$this->userId} not found");
            return;
        }

        Mail::to($user->email)->send(new WelcomeMail($user));
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error("Job failed for user {$this->userId}: " . $exception->getMessage());
    }
}
