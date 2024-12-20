<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Method;
use App\Models\Task;
use App\Services\Task\ActionData;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected ActionData $service;
    protected string $c_month;
    protected string $c_year;

    public function __construct(ActionData $Task)
    {
        // code...
        $this->service = $Task;
        $this->c_month = 'current_month';
        $this->c_year = 'current_year';
    }

    /**
     * @return View
     */
    public function index(): View
    {
        //
        $tasks = Task::with('method')->get();
        $methods = Method::all();

        return view('pages.task', compact('tasks', 'methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTaskRequest  $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        //
        $date1 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_from);
        $date2 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_to);
        if (($date1->format('m') !== $date2->format('m')) || ($date1->format('Y') !== $date2->format('Y'))) {
            return self::fail(__('validation.between_date'), ['errors' => ['between-date' => __('validation.between_date')]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $action = DB::transaction(function () use ($request, $date1) {
            return $this->service->store($request, [$this->c_month => $date1->format('F'), $this->c_year => $date1->format('Y')]);
        });

        return $action ? self::success() : self::fail(__('auth.something_went_wrong'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task  $task
     * @return JsonResponse
     */
    public function edit(Task $task): JsonResponse
    {
        //
        return self::success($task, [], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTaskRequest  $request
     * @param  Task  $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        //
        $date1 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_from);
        $date2 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_to);
        if (($date1->format('m') !== $date2->format('m')) || ($date1->format('Y') !== $date2->format('Y'))) {
            return self::fail(__('validation.between_date'), ['errors' => ['between-date' => __('validation.between_date')]], 422);
        }

        $action = DB::transaction(function () use ($request, $date1, $task) {
            return $this->service->update($request, $task, [$this->c_month => $date1->format('F'), $this->c_year => $date1->format('Y')]);
        });

        return $action ? self::success([], [], Response::HTTP_ACCEPTED) : self::fail(__('auth.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task  $task
     * @return JsonResponse
     */
    public function destroy(Task $task): JsonResponse
    {
        //
        $action = DB::transaction(function () use ($task) {
            return $this->service->delete($task);
        });

        return $action ? self::success([], [], Response::HTTP_NO_CONTENT) : self::fail(__('auth.something_went_wrong'));
    }
}
