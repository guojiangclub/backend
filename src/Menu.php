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

use iBrand\Backend\Models\Menu as DataMenu;

class Menu
{
    private $dataMenu;
    private $allNodes;
    private $collectNodes;
    private $currentTopMenu;

    public function __construct(DataMenu $menu)
    {
        $this->dataMenu = $menu;
        $this->allNodes = $this->dataMenu->allNodes();
        $this->collectNodes = collect($this->allNodes);
        $this->currentTopMenu = $this->getCurrentTopMenu();
    }

    /**
     * Left sider-bar menu.
     *
     * @return array
     */
    public function topMenu()
    {
        $topMenus = $this->collectNodes->filter(function ($value, $key) {
            return 0 == $value['parent_id'];
        });

        $currentTopMenu = $this->getCurrentTopMenu();

        $topMenus = $topMenus->map(function ($value, $key) use ($currentTopMenu) {
            if ($currentTopMenu['id'] == $value['id']) {
                $value['class'] = 'active';
            } else {
                $value['class'] = '';
            }

            return $value;
        })->all();

        return $topMenus;
    }

    public function getCurrentTopMenuByNode($currentNode)
    {
        if (0 == $currentNode['parent_id']) {
            return $currentNode;
        }

        $currentNode = $this->collectNodes->filter(function ($value, $key) use ($currentNode) {
            return $value['id'] == $currentNode['parent_id'];
        })->first();

        return $this->getCurrentTopMenuByNode($currentNode);
    }

    public function sideMenu()
    {
        $currentTopMenu=$this->getCurrentTopMenu();

        $topMenuId = $currentTopMenu['id'];

        return $this->dataMenu->subTree($this->allNodes, $topMenuId);
    }

    /**
     * @return array
     */
    protected function getCurrentTopMenu()
    {
        $prefix = trim(config('admin.route.prefix'), '/');

        $currentMenuUri = str_replace($prefix, '', request()->path());

        $currentMenu = $this->collectNodes->filter(function ($value, $key) use ($currentMenuUri) {
            return $value['uri'] == trim($currentMenuUri, '/');
        })->first();

        $currentTopMenu = null;

        if ($currentMenu) {
            $currentTopMenu = $this->getCurrentTopMenuByNode($currentMenu);
        } else {
            $currentTopMenu = $this->getCurrentTopMenuByUri($currentMenuUri);
        }

        return $currentTopMenu;
    }

    /**
     * @param $currentMenuUri
     *
     * @return mixed
     */
    protected function getCurrentTopMenuByUri($currentMenuUri)
    {
        $topMenus = $this->collectNodes->filter(function ($value, $key) {
            return 0 == $value['parent_id'];
        });
        $topMenus->each(function ($item, $key) use ($currentMenuUri, &$currentTopMenu) {
            $currentUri = array_first(explode('/', trim($currentMenuUri, '/')));
            $itemUri = array_first(explode('/', trim($item['uri'], '/')));
            if ($currentUri == $itemUri) {
                $currentTopMenu = $item;
            }
        });

        if (is_null($currentTopMenu) && 'auth' == array_first(explode('/', trim($currentMenuUri, '/')))) {
            $currentTopMenu = DataMenu::where('title', '系统管理')->where('parent_id', 0)->first();
        }

        return $currentTopMenu;
    }
}
