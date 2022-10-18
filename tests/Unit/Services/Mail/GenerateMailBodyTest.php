<?php

namespace Tests\Unit\Services\Mail;

use App\Models\User;
use App\Services\MailService;
use PHPUnit\Framework\TestCase;

class GenerateMailBodyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register_mail_body_is_generated()
    {
        $user = new User();
        $mailService = new MailService();
        $body = $mailService->generateEmail('register', $user);
        $this->assertIsArray($body);
    }
}
