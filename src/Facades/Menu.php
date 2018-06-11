<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Backend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Menu.
 */
class Menu extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \iBrand\Backend\Menu::class;
    }
}
