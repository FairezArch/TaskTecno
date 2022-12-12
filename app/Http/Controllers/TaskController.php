<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Method;
use Illuminate\Http\Response;
use App\Services\Task\ActionData;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{

    protected $service;
    protected $c_month;
    protected $c_year;

    public function __construct(ActionData $Task)
    {
        # code...
        $this->service = $Task;
        $this->c_month = 'current_month';
        $this->c_year = 'current_year';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tasks = Task::with('method')->get();
        $methods = Method::all();
        return view('pages.task', compact('tasks', 'methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        //
        $date1 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_from);
        $date2 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_to);
        if(($date1->format('m') !== $date2->format('m')) || ($date1->format('Y') !== $date2->format('Y'))) {
            return $this->fail(__('validation.beetwen_date'), ['errors' => ['beetwen-date' => __('validation.beetwen_date')]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $action = $this->service->store($request, [$this->c_month => $date1->format('F'), $this->c_year => $date1->format('Y')]);
        return $action ? $this->success() : $this->fail(__('auth.something_went_wrong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
        return $this->success($task, [], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
        $date1 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_from);
        $date2 = Carbon::createFromFormat(config('app.date_input_format'), $request->date_to);
        if (($date1->format('m') !== $date2->format('m')) || ($date1->format('Y') !== $date2->format('Y'))) {
            return $this->fail(__('validation.beetwen_date'), ['errors' => ['beetwen-date' => __('validation.beetwen_date')]], 422);
        }

        $action = $this->service->update($request, $task, [$this->c_month => $date1->format('F'), $this->c_year => $date1->format('Y')]);
        return $action ? $this->success([], [], Response::HTTP_ACCEPTED) : $this->fail(__('auth.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
        $action = $this->service->delete($task);
        return $action ? $this->success([], [], Response::HTTP_NO_CONTENT) : $this->fail(__('auth.something_went_wrong'));
    }
}
