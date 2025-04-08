<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowSerialPasoRequest;
use App\Services\SerialPasoServiceInterface;
use Illuminate\Http\JsonResponse;

class SerialPasoController extends Controller
{
    protected SerialPasoServiceInterface $serialPasoService;

    /**
     * @param SerialPasoServiceInterface $serialPasoService
     */
    public function __construct(SerialPasoServiceInterface $serialPasoService)
    {
        $this->serialPasoService = $serialPasoService;
    }

    /**
     * @param ShowSerialPasoRequest $request
     * @return JsonResponse
     */
    public function show(ShowSerialPasoRequest $request): JsonResponse
    {
        $result = $this->serialPasoService->getHtmlFileContent($request);

        return response()->json(['result' => $result]);
    }
}
