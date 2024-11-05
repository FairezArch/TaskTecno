<?php

namespace App\Services\Task;

use App\Models\Task;

class ActionData
{
    protected Task $model;

    public function __construct(Task $task)
    {
        // code...
        $this->model = $task;
    }

    public function store($request, $extraData = []): Task
    {
        // code...
        $data = [
            'method_id' => $request->method,
            'name' => $request->name,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'status' => $request->status,
        ];

        return $this->model->create(array_merge($data, $extraData));
    }

    public function update($request, $modelData, $extraData = [])
    {
        // code...
        $data = [
            'method_id' => $request->method,
            'name' => $request->name,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'status' => $request->status,
        ];

        return $modelData->update(array_merge($data, $extraData));
    }

    public function delete($modelData)
    {
        // code...
        return $modelData->delete();
    }
}
