<?php

namespace App\Repositories;

use App\Facades\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @throws Exception
     */
    public function balanceShouldNotGetBelowZero(int $userBalance, int $amount): void
    {
        if ($amount < 0 && $userBalance < abs($amount)) {
            throw new Exception('user do not have enough credit');
        }
    }

    public function updateBalance(User $user, int $amount): string
    {
        return DB::transaction(function () use ($amount, $user) {
            $user->lockForUpdate();
            $user->increment('balance', $amount);

            return Transaction::createTransaction($user->id, $amount);
        }, 2);
    }
}
