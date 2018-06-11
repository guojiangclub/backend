<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Backend\Database;

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;

class MenuTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order' => 1,
                'title' => '系统管理',
                'icon' => 'fa-tasks',
                'uri' => '/',
            ],

            [
                'parent_id' => 1,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
            ],

            [
                'parent_id' => 1,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
            ],
            [
                'parent_id' => 3,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
            ],
            [
                'parent_id' => 3,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
            ],
            [
                'parent_id' => 3,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
            ],
            [
                'parent_id' => 3,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
            ],
            [
                'parent_id' => 3,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
            ],
        ]);

        // add role to menu.
        Menu::find(2)->roles()->save(Role::first());
    }
}
