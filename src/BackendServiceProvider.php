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
use iBrand\Backend\Console\InstallExtensionsCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use DB;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        InstallExtensionsCommand::class,
    ];

    protected $namespace = 'iBrand\Backend\Http\Controllers';

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

        $this->registerMigrations();

        $this->mapWebRoutes();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    protected function setAdminDisk()
    {
        $filesystems = config('filesystems');

        $disks = array_merge($filesystems['disks'], config('ibrand.backend')['disks']);

        $filesystems['disks'] = $disks;

        $this->app['config']->set('filesystems', $filesystems);
    }

    /**
     * 数据迁移.
     */
    protected function registerMigrations()
    {
        return $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    protected function mapWebRoutes()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'namespace' => $this->namespace,
            'middleware' => config('admin.route.middleware'),
        ];

        Route::group($attributes, function ($router) {

            $router->group([], function ($router) {

                $router->resource('auth/users', 'UserController');

                $router->resource('auth/menu', 'MenuController', ['except' => ['create']]);

            });

            $router->get('login', 'AuthAdminController@getLogin')->name('auth.admin.login');

            $router->get('auth/login', 'AuthAdminController@getLogin')->name('auth.admin.login');

            $router->post('auth/login', 'AuthAdminController@postLogin')->name('auth.admin.login.post');

            $router->post('logout', 'AuthAdminController@getLogout');

            $router->get('auth/setting', 'AuthAdminController@getSetting');

            $router->put('auth/setting', 'AuthAdminController@putSetting');
        });

        Route::group(['namespace' => $this->namespace], function ($router) {
            $router->post('getMobile', 'AuthAdminController@getMobile');

            $router->group(['prefix' => 'export'], function () use ($router) {
                $router->get('/', 'ExportController@index')->name('admin.export.index');
                $router->get('downLoadFile', 'ExportController@downLoadFile')->name('admin.export.downLoadFile');
            });
        });
    }
}
