<?php

namespace Tests\Feature;

use App\Models\Method;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LearningActivityTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_access_index(): void
    {
        $periodMonth = Task::periodMonth;
        $allData = Method::AllData($periodMonth);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('pages.learning-activity');
        $response->assertViewHas('periodMonth', $periodMonth);
        $response->assertViewHas('allData', $allData);
    }
}
