<?php
namespace App\Repositories;

use App\Http\Requests\SearchAccountRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;


class AccountRepository implements AccountRepositoryInterface
{
    /**
     * @param SearchAccountRequest $request
     * @return LengthAwarePaginator
     */
    public function lists(SearchAccountRequest $request): LengthAwarePaginator
    {
        $query = new Account();
        $data = $request->all();
        foreach($data as $item => $value) {
            $query = $this->search($query, $item, $value);
        }
        return $query->paginate(10);
    }

    /**
     * @param string $account
     * @return Account | null
     */
    public function show(string $account): Account | null
    {
        return Account::where("registerID", $account)->first() ?? null;
    }

    /**
     * @param CreateAccountRequest $request
     * @return Account
     * @throws \Exception
     */
    public function store(CreateAccountRequest $request): Account
    {
        try {
            DB::beginTransaction();
            $account = Account::create($request->all());
            DB::commit();
            return $account;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param UpdateAccountRequest $request
     * @param Account $account
     * @return Account
     * @throws \Exception
     */
    public function update(UpdateAccountRequest $request, Account $account): Account
    {
        try {
            DB::beginTransaction();
            $account->update($request->all());
            DB::commit();
            return $account;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function destroy(Account $account): bool
    {
        try {
            DB::beginTransaction();
            $account->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Model | Builder $query
     * @param string $column
     * @param string $data
     * @return Model | Builder
     */
    protected function search(Model | Builder $query, string $column, string $data): Model | Builder
    {
        return match ($column) {
            'registerID', => $query->where($column, $data),
            'login', 'phone' => $query->where($column, 'like', "%$data%"),
            'created_at_from' => $query->whereDate('created_at', '>=', $data),
            'created_at_to' => $query->whereDate('created_at', '<=', $data),
            default => $query,
        };
    }
}
