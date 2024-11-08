<?php

namespace Tests\Feature;

use Tests\TestCase;

class RateLimitingTest extends TestCase
{

    public function test_rate_limiting(): void
    {
        $limit = 60;
        for ($i = 0; $i < $limit; $i++) {
            $response = $this->getJson('/api/sample');
            $response->assertOk();
        }

        $response = $this->getJson('/api/sample');
        $response->assertStatus(429);
    }
}
