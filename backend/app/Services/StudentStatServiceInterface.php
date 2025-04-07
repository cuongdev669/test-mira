<?php

namespace App\Services;


use Illuminate\Http\Request;

interface StudentStatServiceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function calculateStats(Request $request): array;
}
