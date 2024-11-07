<?php

namespace Tests\Unit;

use App\Models\Method;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_many_tasks()
    {
        $method = Method::factory()->create();
        $task = Task::factory()->create(['method_id' => $method->id]);
        $this->assertInstanceOf(HasMany::class, $method->task());
        $this->assertTrue($method->task->contains($task));
    }

    public function test_filters_and_maps_data_correctly_in_scopeAllData()
    {
        $data = ['2024', '2023'];

        $model = Method::factory()->create();

        Task::factory()->create([
            'current_year' => '2024',
            'current_month' => 'January',
            'method_id' => $model->id,
        ]);

        Task::factory()->create([
            'current_year' => '2024',
            'current_month' => 'February',
            'method_id' => $model->id,
        ]);

        Task::factory()->create([
            'current_year' => '2023',
            'current_month' => 'January',
            'method_id' => $model->id,
        ]);

        $result = $model->AllData($data);

        $this->assertCount(2, $result->first()[0]['task']);
        $this->assertTrue($result->first()[0]['task']->contains('current_month', 'January'));
        $this->assertTrue($result->first()[0]['task']->contains('current_month', 'February'));

        $this->assertFalse($result->first()[0]['task']->contains('current_year', '2023'));
    }

    public function test_maps_data_based_on_current_month()
    {
        $data = ['January', 'February', 'March'];

        $model = Method::factory()->create();

        Task::factory()->create([
            'current_year' => '2024',
            'current_month' => 'January',
            'method_id' => $model->id,
        ]);

        Task::factory()->create([
            'current_year' => '2024',
            'current_month' => 'February',
            'method_id' => $model->id,
        ]);

        Task::factory()->create([
            'current_year' => '2024',
            'current_month' => 'March',
            'method_id' => $model->id,
        ]);

        $result = $model->allData($data);

        $this->assertTrue($result->first()[0]['task']->contains(function ($task) {
            return $task->current_month === 'January';
        }));

        $this->assertTrue($result->first()[0]['task']->contains(function ($task) {
            return $task->current_month === 'February';
        }));

        $this->assertFalse($result->first()[0]['task']->contains(function ($task) {
            return $task->current_month === 'April';
        }));
    }

}
