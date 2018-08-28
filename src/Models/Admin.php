<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace iBrand\Backend\Models;

use Encore\Admin\Auth\Database\Administrator;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class Admin extends Administrator{

    public function adminNotifications()
    {
        return $this->hasMany(AdminNotifications::class);
    }
}
