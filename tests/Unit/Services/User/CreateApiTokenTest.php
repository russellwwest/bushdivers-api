<?php

namespace Tests\Unit\Services\User;

use App\Services\UserService;
use PHPUnit\Framework\TestCase;

class CreateApiTokenTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_token_is_returned()
    {
        $userService = new UserService();
        $token = $userService->createApiToken();
        $this->assertIsString($token);
        $this->assertEquals(36, strlen($token));
    }
}
