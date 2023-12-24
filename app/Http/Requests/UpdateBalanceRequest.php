<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBalanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $minTransactionValue = config('wallet.min_transaction_amount');
        $maxTransactionValue = config('wallet.max_transaction_amount');

        return [
            'amount' => [
                'required',
                'integer',
                "Between:$minTransactionValue,$maxTransactionValue",
                Rule::notIn([0])]
        ];
    }
}
