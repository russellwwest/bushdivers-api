<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_returns_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->getJson('api/auth/profile');
        $response->assertStatus(200);
        $response->assertJson([
            'email' => $user->email
        ]);
    }

    public function test_returns_not_authenticated_with_missing_token()
    {
        $response = $this->getJson('api/auth/profile');
        $response->assertStatus(401);
    }
}
