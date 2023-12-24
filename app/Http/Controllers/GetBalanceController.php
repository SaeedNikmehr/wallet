<?php

namespace App\Http\Controllers;

use App\Facades\Response;
use App\Http\Resources\GetBalanceResource;
use App\Models\User;

class GetBalanceController extends Controller
{
    public function __invoke(User $user)
    {
        return Response::success()->data(GetBalanceResource::make($user));
    }
}
