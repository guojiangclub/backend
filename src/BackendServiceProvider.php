<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Backend;

use iBrand\Backend\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
    ];

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        app('view')->prependNamespace('admin', __DIR__.'/../resources/views');

        // merge configs
        $this->mergeConfigFrom(
            __DIR__.'/../config/backend.php', 'ibrand.backend'
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/backend.php' => config_path('ibrand/backend.php'),
            ]);

            $this->publishes([__DIR__.'/../resources/assets' => public_path('vendor')]);
        }

        //merge filesystem
        $this->setAdminDisk();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    protected function setAdminDisk(): void
    {
        $filesystems = config('filesystems');

        $disks = array_merge($filesystems['disks'], config('ibrand.backend')['disks']);

        $filesystems['disks'] = $disks;

        $this->app['config']->set('filesystems', $filesystems);
    }
}
