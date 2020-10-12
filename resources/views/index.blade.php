<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Admin::title() }}</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

{!! Admin::css() !!}

<!-- REQUIRED CSS BY iBrand-->
    <link rel="stylesheet" href="//at.alicdn.com/t/font_u5095o4vzog8pvi.css">
    <link rel="stylesheet" href="{{ admin_asset ("/vendor/libs/webuploader-0.1.5/webuploader.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/inspinia/css/animate.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/inspinia/css/style.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/inspinia/css/main.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/inspinia/css/admin.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/css/plugins/iCheck/custom.css") }}">


    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <script src="{{ admin_asset ("/vendor/libs/jquery.form.min.js") }}"></script>
    {!! \iBrand\Backend\Backend::js() !!}

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
		window.AppUrl = "{{env('APP_URL')}}";
		window._token = "{{ csrf_token() }}";
    </script>


</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">

{{--<body class="hold-transition skin-1">--}}

<div id="wrapper">

    @if(config('ibrand.backend.scenario')=='normal' || !config('ibrand.backend.scenario'))
        @include('admin::partials.sidebar')
    @else
        @include('admin::partials.sidebar_saas')
    @endif


    <div id="page-wrapper" class="gray-bg dashbard-1">

        @include('admin::partials.header')


        <div class="row wrapper wrapper-content animated fadeInRight" style="padding-top: 0;">
            <div class="row">
                <div class="col-lg-12">
                    <div id="pjax-container">
                        <div id="app">
                            @yield('content')
                        </div>
                        {!! Admin::script() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="pull-right">
                <strong>{{config('ibrand.backend.technical_support')}}</strong>.
            </div>
            <div>
                <strong>Copyright</strong> {{config('ibrand.backend.copyright')}}
            </div>
        </div>
    </div>
</div>

<!-- ./wrapper -->
<script>
	function LA() {
	}

	LA.token = "{{ csrf_token() }}";
</script>

{!! Admin::js() !!}
<!-- REQUIRED JS SCRIPTS BY iBrand-->
<script src="{{ admin_asset ("/vendor/libs/webuploader-0.1.5/webuploader.js") }}"></script>
<script src="{{ admin_asset("/vendor/inspinia/js/plugins/metisMenu/jquery.metisMenu.js") }}"></script>
<script src="{{ admin_asset("/vendor/inspinia/js/inspinia.js") }}"></script>
<script src="{{ admin_asset("/vendor/inspinia/js/plugins/pace/pace.min.js") }}"></script>
<script src="{{ admin_asset ("/vendor/libs/plugins.js") }}"></script>
<script src="{{ admin_asset ("/vendor/libs/active.js") }}"></script>
</body>
</html>