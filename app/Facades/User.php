<?php

namespace App\Facades;

/**
 * @method static string updateBalance(\App\Models\User $user, int $amount)
 * @method static void balanceShouldNotGetBelowZero(int $userBalance, int $amount)
 *
 * @see \App\Repositories\UserRepository
 */
class User extends BaseFacade
{
    const key = 'user.facade';
}
