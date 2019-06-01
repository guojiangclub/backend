@if(Admin::user()->visible($item['roles']) && (empty($item['permission']) ?: Admin::user()->can($item['permission'])))
    @if(!isset($item['children']))
        <li>
            @if(url()->isValidUrl($item['uri']))
                <a href="{{ $item['uri'] }}" target="_blank" @if($item['blank']==1) no-pjax @endif>
                    @else
                        <a href="{{ admin_base_path($item['uri']) }}" @if($item['blank']==1) no-pjax @endif>
                            @endif
                            @if(strpos($item['icon'],'fa')==0)
                                <i class="fa {{$item['icon']}}"></i>
                            @else
                                <i class="{{$item['icon']}}"></i>
                            @endif
                            @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                                <span>{{ __($titleTranslation) }}</span>
                            @else
                                <span>{{ $item['title'] }}</span>
                            @endif
                        </a>
        </li>
    @else
        <li class="treeview">
            <a href="#">
                @if(strpos($item['icon'],'fa')==0)
                    <i class="fa {{$item['icon']}}"></i>
                @else
                    <i class="{{$item['icon']}}"></i>
                @endif
                @if (Lang::has($titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($item['title'])))))
                    <span>{{ __($titleTranslation) }}</span>
                @else
                    <span>{{ $item['title'] }}</span>
                @endif
                    <span class="fa arrow"></span>
                {{--<i class="fa fa-angle-left pull-right"></i>--}}
            </a>
            <ul class="treeview-menu nav nav-second-level collapse">
                @foreach($item['children'] as $item)
                    @include('admin::partials.menu', $item)
                @endforeach
            </ul>
        </li>
    @endif
@endif


