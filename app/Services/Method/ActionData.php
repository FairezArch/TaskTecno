<?php

namespace App\Services\Method;

use App\Models\Method;

class ActionData
{
    protected Method $model;

    public function __construct(Method $method)
    {
        // code...
        $this->model = $method;
    }

    public function store($request): Method
    {
        // code...
        return $this->model->create(['name' => $request->name]);
    }

    public function update($request, $modelData)
    {
        // code...
        return $modelData->update(['name' => $request->name]);
    }

    public function delete($modelData)
    {
        // code...
        return $modelData->delete();
    }
}
