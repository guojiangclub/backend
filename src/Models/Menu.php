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

use Encore\Admin\Auth\Database\Menu as BaseMenu;

/**
 * Class Menu.
 *
 * @property int $id
 *
 * @method where($parent_id, $id)
 */
class Menu extends BaseMenu
{
    /**
     * @param $nodes
     * @param $parentId
     *
     * @return array
     */
    public function subTree($nodes, $parentId)
    {
        return $this->buildNestedArray($nodes, $parentId);
    }
}
