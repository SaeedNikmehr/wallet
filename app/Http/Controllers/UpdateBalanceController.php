<?php

namespace App\Http\Controllers;

use App\Facades\Response;
use App\Facades\User;
use App\Http\Requests\UpdateBalanceRequest;
use App\Http\Resources\UpdateBalanceResource;

class UpdateBalanceController extends Controller
{
    public function __invoke(UpdateBalanceRequest $request, \App\Models\User $user)
    {
        User::balanceShouldNotGetBelowZero($user->balance, $request->amount);
        $referenceId = User::updateBalance($user, $request->amount);

        return Response::success()->data(UpdateBalanceResource::make(['referenceId' => $referenceId]));
    }
}
