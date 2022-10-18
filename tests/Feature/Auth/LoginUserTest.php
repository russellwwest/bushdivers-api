<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {
        $user = User::factory()->create();
        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_login_fails_for_incorrect_credentials()
    {
        $response = $this->postJson('api/auth/login', [
            'email' => 'john@test.com',
            'password' => 'password'
        ]);
        $response->assertStatus(422);
    }
}
