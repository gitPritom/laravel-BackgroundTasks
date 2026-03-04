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

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $user = User::findOrFail($this->userId);

        info("Hello from Send Welcome mail Job.");

        Mail::to($user->email)->send(new WelcomeMail($user));
    }
}
