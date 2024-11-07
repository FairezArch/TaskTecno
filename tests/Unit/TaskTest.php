<?php

namespace Tests\Unit;

use App\Models\Method;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_method(): void
    {
        $method = Method::factory()->create();
        $task = Task::factory()->create(['method_id' => $method->id]);
        $this->assertInstanceOf(Method::class, $task->method);
        $this->assertEquals($method->id, $task->method->id);
    }

    public function test_date_from_attribute(): void
    {
        $date = now()->format('Y-m-d');
        $task = Task::factory()->create(['date_from' => $date]);
        $expectedDate = now()->createFromFormat(config('app.date_input_format'), $date)
            ->format(config('app.date_format_id'));
        $this->assertEquals($expectedDate, $task->date_from_tab);
    }

    public function test_date_to_attribute(): void
    {
        $date = now()->format('Y-m-d');
        $task = Task::factory()->create(['date_to' => $date]);
        $expectedDate = now()->createFromFormat(config('app.date_input_format'), $date)
            ->format(config('app.date_format_id'));
        $this->assertEquals($expectedDate, $task->date_to_tab);
    }

    public function test_status_attribute(): void
    {
        $task = Task::factory()->create(['status' => 0]);
        $this->assertEquals(__('global.Ongoing'), $task->name_status);

        $task->update(['status' => 1]);
        $this->assertEquals(__('global.finished'), $task->name_status);

        $task->update(['status' => 2]);
        $this->assertEquals(__('global.approach'), $task->name_status);
    }
}
