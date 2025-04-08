<?php
namespace App\Services;


use App\Http\Requests\ShowSerialPasoRequest;
use Illuminate\Support\Facades\File;

class SerialPasoService implements SerialPasoServiceInterface
{
    /**
     * @param ShowSerialPasoRequest $request
     * @return array
     */
    public function getHtmlFileContent(ShowSerialPasoRequest $request): array
    {
        try {
            $data = $request->all();
            $basePath = $this->resolveBasePath($data['app_env'], $data['contract_server']);
            // Check file existed
            if (!File::exists($basePath)) {
                throw new \Exception('Target directory not found');
            }

            // Find html file matched
            $files = File::files($basePath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'html' && str_starts_with($file->getFilename(), $data['file'])) {
                    $content = File::get($file->getPathname());
                    return [
                        'success' => true,
                        'filename' => $file->getFilename(),
                        'content' => base64_encode($content),
                        'message' => 'File retrieved successfully',
                    ];
                }
            }

            throw new \Exception('No matching HTML file found');
        } catch (\Exception $e) {
            return [
                'success' => false,
                'filename' => null,
                'content' => null,
                'message' => 'File retrieved error!' . $e->getMessage(),
            ];
        }
    }

    /**
     * @param int $appEnv
     * @param int $contractServer
     * @return string
     */
    private function resolveBasePath(int $appEnv, int $contractServer): string
    {
        $envMap = config('serial.app_env');
        $contracts = config('serial.contract_server');

        $env = $envMap[$appEnv] ?? 'UNKNOWN';
        $server = $contracts[$contractServer] ?? 'UNKNOWN';
        return public_path($env) . DIRECTORY_SEPARATOR. $server;
    }

    /**
     * @param string $message
     * @return array
     */
    private function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'filename' => null,
            'content' => null,
            'message' => $message,
        ];
    }
}
