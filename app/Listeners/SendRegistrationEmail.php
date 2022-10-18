<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationEmail
{
    protected MailService $mailService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $body = $this->mailService->generateEmail('register', $event->user);
        $this->mailService->sendEmail($body);
    }
}
