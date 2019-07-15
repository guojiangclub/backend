<?php

/*
 * This file is part of ibrand/backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace iBrand\Backend\Http\Controllers;

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Routing\Controller;
use DB;

class MenuController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin.menu'));
            $content->description(trans('admin.list'));

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('auth/menu'));

                    $form->select('parent_id', trans('admin.parent_id'))->options(Menu::selectOptions());
                    $form->text('title', trans('admin.title'))->rules('required');
                    $form->icon('icon', trans('admin.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
                    $form->text('uri', trans('admin.uri'));
                    $form->multipleSelect('roles', trans('admin.roles'))->options(Role::all()->pluck('name', 'id'));
                    $form->radio('blank', '加载方式')->options(['0' => 'pjax', '1'=>'no-pjax' ])->default('0');
                    $form->hidden('_token')->default(csrf_token());

                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
        });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->route('menu.edit', ['id' => $id]);
    }

    /**
     * @return \Encore\Admin\Tree
     */
    protected function treeView()
    {
        return Menu::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                if (!isset($branch['children'])) {
                    if (url()->isValidUrl($branch['uri'])) {
                        $uri = $branch['uri'];
                    } else {
                        $uri = admin_base_path($branch['uri']);
                    }

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param string $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin.menu'));
            $content->description(trans('admin.edit'));

            $content->row($this->form($id)->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form($id=null)
    {

         if(!request()->isMethod('get') AND $id){

            $role_menu_table=config('admin.database.role_menu_table');

            $old_role_ids=DB::table($role_menu_table)->where('menu_id',$id)->pluck('role_id')->toArray();

            $menuIds=$this->getMenuID($id);

            try {

                DB::beginTransaction();

                if(count($old_role_ids)){

                    foreach ($old_role_ids as $old_role_id){

                        DB::table($role_menu_table)->where('role_id',$old_role_id)->whereIn('menu_id',$menuIds)->delete();
                    }

                }

                foreach (request('roles') as $role){

                    if(!empty($role) AND count($menuIds)){

                        foreach ($menuIds as $menuId){

                            $insert=[$role,$menuId];

                            DB::insert('insert into '.$role_menu_table.' (role_id,menu_id) values (?, ? )',
                                $insert);

                        }

                    }
                }

                DB::commit();


            } catch (\Exception $exception) {

                DB::rollBack();

                throw  new \Exception($exception);

            }

        }

        return Menu::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->select('parent_id', trans('admin.parent_id'))->options(Menu::selectOptions());
            $form->text('title', trans('admin.title'))->rules('required');
            $form->icon('icon', trans('admin.icon'))->default('fa-bars')->help($this->iconHelp());
            $form->text('uri', trans('admin.uri'));
            $form->multipleSelect('roles', trans('admin.roles'))->options(Role::all()->pluck('name', 'id'));
            $form->radio('blank', '加载方式')->options(['0' => 'pjax', '1'=>'no-pjax' ])->default('0');
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }


   protected function getMenuID($menu_id)
    {

        $menuIds = [];

        $ids = Menu::where('parent_id', $menu_id)->pluck('id');

        if (count($ids)) {

            foreach ($ids as $k => $id) {

                $menuIds[$k] = Menu::where('parent_id', $id)->orWhere('id', $id)->pluck('id')->toArray();

            }
        }

        return array_flatten($menuIds);
    }

}
