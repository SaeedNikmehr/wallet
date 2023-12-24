<?php

namespace Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateBalanceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_user_balance(): void
    {
        $user = User::factory()->has(Transaction::factory())->create();
        $request = ['amount' => 1000];
        $referenceId = $user->transactions->first()->reference_id;

        \App\Facades\User::shouldReceive('balanceShouldNotGetBelowZero')->once()
            ->with($user->balance, $request['amount'])
            ->andReturnNull();
        \App\Facades\User::shouldReceive('updateBalance')->once()
            ->andReturn($referenceId);

        $response = $this->patchJson(route('users.balance.update', $user->id), $request);
        $response->assertJson(fn(AssertableJson $json) => $json->where('status', 'success')
            ->has('data', fn($dataJson) => $dataJson
                ->where('reference_id', $referenceId)
            )
            ->has('message')
            ->has('errors')
        );
    }

    public function test_throws_exception_if_user_balance_is_going_to_be_below_zero(): void
    {
        $user = User::factory()->create();
        $request = ['amount' => 1000];

        \App\Facades\User::shouldReceive('balanceShouldNotGetBelowZero')->once()
            ->with($user->balance, $request['amount'])
            ->andThrow(new \Exception(), 'user do not have enough credit');
        \App\Facades\User::shouldReceive('updateBalance')->never();

        $response = $this->patchJson(route('users.balance.update', $user->id), $request);
        $response->assertJson(fn(AssertableJson $json) => $json->where('status', 'error')
            ->has('data')
            ->has('message')
            ->has('errors')
        );
    }

    public function test_returns_error_if_amount_is_zero(): void
    {
        $user = User::factory()->create();
        $request = ['amount' => 0];

        \App\Facades\User::shouldReceive('balanceShouldNotGetBelowZero')->never();
        \App\Facades\User::shouldReceive('updateBalance')->never();

        $response = $this->patchJson(route('users.balance.update', $user->id), $request);
        $response->assertJson(fn(AssertableJson $json) => $json->where('status', 'error')
            ->has('data')
            ->where('message', 'The selected amount is invalid.')
            ->has('errors')
        );
    }

}
