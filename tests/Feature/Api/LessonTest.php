<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
		use UtilsTrait;

		public function test_get_lesson_unauthenticated()
    {
        $response = $this->getJson('/modules/fake_value/lessons');
        $response->assertStatus(401);
    }

		public function test_get_lesson_not_found()
    {
        $response = $this->getJson('/modules/fake_value/lessons', $this->defaultHeader());
        $response->assertStatus(200)
								->assertJsonCount(0,'data');
    }

		public function test_get_lessons_module()
    {
				$course = Course::factory()->create();
        $response = $this->getJson("/modules/{$course->id}/lessons", $this->defaultHeader());
        $response->assertStatus(200);
    }

		public function test_get_lessons_module_total()
    {
				$module = Module::factory()->create();
				$lessons = Lesson::factory()->count(10)->create(['module_id' => $module->id]);
        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeader());
        $response->assertStatus(200)
								->assertJsonCount(count($lessons), 'data');
    }

		public function test_get_one_lesson_unauthenticated()
    {
        $response = $this->getJson("/lessons/fake_value",);
        $response->assertStatus(401);
    }

		public function test_get_one_lesson_not_found()
    {
        $response = $this->getJson("/lessons/fake_value", $this->defaultHeader());
        $response->assertStatus(404);
    }

		public function test_get_one_lesson()
    {
				$lesson = Lesson::factory()->create();
        $response = $this->getJson("/lessons/{$lesson->id}", $this->defaultHeader());
        $response->assertStatus(200);
    }

}
