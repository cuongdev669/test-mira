<?php
namespace App\Services;


use Illuminate\Http\Request;

interface MemberServiceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function findFurthest(Request $request): array;
}
