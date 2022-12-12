<?php

namespace App\Http\Controllers;

use App\Models\Method;
use App\Http\Requests\StoreMethodRequest;
use App\Http\Requests\UpdateMethodRequest;
use App\Services\Method\ActionData;
use Illuminate\Http\Response;

class MethodController extends Controller
{
    protected $service;

    public function __construct(ActionData $Method)
    {
        # code...
        $this->service = $Method;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $methods = Method::orderBy('id')->get();
        return view('pages.method', compact('methods'));
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
     * @param  \App\Http\Requests\StoreMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMethodRequest $request)
    {
        //
        $action = $this->service->store($request);
        return $action ? $this->success() : $this->fail(__('auth.something_went_wrong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function show(Method $method)
    {
        //
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function edit(Method $method)
    {
        //
        // Method::find($id)
        return $this->success($method, [], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMethodRequest  $request
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMethodRequest $request, Method $method)
    {
        //
        $action = $this->service->update($request, $method);
        return $action ? $this->success([], [], Response::HTTP_ACCEPTED) : $this->fail(__('auth.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Method  $method
     * @return \Illuminate\Http\Response
     */
    public function destroy(Method $method)
    {
        //
        $action = $this->service->delete($method);
        return $action ? $this->success([], [], Response::HTTP_NO_CONTENT) : $this->fail(__('auth.something_went_wrong'));
    }
}
