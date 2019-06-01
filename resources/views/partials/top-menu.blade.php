@if(Admin::user()->visible($item['roles']) && (empty($item['permission']) ?: Admin::user()->can($item['permission'])))
    <li class="{{$item['class']}}">
        <a target="_blank" href="{{ admin_base_path($item['uri']) }}">
            {{--<i class="iconfont {{$item['icon']}}"></i>--}}
            <span>{{$item['title']}}</span>
        </a>
    </li>
@endif