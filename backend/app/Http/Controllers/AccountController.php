<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchAccountRequest;
use App\Http\Resources\ItemUserResource;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\AccountServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    protected AccountServiceInterface $accountService;

    /**
     * @param AccountServiceInterface $accountService
     */
    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param SearchAccountRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(SearchAccountRequest $request): AnonymousResourceCollection
    {
        $accounts = $this->accountService->lists($request);
        return ItemUserResource::collection($accounts);
    }

    /**
     * @param string $account
     * @return JsonResource | JsonResponse
     */
    public function show(string $account): JsonResource | JsonResponse
    {
        $account = $this->accountService->show($account);
        if($account) {
            return new ItemUserResource($account);
        } else {
            return response()->json(["data" => null], 404);
        }
    }

    /**
     * @param CreateAccountRequest $request
     * @return JsonResource
     */
    public function store(CreateAccountRequest $request): JsonResource
    {
        try {
            $account = $this->accountService->store($request);
            return new ItemUserResource($account);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * @param UpdateAccountRequest $request
     * @param string $account
     * @return JsonResource | JsonResponse
     */
    public function update(UpdateAccountRequest $request, string $account): JsonResource | JsonResponse
    {
        try {
            $account = $this->accountService->show($account);
            if($account) {
                $account = $this->accountService->update($request, $account);
                return new ItemUserResource($account);
            } else {
                return response()->json(["data" => null], 404);
            }
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * @param string $account
     * @return JsonResponse
     */
    public function destroy(string $account): JsonResponse
    {
        try {
            $account = $this->accountService->show($account);
            if ($account) {
                $this->accountService->destroy($account);
                return response()->json(null);
            } else {
                return response()->json(["data" => null], 404);
            }

        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
