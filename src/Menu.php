<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/15
 * Time: 20:00
 */

namespace iBrand\Backend;

use iBrand\Backend\Models\Menu as BaseMenu;

class Menu
{
    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function topMenu()
    {
        return BaseMenu::where('parent_id', 0)->get();
    }

    public function sideMenu($topMenuId = 2)
    {
        return (new BaseMenu())->subTree($topMenuId);
    }
}