<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MemberServiceInterface;
use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    protected MemberServiceInterface $peopleService;

    /**
     * @param MemberServiceInterface $peopleService
     */
    public function __construct(MemberServiceInterface $peopleService)
    {
        $this->peopleService = $peopleService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function find(Request $request): JsonResponse
    {
        $result = $this->peopleService->findFurthest($request);

        return response()->json(['result' => $result]);
    }
}
