<?php

namespace App\Facades;

/**
 * @method static string createTransaction(int $userId, int $amount)
 * @method static int totalWithdraws()
 * @method static int totalDeposits()
 *
 * @see \App\Repositories\TransactionRepository
 */
class Transaction extends BaseFacade
{
    const key = 'transaction.facade';
}
