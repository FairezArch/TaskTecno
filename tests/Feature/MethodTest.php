<?php

namespace Tests\Feature;

use App\Models\Method;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MethodTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_access_index(): void
    {
        $response = $this->get(route('method.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.method');
    }

    public function test_can_create_method(): void
    {
        $response = $this->postJson(route('method.store'), ['name' => fake()->word()]);
        $response->assertCreated();
    }

    public function test_can_see_edit_method(): void
    {
        $method = Method::factory()->create();
        $response = $this->get(route('method.edit', $method));
        $response->assertOk();
    }

    public function test_can_update_method(): void
    {
        $method = Method::factory()->create();
        $response = $this->put(route('method.update', $method), ['name' => fake()->word()]);
        $response->assertStatus(202);
    }

    public function test_can_delete_method(): void
    {
        $method = Method::factory()->create();
        $response = $this->delete(route('method.destroy', $method));
        $response->assertNoContent();
    }
}
