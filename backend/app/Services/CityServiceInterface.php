<?php
namespace App\Services;


use Illuminate\Http\Request;

interface CityServiceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function findMemberLargestAge(Request $request): array;
}
