<?php

namespace Tests\Unit\Services\User;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;
    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = app()->make(UserService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_created_successfully()
    {
        $data = [
            'email' => 'test@test.com',
            'password' => 'password',
            'name' => 'Test'
        ];
        $user = $this->userService->createUser($data);

        $this->assertEquals($data['email'], $user->email);
    }

    public function test_user_not_created_wit_existing_email()
    {
        $existingUser = User::factory()->create();
        $data = [
            'email' => $existingUser->email,
            'password' => 'password',
            'name' => 'Test'
        ];
        $user = $this->userService->createUser($data);

        $this->assertNull($user);
    }
}
