<?php

namespace Database\Factories;

use App\Models\Method;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'date_from' => Carbon::now(),
            'date_to' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'current_month' => $this->faker->word(),
            'current_year' => $this->faker->randomNumber(),
            'status' => $this->faker->boolean(),

            'method_id' => Method::factory(),
        ];
    }
}
