<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMethodRequest;
use App\Http\Requests\UpdateMethodRequest;
use App\Models\Method;
use App\Services\Method\ActionData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MethodController extends Controller
{
    protected ActionData $service;

    public function __construct(ActionData $Method)
    {
        # code...
        $this->service = $Method;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function index(): Application|Factory|View|\Illuminate\View\View
    {
        //
        $methods = Method::orderBy('id')->get();
        return view('pages.method', compact('methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMethodRequest $request
     * @return JsonResponse
     */
    public function store(StoreMethodRequest $request): JsonResponse
    {
        //
        $action = $this->service->store($request);
        return $action ? self::success() : self::fail(__('auth.something_went_wrong'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Method $method
     * @return JsonResponse
     */
    public function edit(Method $method): JsonResponse
    {
        return self::success($method, [], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMethodRequest $request
     * @param Method $method
     * @return JsonResponse
     */
    public function update(UpdateMethodRequest $request, Method $method): JsonResponse
    {
        //
        $action = $this->service->update($request, $method);
        return $action ? self::success([], [], Response::HTTP_ACCEPTED) : self::fail(__('auth.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Method $method
     * @return JsonResponse
     */
    public function destroy(Method $method): JsonResponse
    {
        //
        $action = $this->service->delete($method);
        return $action ? self::success([], [], Response::HTTP_NO_CONTENT) : self::fail(__('auth.something_went_wrong'));
    }
}
