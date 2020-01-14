<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiDocCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidoc';

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
            exec('apidoc -i  app/Http/Controllers/ -o public/apidoc');
                $this->info('ApiDoc generate successfully');
        }catch (\Exception $exception){
                $this->error('ApiDoc generate error, maybe problem in you apidoc annotation');
        }
    }
}
