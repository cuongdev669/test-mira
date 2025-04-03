<?php
namespace App\Services;

use App\Http\Requests\SearchAccountRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;


interface AccountServiceInterface
{
    /**
     * @param SearchAccountRequest $request
     * @return LengthAwarePaginator
     */
    public function lists(SearchAccountRequest $request): LengthAwarePaginator;

    /**
     * @param string $account
     * @return Account|null
     */
    public function show(string $account): Account | null;

    /**
     * @param CreateAccountRequest $request
     * @return Account
     */
    public function store(CreateAccountRequest $request): Account;

    /**
     * @param UpdateAccountRequest $request
     * @param Account $account
     * @return Account
     */
    public function update(UpdateAccountRequest $request, Account $account): Account;

    /**
     * @param Account $account
     * @return mixed
     */
    public function destroy(Account $account): mixed;
}
