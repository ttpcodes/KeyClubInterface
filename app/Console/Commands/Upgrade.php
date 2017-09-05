<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Upgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs an upgrade on the app. Use with caution.';

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
        $this->info('The upgrade process is now starting! Make sure all files are backed up!');

        if ($this->confirm('Are you sure you wish to continue?')) {
            $this->call('down');
            $bar = $this->output->createProgressBar(3);

            $this->call('migrate');
            $bar->advance();
            $this->info('');
            $this->call('config:cache');
            $bar->advance();
            $this->info(''); 
            $this->call('route:cache');
            $bar->advance();
            $bar->finish();
            $this->info('');
            $this->call('up');
            $this->info('Upgrades performed successfully!');
        }
    }
}
