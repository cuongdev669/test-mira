<?php
namespace App\Services;


use App\Http\Requests\ShowSerialPasoRequest;

interface SerialPasoServiceInterface
{
    /**
     * @param ShowSerialPasoRequest $request
     * @return array
     */
    public function getHtmlFileContent(ShowSerialPasoRequest $request): array;
}
