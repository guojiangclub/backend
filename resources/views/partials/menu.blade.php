@if(settings('admin_menu_role_status') AND !Admin::user()->isRole('administrator'))

    <?php $Array = [];?>

    @if(!isset($item['children']))

        @if(count($item['roles']))

            @foreach($item['roles'] as $role)

                @if(Admin::user()->isRole($role['slug']) AND !in_array($item['id'],$Array))

                    <li>
                        @if(url()->isValidUrl($item['uri']))
                            <a href="{{ $item['uri'] }}" target="_blank" @if($item['blank']==1) no-pjax @endif >
                                @else
                                    <a href="{{ admin_base_path($item['uri']) }}"
                                       @if($item['blank']==1) no-pjax @endif >
                                        @endif

                                        @if(strpos($item['icon'],'fa')==0)
                                            <i class="fa {{$item['icon']}}"></i>
                                        @else
                                            <i class="{{$item['icon']}}"></i>
                                        @endif
                                        <span>{{$item['title']}}</span>
                                    </a>
                    </li>

                    <?php $Array[] = $item['id'] ?>

                @endif

            @endforeach

        @endif

    @else


        @if(count($item['roles']))

            @foreach($item['roles'] as $role)

                @if(Admin::user()->isRole($role['slug']) AND !in_array($item['id'],$Array))
                    <li class="treeview">
                        <a href="#" @if($item['blank']==1) no-pjax @endif>

                            @if(strpos($item['icon'],'fa')==0)
                                <i class="fa {{$item['icon']}}"></i>
                            @else
                                <i class="{{$item['icon']}}"></i>
                            @endif

                            <span>{{$item['title']}}</span>
                            <span class="fa arrow"></span>
                        </a>
                        {{--{{dd($item['roles'])}}--}}
                        <ul class="treeview-menu nav nav-second-level collapse">

                            @if(isset($item['children']))
                                @foreach($item['children'] as $item)
                                    @include('admin::partials.menu', $item)
                                @endforeach
                            @endif
                        </ul>
                    </li>

                    <?php $Array[] = $item['id']  ?>

                @endif

            @endforeach

        @endif

    @endif


@else



    @if(!isset($item['children']))

        <li>
            @if(url()->isValidUrl($item['uri']))
                <a href="{{ $item['uri'] }}" target="_blank" @if($item['blank']==1) no-pjax @endif ></a>
            @else
                <a href="{{ admin_base_path($item['uri']) }}" @if($item['blank']==1) no-pjax @endif >
                    @endif

                    @if(strpos($item['icon'],'fa')==0)
                        <i class="fa {{$item['icon']}}"></i>
                    @else
                        <i class="{{$item['icon']}}"></i>
                    @endif
                    <span>{{$item['title']}}</span>
                </a>
        </li>





    @else


        <li class="treeview">
            <a href="#" @if($item['blank']==1) no-pjax @endif>

                @if(strpos($item['icon'],'fa')==0)
                    <i class="fa {{$item['icon']}}"></i>
                @else
                    <i class="{{$item['icon']}}"></i>
                @endif

                <span>{{$item['title']}}</span>
                <span class="fa arrow"></span>
            </a>
            {{--{{dd($item['roles'])}}--}}
            <ul class="treeview-menu nav nav-second-level collapse">

                @if(isset($item['children']))
                    @foreach($item['children'] as $item)
                        @include('admin::partials.menu', $item)
                    @endforeach
                @endif
            </ul>
        </li>

        <?php $Array[] = $item['id']  ?>



    @endif


@endif
