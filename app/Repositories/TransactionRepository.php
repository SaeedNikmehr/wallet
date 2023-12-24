<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function createTransaction(int $userId, int $amount): string
    {
        $referenceId = $this->createUniqueReferenceId();
        Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
            'reference_id' => $referenceId,
        ]);

        return $referenceId;
    }

    public function totalWithdraws(): int
    {
        return Transaction::query()->where('amount', '<', 0)->sum('amount');
    }

    public function totalDeposits(): int
    {
        return Transaction::query()->where('amount', '>', 0)->sum('amount');
    }

    /*
     * Why did I choose these steps for creating a unique reference id?
     *
     * I think the best way to create a unique ID is using something like UUID,
     * but since we need a smaller length ID, we can use PHP uniqid() which is based on microseconds
     * and because we need to return this value, I can't make it async.
     */
    private function createUniqueReferenceId(): string
    {
        $referenceId = strtoupper(uniqid());
        $transaction = Transaction::query()->where('reference_id', $referenceId)->first();
        if (!is_null($transaction)) {
            return $this->createUniqueReferenceId();
        }

        return $referenceId;
    }
}
