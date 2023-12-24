<?php

namespace Tests\Feature\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_throws_exception_if_withdraw_amount_is_greater_than_user_balance(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('user do not have enough credit');

        $repository = new UserRepository();
        $repository->balanceShouldNotGetBelowZero(1000, -10000);
    }

    public function test_can_update_user_balance(): void
    {
        $user = User::factory()->create();
        $balance = $user->balance;

        $repository = new UserRepository();
        $referenceId = $repository->updateBalance($user, 1000);

        $this->assertDatabaseHas('users', ['balance' => $balance + 1000]);
        $this->assertDatabaseHas('transactions', ['reference_id' => $referenceId]);
    }

}
