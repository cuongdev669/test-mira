<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MemberServiceInterface;
use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    protected MemberServiceInterface $memberService;

    /**
     * @param MemberServiceInterface $memberService
     */
    public function __construct(MemberServiceInterface $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function find(Request $request): JsonResponse
    {
        $result = $this->memberService->findFurthest($request);

        return response()->json(['result' => $result]);
    }
}
