<?php

namespace App\Http\Controllers;

use App\Services\StudentStatServiceInterface ;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentStatController extends Controller
{
    protected StudentStatServiceInterface  $service;

    public function __construct(StudentStatServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getStats(Request $request): JsonResponse
    {
        return response()->json($this->service->calculateStats($request));
    }
}

