<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

		use UtilsTrait;
    public function test_unauthenticated()
    {
        $response = $this->getJson('/courses');
        $response->assertStatus(401);
    }

		public function test_get_all_courses()
    {
        $response = $this->getJson('/courses', $this->defaultHeader());
        $response->assertStatus(200);
    }

		public function test_get_all_courses_total()
    {
				$courses = Course::factory()->count(10)->create();
        $response = $this->getJson('/courses', $this->defaultHeader());
        $response->assertStatus(200)
								->assertJsonCount(count($courses), 'data');
    }

		public function test_get_one_course_unauthenticated()
    {
        $response = $this->getJson('/courses/fake_id');
        $response->assertStatus(401);
    }

		public function test_get_one_course_not_found()
    {
        $response = $this->getJson('/courses/fake_id', $this->defaultHeader());
        $response->assertStatus(404);
    }

		public function test_get_one_course()
    {
				$course = Course::factory()->create();
        $response = $this->getJson("/courses/{$course->id}", $this->defaultHeader());
        $response->assertStatus(200);
    }
}
