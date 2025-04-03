<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TestServiceInterface;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    protected TestServiceInterface $testService;

    /**
     * @param TestServiceInterface $testService
     */
    public function __construct(TestServiceInterface $testService)
    {
        $this->testService = $testService;
    }

    /**
     * API test
     */
    public function test(Request $request): JsonResponse
    {
        $name = $request->input('name', '');

        $result = $this->testService->hello($name);

        return response()->json(['result' => $result]);
    }
}
