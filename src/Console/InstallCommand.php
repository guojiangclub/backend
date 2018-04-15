<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Backend\Console;

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
     */
    public function handle()
    {
        $this->call('admin:install');

        $this->reBuildMenu();
    }

    /**
     * Create tables and seed it.
     */
    public function reBuildMenu()
    {
        $this->call('db:seed', ['--class' => MenuTablesSeeder::class]);
    }
}
