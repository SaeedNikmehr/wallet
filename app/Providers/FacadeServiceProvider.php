<?php

namespace App\Providers;

use App\Facades\Response;
use App\Facades\Transaction;
use App\Facades\User;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        Response::run(\App\Utils\Response::class);
        User::run(UserRepository::class);
        Transaction::run(TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
