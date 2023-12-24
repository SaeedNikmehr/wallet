<?php

namespace App\Facades;

/**
 * @method static string createTransaction(int $userId, int $amount)
 *
 * @see \App\Repositories\TransactionRepository
 */
class Transaction extends BaseFacade
{
    const key = 'transaction.facade';
}
