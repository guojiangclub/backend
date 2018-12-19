<!-- 左侧头像及菜单-->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" style="width: 64px;" class="img-circle"
                                 src="{{ Admin::user()->avatar }}"/>
                             </span>
                </div>

                <div class="logo-element">
                    {{config('ibrand.backend.logo-mini')}}
                </div>
            </li>

            @each('admin::partials.menu', BackendMenu::sideMenu(), 'item')

        </ul>
    </div>
</nav>
<!-- 左侧头像及菜单-->