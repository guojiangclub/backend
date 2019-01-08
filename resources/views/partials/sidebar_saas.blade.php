<!-- 左侧头像及菜单-->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{\Illuminate\Support\Facades\Cookie::get('ibrand_log_application_name')}}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{env('APP_URL').'/account/index'}}">
                                <i class="fa fa-film"></i>切换应用</a></li>
                        <li>
                            <a href="{{ url('admin/logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>退出登录
                            </a></li>

                        <form id="logout-form" action="{{ url('admin/logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
            </li>

            @each('admin::partials.menu', BackendMenu::sideMenu(), 'item')

        </ul>
    </div>
</nav>
<!-- 左侧头像及菜单-->