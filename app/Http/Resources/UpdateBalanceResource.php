<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateBalanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'reference_id' => $this['referenceId'],
        ];
    }
}
