<?php

namespace iBrand\Backend\Console;

use Encore\Admin\Auth\Database\Administrator;
use iBrand\Backend\Database\MenuTablesSeeder;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ibrand:backend-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the ibrand backend';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('admin:install');

        $this->reBuildMenu();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function reBuildMenu()
    {
        $this->call('db:seed', ['--class' => MenuTablesSeeder::class]);
    }
}
