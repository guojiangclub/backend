@if(settings('admin_menu_role_status') AND !Admin::user()->isRole('administrator'))

    <?php $Array=[];?>

    @if(count($item['roles']))

        @foreach($item['roles'] as $role)

            @if(Admin::user()->isRole($role['slug']) AND !in_array($item['id'],$Array))

                <li class="{{$item['class']}}">
                    <a target="_blank" href="{{ admin_base_path($item['uri']) }}">
                        {{--<i class="iconfont {{$item['icon']}}"></i>--}}
                        <span>{{$item['title']}}</span>
                    </a>
                </li>

                <?php $Array[]=$item['id'] ?>

            @endif



        @endforeach

    @endif


@else

    <li class="{{$item['class']}}">
        <a target="_blank" href="{{ admin_base_path($item['uri']) }}">
            {{--<i class="iconfont {{$item['icon']}}"></i>--}}
            <span>{{$item['title']}}</span>
        </a>
    </li>

@endif