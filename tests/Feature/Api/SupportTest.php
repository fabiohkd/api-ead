<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Support;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

		use UtilsTrait;

		public function test_get_my_supports_unauthenticated()
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

		public function test_get_my_supports()
    {
				$user = $this->createUser();
				$token = $user->createToken('teste')->plainTextToken;
				Support::factory()->count(50)->create(['user_id' => $user->id]);
				Support::factory()->count(50)->create();
        $response = $this->getJson('/my-supports', [
					'Authorization' => 'Bearer ' . $token
				]);

        $response->assertStatus(200)
								->assertJsonCount(50, 'data');
    }
		
		public function test_get_supports_unauthenticated()
    {
        $response = $this->getJson('/supports');

        $response->assertStatus(401);
    }

		public function test_get_supports()
    {
				Support::factory()->count(50)->create();
        $response = $this->getJson('/supports', $this->defaultHeader());

        $response->assertStatus(200)
								->assertJsonCount(50, 'data');
    }

		public function test_get_supports_filters_lesson()
    {
				$lesson = Lesson::factory()->create();

				Support::factory()->count(50)->create();
				Support::factory()->count(10)->create(['lesson_id' => $lesson->id]);

				$payload = ['lesson' => $lesson->id];
        $response = $this->json('GET', '/supports', $payload, $this->defaultHeader());

        $response->assertStatus(200)
								->assertJsonCount(10, 'data');
    }

		public function test_create_support_unauthenticated()
    {
        $response = $this->postJson('/supports');

        $response->assertStatus(401);
    }

		public function test_create_support_error_validator()
    {
        $response = $this->postJson('/supports', [], $this->defaultHeader());

        $response->assertStatus(422);
    }

		public function test_create_support()
    {
				$lesson = Lesson::factory()->create();
				$payload =[
					'lesson' => $lesson->id,
					'status' => 'P',
					'description' => 'description Test'
				];
        $response = $this->postJson('/supports', $payload, $this->defaultHeader());

        $response->assertStatus(201);
    }
}
