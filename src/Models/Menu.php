<?php

namespace iBrand\Backend\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
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
     * build sub tree.
     * @param $parentId
     * @return array
     */
    public function subTree($parentId)
    {
        $nodes = $this->allNodes();
        //dd($nodes)
        return $this->buildNestedArray($nodes,$parentId);

        //$nodes = $this->
        //return $this->();
    }
}
