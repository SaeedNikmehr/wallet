<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Helper\ProgressBar;

class Setup extends Command
{
    private ProgressBar $bar;

    protected $signature = 'setup';

    protected $description = 'Create and install all necessary tables, fields or data for running application';

    public function handle(): void
    {
        $this->bar = $this->output->createProgressBar(2);
        $this->bar->start();
        $this->migrate();
        $this->seeder();
        $this->finish();
    }

    //--------------------------------|| Private Methods ||--------------------------------

    private function migrate(): void
    {
        Artisan::call('migrate:refresh -q');
        $this->bar->advance();
    }

    private function finish(): void
    {
        $this->bar->finish();
        $this->newLine();
        $this->showUsersTable();
        $this->newLine();
    }

    private function seeder(): void
    {
        Artisan::call('db:seed');
        $this->bar->advance();
    }

    private function showUsersTable(): void
    {
        $users = User::all();
        $this->info('Users : ');
        $this->table(
            ['ID', 'Name', 'Balance', 'Created At', 'Updated At'],
            $users
        );
    }
}
