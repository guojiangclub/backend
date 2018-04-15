<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/15
 * Time: 11:51
 */

return [
    /*
    * Laravel-admin name.
    */
    'name' => 'iBrand 管理后台',

    /*
     * Logo in admin panel header.
     */
    'logo' => '<b>iBrand</b> 管理后台',

    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => 'B',

    /*
     * Laravel-admin html title.
     */
    'title' => 'iBrand 管理后台',

    'disks' => [

        'admin' => [
            'driver' => 'local',
            'root' => storage_path('app/public/backend'),
            'url' => env('APP_URL').'/storage/backend',
            'visibility' => 'public',
        ],

    ],
];