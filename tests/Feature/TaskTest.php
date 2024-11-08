<?php

namespace Tests\Feature;

use App\Models\Method;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_access_index(): void
    {
        $response = $this->get(route('task.index'));
        $response->assertOk();
        $response->assertViewIs('pages.task');
    }

    public function test_can_access_store(): void
    {
        $date = now();
        $method = Method::factory()->create();
        $response = $this->postJson(route('task.store'), [
            'date_from' => $date->format('Y-m-d'),
            'date_to' => $date->subDays(2)->format('Y-m-d'),
            'method' => $method->id,
            'name' => $method->name,
            'status' => fake()->boolean(),
        ]);
        $response->assertCreated();
    }

    public function test_cannot_store_data_different_date(): void
    {
        $date = now();
        $method = Method::factory()->create();
        $response = $this->postJson(route('task.store'), [
            'date_from' => $date->format('Y-m-d'),
            'date_to' => $date->subMonths(2)->format('Y-m-d'),
            'method' => $method->id,
            'name' => $method->name,
            'status' => fake()->boolean(),
        ]);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'message' => __('validation.between_date'),
            'errors' => [
                'between-date' => __('validation.between_date'),
            ],
        ]);
    }

    public function test_can_access_edit(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('task.edit', $task));
        $response->assertOk();
    }

    public function test_can_access_update(): void
    {
        $date = now();
        $task = Task::factory()->create();
        $method = Method::factory()->create();
        $response = $this->putJson(route('task.update', $task), [
            'date_from' => $date->format('Y-m-d'),
            'date_to' => $date->subDays(2)->format('Y-m-d'),
            'method' => $method->id,
            'name' => $method->name,
            'status' => fake()->boolean(),
        ]);
        $response->assertStatus(202);
    }

    public function test_cannot_update_data_different_date(): void
    {
        $date = now();
        $method = Method::factory()->create();
        $task = Task::factory()->create();
        $response = $this->putJson(route('task.update', [$task]), [
            'date_from' => $date->format('Y-m-d'),
            'date_to' => $date->subMonths(2)->format('Y-m-d'),
            'method' => $method->id,
            'name' => $method->name,
            'status' => fake()->boolean(),
        ]);

        $response->assertUnprocessable();
        $response->assertJson([
            'status' => false,
            'message' => __('validation.between_date'),
            'errors' => [
                'between-date' => __('validation.between_date'),
            ],
        ]);
    }

    public function test_can_access_destroy(): void
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('task.destroy', $task));
        $response->assertNoContent();
    }
}
