<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:docker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the application if deployed using Docker.';

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
        $this->info('Beginning app installation process...');


        /**
         * This used to copy the .env file, but that would run into issues,
         * since the instance that is running this install script doesn't have
         * access to the new .env file quite yet.
         */

        $this->call('key:generate');

        /**
         * Don't use "migrate:refresh --seed" here, that command does not work
         * when called in this manner.
         */
        $this->call('migrate');
        $this->call('db:seed');
        $this->call('install:oauth');
        $this->call('storage:link');
        // $this->call('passport:install', [
        //     'user' => 1, '--queue' => 'default'
        // ]);
        $this->info('Done! Remember to edit the .env file to set this project into production.');
    }
}
