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

use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;
use iBrand\Backend\Models\Admin as Administrator;
use iBrand\Backend\Models\AdminNotifications;


class UserController extends Controller
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
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.list'));
            $content->body($this->grid()->render());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.edit'));
            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {

        return Admin::content(function (Content $content) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.create'));
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Administrator::grid(function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->username(trans('admin.username'));
            $grid->name(trans('admin.name'));
            $grid->roles(trans('admin.roles'))->pluck('name')->label();
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at(trans('admin.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
                    $actions->disableDelete();
                }
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form($id=0)
    {

        $Notifications=AdminNotifications::where('admin_id',$id)->pluck('type')->toArray();

        return Administrator::form(function (Form $form) use($Notifications) {

            $form->display('id', 'ID');

            $form->text('username', trans('admin.username'))->rules('required');
            $form->text('name', trans('admin.name'))->rules('required');

            $form->email('email', '邮箱')->rules('required');
            $form->mobile('mobile', '手机')->rules('required');

            $form->image('avatar', trans('admin.avatar'));
            $form->password('password', trans('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);

            $form->multipleSelect('roles', trans('admin.roles'))->options(Role::all()->pluck('name', 'id'));
            $form->multipleSelect('permissions', trans('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));


            // $form->checkbox('notifications.wx_type','微信模板消息通知')
            //     ->options(['wx_orders' => '新订单通知', 'wx_refund' => '新售后通知'])->default($Notifications);


            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));


            $form->saving(function (Form $form) {

                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }

            });


            // $form->saved(function (Form $form) {

            //     $type=$form->notifications['wx_type'];

            //     $res=AdminNotifications::where('admin_id', $form->model()->id)->whereIN('type',['wx_orders','wx_refund'])->delete();

            //     if (count($type) > 0) {
            //         foreach ($type as $item) {
            //             if(!$item) continue;
            //             AdminNotifications::create(['type' => $item,'admin_id'=>$form->model()->id]);
            //         }
            //     }
            // });



        });
    }
}
