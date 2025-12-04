<?php

namespace App\Jobs;

use App\Mail\ConfirmationMail;
use App\Models\User;
use App\Services\GmailService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {

        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Mail::to($this->email)->send(new ConfirmationMail($this->email));

        // Log::info('Sending email to ' . $this->user->email);
        // $to = $this->user->email;
        // $subject = 'Gigalogy Registration';
        // $body = view('emails.welcome', ['email' => $to])->render();

        // // uses GmailService to send email via Gmail API
        // $gmailService->sendMessage($to, $subject, $body);
    }
}
