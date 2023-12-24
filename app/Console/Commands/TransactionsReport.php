<?php

namespace App\Console\Commands;

use App\Facades\Transaction;
use Illuminate\Console\Command;

class TransactionsReport extends Command
{
    protected $signature = 'transactions:report';

    protected $description = 'Calculate total amount of transactions and print it on terminal';

    public function handle(): void
    {
        $withdraws = Transaction::totalWithdraws();
        $deposits = Transaction::totalDeposits();

        $this->info('Transactions Report: ');
        $this->table(
            ['Type', 'Value'],
            [
                ['Deposits', $deposits],
                ['Withdraws', $withdraws],
                ['Total', $deposits + $withdraws],
            ]
        );
    }
}
