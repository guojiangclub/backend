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

use Encore\Admin\Admin;
use Encore\Admin\Form;


class Backend extends Admin
{
    /**
     * @var array
     */
    public static $jsFiles = [];

    public static function js($js = null)
    {
        if (!is_null($js)) {
            self::$jsFiles = array_merge(self::$jsFiles, (array) $js);

            return;
        }

        $js = array_get(Form::collectFieldAssets(), 'js', []);

        static::$jsFiles = array_merge(static::$jsFiles, $js);

        return view('admin::partials.js', ['js' => array_unique(static::$jsFiles)]);
    }
}
