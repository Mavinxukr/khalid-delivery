<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class ReloadMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm-p {--a}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Artisan::call('migrate:fresh', ['--seed' => true]);
            Artisan::call('passport:install', ['--force' => true]);
            if ($this->option('a')){
                $this->call('apidoc');
            }
            $this->info('Reload migration successfully');
            $this->info('Passport generate successfully');
        }catch (\Exception $exception){
            $this->error($exception->getMessage());
        }
    }
}
