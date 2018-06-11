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

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Illuminate\Console\Command;

class InstallExtensionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'ibrand:backend-install-extensions {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the ibrand backend extensions';

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
        if (empty($this->option('name'))) {
            $this->importAll();
        } else {
            $name = $this->option('name');
            $name = str_replace('-', '', $name);

            if (method_exists($this, $name)) {
                call_user_func([$this, $name]);
            }
        }

        $this->line('<info>Laravel admin extensions installed.</info> ');
    }

    public function importAll()
    {
        $this->helpers();
        $this->redismanager();
        $this->backup();
        $this->logviewer();
        $this->scheduling();
    }

    public function helpers()
    {
        if (Menu::where('title', 'Helpers')->first()) {
            return;
        }

        $lastOrder = Menu::max('order');
        $root = [
            'parent_id' => 1,
            'order' => $lastOrder++,
            'title' => 'Helpers',
            'icon' => 'fa-gears',
            'uri' => '',
        ];
        $root = Menu::create($root);
        $menus = [
            [
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
            ],
            [
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
            ],
            [
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
            ],
            [
                'title' => 'Routes',
                'icon' => 'fa-list-alt',
                'uri' => 'helpers/routes',
            ],
        ];
        foreach ($menus as $menu) {
            $menu['parent_id'] = $root->id;
            $menu['order'] = $lastOrder++;
            Menu::create($menu);
        }

        Permission::create([
            'name' => 'Admin helpers',
            'slug' => 'ext.helpers',
            'http_path' => '/'.trim('helpers/*', '/'),
        ]);
    }

    public function redismanager()
    {
        if (Menu::where('title', 'Redis manager')->first()) {
            return;
        }

        $lastOrder = Menu::max('order');
        $root = [
            'parent_id' => 1,
            'order' => $lastOrder++,
            'title' => 'Redis manager',
            'icon' => 'fa-database',
            'uri' => 'redis',
        ];
        $root = Menu::create($root);

        Permission::create([
            'name' => 'Redis Manager',
            'slug' => 'ext.redis-manager',
            'http_path' => '/'.trim('redis*', '/'),
        ]);
    }

    public function logviewer()
    {
        if (Menu::where('title', 'Log viewer')->first()) {
            return;
        }

        $lastOrder = Menu::max('order');
        $root = [
            'parent_id' => 1,
            'order' => $lastOrder++,
            'title' => 'Log viewer',
            'icon' => 'fa-database',
            'uri' => 'logs',
        ];

        $root = Menu::create($root);

        Permission::create([
            'name' => 'Logs',
            'slug' => 'ext.log-viewer',
            'http_path' => '/'.trim('logs*', '/'),
        ]);
    }

    public function backup()
    {
        if (Menu::where('title', 'Backup')->first()) {
            return;
        }
        $lastOrder = Menu::max('order');
        $root = [
            'parent_id' => 1,
            'order' => $lastOrder++,
            'title' => 'Backup',
            'icon' => 'fa-copy',
            'uri' => 'backup',
        ];

        $root = Menu::create($root);

        Permission::create([
            'name' => 'Backup',
            'slug' => 'ext.backup',
            'http_path' => '/'.trim('backup*', '/'),
        ]);
    }

    public function scheduling()
    {
        if (Menu::where('title', 'Scheduling')->first()) {
            return;
        }
        $lastOrder = Menu::max('order');
        $root = [
            'parent_id' => 1,
            'order' => $lastOrder++,
            'title' => 'Scheduling',
            'icon' => 'fa-clock-o',
            'uri' => 'scheduling',
        ];

        $root = Menu::create($root);

        Permission::create([
            'name' => 'Scheduling',
            'slug' => 'ext.scheduling',
            'http_path' => '/'.trim('scheduling*', '/'),
        ]);
    }
}
