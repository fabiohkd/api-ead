<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Api\UtilsTrait;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

		use UtilsTrait;
    public function test_fail_auth()
    {
        $response = $this->postJson('/auth', []);

        $response->assertStatus(422);
    }

		public function test_auth()
    {
				$user = User::factory()->create();

        $response = $this->postJson('/auth', [
					'email' => $user->email,
					'password' => 'password',
					'device_name' => 'test',
				]);

        $response->assertStatus(200);
    }

		public function test_logout_error()
    {
        $response = $this->postJson('/logout', []);
        $response->assertStatus(401);
    }

		public function test_logout()
    {
				$token = $this->createTokenUser();

        $response = $this->postJson('/logout', [], $this->defaultHeader());
        $response->assertStatus(200);
    }

		public function test_get_me_error()
    {
        $response = $this->getJson('/me');
        $response->assertStatus(401);
    }

		public function test_get_me()
    {
			$token = $this->createTokenUser();

			$response = $this->getJson('/me', $this->defaultHeader());
      $response->assertStatus(200);
    }

}
