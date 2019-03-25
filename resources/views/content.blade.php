@extends('admin::index')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2 id="title_name" data-title="{{ $header  }}">
                {{ $header  }}
                <small>{{ $description }}</small>
            </h2>
            @if ($breadcrumb)
                <ol class="breadcrumb" style="margin-right: 30px;">
                    <li><a  no-pjax href="{{ admin_url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    @foreach($breadcrumb as $item)
                        @if($loop->last)
                            <li class="active"
                                    @if (array_has($item, 'left-menu-active'))
                                        id="left-menu-active" data-left-menu-active="{{$item['left-menu-active']}}"
                                    @endif>
                                @if (array_has($item, 'icon'))
                                    <i class="fa fa-{{ $item['icon'] }}"></i>
                                @endif
                                {{ $item['text'] }}
                            </li>
                        @else
                            <li>
                                <a

                                    @if (array_has($item, 'no-pjax'))
                                       no-pjax
                                    @endif

                                    href="{{ admin_url(array_get($item, 'url')) }}">

                                    @if (array_has($item, 'icon'))
                                        <i class="fa fa-{{ $item['icon'] }}"></i>
                                    @endif
                                    {{ $item['text'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            @endif
        </div>
    </div>

    {{--<section class="content-header">
        <h1>
            {{ $header or trans('admin.title') }}
            <small>{{ $description or trans('admin.description') }}</small>
        </h1>

        <!-- breadcrumb start -->
        @if ($breadcrumb)
        <ol class="breadcrumb" style="margin-right: 30px;">
            <li><a href="{{ admin_url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            @foreach($breadcrumb as $item)
                @if($loop->last)
                    <li class="active">
                        @if (array_has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    </li>
                @else
                <li>
                    <a href="{{ admin_url(array_get($item, 'url')) }}">
                        @if (array_has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    </a>
                </li>
                @endif
            @endforeach
        </ol>
        @endif
        <!-- breadcrumb end -->

    </section>--}}

    <section class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        {!! $content !!}

    </section>
@endsection