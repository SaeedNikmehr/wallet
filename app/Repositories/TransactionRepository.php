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
     * and gives us a decent chance for a unique value, but since we need to be sure if it's
     * a duplicate, we repeat to reach a unique value at last. and because we need to return this
     * value to user, I can't make it async using something like observers or events.
     * Another option is using transaction id as a reference in form of base 62(without "-_" vs 64).
     * but to reach a fixed length for smaller IDs we would have a lot of zeros before our reference ID.
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
