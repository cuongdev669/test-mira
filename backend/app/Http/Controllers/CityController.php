<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityServiceInterface;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    protected CityServiceInterface $cityService;

    /**
     * @param CityServiceInterface $cityService
     */
    public function __construct(CityServiceInterface $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function find(Request $request): JsonResponse
    {
        $result = $this->cityService->findMemberLargestAge($request);

        return response()->json($result);
    }
}
