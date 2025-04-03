<?php
namespace App\Services;

use App\Http\Requests\SearchAccountRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Repositories\AccountRepositoryInterface;
use App\Models\Account;


class AccountService implements AccountServiceInterface
{
    protected AccountRepositoryInterface $accountRepo;

    /**
     * @param AccountRepositoryInterface $accountRepo
     */
    public function __construct(AccountRepositoryInterface $accountRepo) {
        $this->accountRepo = $accountRepo;
    }

    /**
     * @param SearchAccountRequest $request
     * @return LengthAwarePaginator
     */
    public function lists(SearchAccountRequest $request): LengthAwarePaginator
    {
        return $this->accountRepo->lists($request);
    }

    /**
     * @param string $account
     * @return Account | null
     */
    public function show(string $account): Account | null
    {
        return $this->accountRepo->show($account) ?? null;
    }

    /**
     * @param CreateAccountRequest $request
     * @return Account
     */
    public function store(CreateAccountRequest $request): Account
    {
        return $this->accountRepo->store($request);
    }

    /**
     * @param UpdateAccountRequest $request
     * @param Account $account
     * @return Account
     */
    public function update(UpdateAccountRequest $request, Account $account): Account
    {
        return $this->accountRepo->update($request, $account);
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function destroy(Account $account): bool
    {
        return $this->accountRepo->destroy($account);
    }
}
