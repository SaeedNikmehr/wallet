<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetBalanceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_user_balance(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson(route('users.balance.show', $user->id));

        $response->assertJson(fn(AssertableJson $json) => $json->where('status', 'success')
            ->has('data', fn($dataJson) => $dataJson
                ->where('balance', $user->balance)
            )
            ->has('message')
            ->has('errors')
        );
    }

    public function test_returns_error_if_user_id_does_not_exists(): void
    {
        $response = $this->getJson(route('users.balance.show', 1));

        $response->assertJson(fn(AssertableJson $json) => $json->where('status', 'error')
            ->has('data')
            ->where('message', 'Entity Not Found !')
            ->has('errors')
        );
    }
}
