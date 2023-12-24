<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 10),
            'amount' => random_int(1000, 1000000),
            'reference_id' => random_int(1000, 1000000),
        ];
    }
}
