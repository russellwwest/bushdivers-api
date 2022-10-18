<?php

namespace Tests\Feature\Auth;

use App\Events\UserCreated;
use App\Listeners\SendRegistrationEmail;
use App\Listeners\SetStartingBalance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_registered_successfully()
    {
        Event::fake();
        $response = $this->postJson('api/auth/register', [
            'email' => 'test@test.com',
            'password' => 'password',
            'name' => 'Russ'
        ]);
        $response->assertStatus(201);
    }

    public function test_fails_if_email_already_registered()
    {
        Event::fake();
        $user = User::factory()->create();
        $response = $this->postJson('api/auth/register', [
            'email' => $user->email,
            'password' => 'password',
            'name' => 'Russ'
        ]);
        $response->assertStatus(422);
    }

    public function test_fails_if_data_invalid()
    {
        Event::fake();
        $response = $this->postJson('api/auth/register', [
            'email' => 'test',
            'password' => 'password',
            'name' => 'Russ'
        ]);
        $response->assertStatus(422);
    }

    public function test_user_created_event_runs()
    {
        Event::fake();
        $this->postJson('api/auth/register', [
            'email' => 'test@test.com',
            'password' => 'password',
            'name' => 'Russ'
        ]);
        Event::assertDispatched(UserCreated::class);
        Event::assertListening(UserCreated::class, SendRegistrationEmail::class);
        Event::assertListening(UserCreated::class, SetStartingBalance::class);
    }
}
