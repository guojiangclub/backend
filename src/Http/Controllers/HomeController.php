<?php

namespace iBrand\Backend\Http\Controllers;

use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('果酱社区')
            ->description('大家的果酱 : )')
            ->body(view('admin::guojiang'));
    }
}
