<?php

namespace Tests\Feature\Commands;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionsReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_transactions_reports(): void
    {
        User::factory()->has(Transaction::factory(4)->state(new Sequence(
            ['amount' => -100],
            ['amount' => -1000],
            ['amount' => 1000],
            ['amount' => 500],
        )))->create();


        $this->artisan('transactions:report')
            ->expectsTable([
                'Type',
                'Value',
            ], [
                ['Deposits', 1500],
                ['Withdraws', -1100],
                ['Total', 400],
            ])
            ->assertSuccessful();
    }

}
