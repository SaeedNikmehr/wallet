<?php

namespace Repositories;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_transaction_record(): void
    {
        $user = User::factory()->create();
        $amount = 1000;

        $repository = new TransactionRepository();
        $referenceId = $repository->createTransaction($user->id, $amount);

        $this->assertDatabaseHas('transactions', [
            'reference_id' => $referenceId,
            'user_id' => $user->id,
            'amount' => $amount
        ]);
    }

    public function test_can_get_total_withdraws(): void
    {
        User::factory()->has(Transaction::factory(3)->state(new Sequence(
            ['amount' => -100],
            ['amount' => -1000],
            ['amount' => 500],
        )))->create();

        $repository = new TransactionRepository();
        $result = $repository->totalWithdraws();

        $this->assertEquals(-1100, $result);
    }

    public function test_can_get_total_deposits(): void
    {
        User::factory()->has(Transaction::factory(3)->state(new Sequence(
            ['amount' => -100],
            ['amount' => 1000],
            ['amount' => 500],
        )))->create();

        $repository = new TransactionRepository();
        $result = $repository->totalDeposits();

        $this->assertEquals(1500, $result);
    }

}
