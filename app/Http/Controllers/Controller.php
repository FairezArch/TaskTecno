<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function success(mixed $data = [], array $additional = [], int $statusCode = 201)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ] + $additional)->setStatusCode($statusCode);
    }
    public static function fail(?string $message = '', array $additional = [], int $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ] + $additional)->setStatusCode($statusCode);
    }
}
