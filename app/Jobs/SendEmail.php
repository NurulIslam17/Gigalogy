<?php

namespace App\Jobs;

use App\Services\GmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle(GmailService $gmailService): void
    {
        // Mail::to($this->email)->send(new ConfirmationMail($this->email));
        $to = $this->email;
        $subject = 'Gigalogy Registration';
        $body = view('emails.welcome', ['email' => $to])->render();
        // uses GmailService to send email via Gmail API
        $gmailService->sendEmail($to, $subject, $body);
    }
}
