<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:;"><i
                        class="fa fa-bars"></i> </a>
        </div>

        <ul class="nav navbar-nav top-navbar">

            @each('admin::partials.top-menu',BackendMenu::topMenu(), 'item')

        </ul>
        @if(config('ibrand.backend.scenario')=='normal' || !config('ibrand.backend.scenario'))
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a data-toggle="dropdown" class="dropdown-togg" href="graph_morris.html#">
                            <span class="block m-r-sm"> <strong class="font-bold">{{auth('admin')->user()->name}}<b
                                            class="caret"></b></strong>
                             </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ admin_base_path('auth/setting') }}"><i class="fa fa-pencil-square-o"></i>设置</a>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('admin/logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>退出
                            </a>

                            <form id="logout-form" action="{{ url('admin/logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif
    </nav>
</div>