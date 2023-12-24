<?php

namespace Repositories;

use App\Models\User;
use App\Repositories\TransactionRepository;
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
}
