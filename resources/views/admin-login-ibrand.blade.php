<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('admin.title')}} | {{ trans('admin.login') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">

    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/toastr/build/toastr.min.css") }}">

    <link rel="stylesheet" href="{{ admin_asset("/vendor/css/login.css") }}">
    <link rel="stylesheet" type="text/css" href="{{admin_asset("/vendor/css/swiper.min.css")}}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>




<div id="content">
    <div class="login-left">
        <div class="swiper-container-solution">
            <div class="selected-solution">
                <div>
                    <div class="swiper-container">

                        <div class="solution-cardlist swiper-wrapper">
                            <div class="col-sm-ss swiper-slide">
                                <div class="solution-card">
                                    <a href="https://guojiang.club/svip" target="_blank">
                                        <img src="https://iyoyo.oss-cn-hangzhou.aliyuncs.com/guojiangclub/backendbanner.png" width="100%">
                                        <h3>果酱社区 SVIP <br>100位种子用户招募中</h3>
                                    </a>
                                </div>
                            </div>
                            {{--<div class="col-sm-ss swiper-slide">
                                <div class="solution-card">
                                    <img src="{{admin_asset("vendor/img/2.png")}}" width="100%">
                                    <h3>提供漂亮的页面动态效果</h3>
                                </div>
                            </div>--}}

                        </div>
                        <div class="swiper-pagination solution-pagination"></div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-right">
        <form id="login_form" action="{{ admin_base_path('auth/login') }}" method="post" onsubmit="return check(this)">

            <div class="login-form">

                <div class="login-box">
                    <div class="logo">
                        <img src="{{ admin_asset("/vendor/img/logo.jpg") }}" alt="">
                    </div>
                    <div class="inptu-box">

                        <input type="text" placeholder="邮箱/用户名" name="username" value="{{ old('username') }}">
                    </div>


                    <div class="inptu-box">

                        <input type="password" placeholder="密码" name="password">

                    </div>


                    @if(config('ibrand.backend.sms_login'))

                        <div class="inptu-box code-box">

                            <input type="text" placeholder="验证码" name="code" value="{{ old('code') }}">

                            <button type="button" id="send-verifi" style="border: none" class="code" data-target="login"
                                    data-status=0>发送验证码
                            </button>

                        </div>

                    @endif


                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="login">
                        <button type="submit" class="login">登录</button>
                    </div>

                </div>
            </div>
        </form>
    </div>

</div>
</body>

</html>

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>

<script src="{{ admin_asset("/vendor/laravel-admin/toastr/build/toastr.min.js")}}"></script>
<script src="{{ admin_asset("/vendor/libs/swiper.min.js")}}" type="text/javascript" charset="utf-8"></script>
<script>
    function check(form) {
        if (form.username.value == '') {
            toastr.warning("请输入邮箱或用户名");
            return false;
        }
        if (form.password.value == '') {
            toastr.warning("请输入密码");
            return false;
        }
        return true;
    }

    @if($errors->has('username'))
    @foreach($errors->get('username') as $message)
    toastr.error("{{$message}}");
    @endforeach
    @endif

    @if($errors->has('code'))
    @foreach($errors->get('code') as $message)
    toastr.error("{{$message}}");
    @endforeach
    @endif

    @if($errors->has('password'))
    @foreach($errors->get('password') as $message)
    toastr.error("{{$message}}");
    @endforeach
            @endif

        window.AppUrl = "{{env('APP_URL')}}";
    window._token = "{{ csrf_token() }}";
    var postUrl = '{{env('APP_URL')}}/getMobile';

    @if(config('ibrand.backend.sms_login'))
    $(document).ready(function () {
        // 发送验证码
        $('#send-verifi').on('click', function () {
            var el = $(this);
            var target = el.data('target');
            var mobileReg = /^(?=\d{11}$)^1(?:3\d|4[57]|5[^4\D]|66|7[^249\D]|8\d|9[89])\d{8}$/;

            if (target == 'login') { //  如果是登录
                $.ajax({
                    type: 'post',
                    data: {
                        username: $('input[name="username"]').val(),
                        _token: _token
                    },
                    url: postUrl,
                    success: function (res) {
                        if (res.status) {
                            $('input[name="mobile"]').val(res.data.mobile);
                            sendCode(el, res.data.mobile);
                        } else {
                            toastr.error(res.msg);
                        }
                    },
                    error: function () {
                        toastr.error('账号验证失败');
                    }
                })

            } else {
                var mobile = $('input[data-type=' + target + ']').val();
                if (mobile == '') {
                    toastr.error('请输入手机号码');
                    return
                }
                if (!mobileReg.test(mobile)) {
                    toastr.error('请输入正确的手机号码');
                } else {
                    sendCode(el, mobile);
                }
            }
        });

        //发送验证码方法
        function sendCode(el, mobile) {
            if (el.data('status') != 0) {
                return
            }
            el.text('正在发送...');
            el.data('status', '1');
            $.ajax({
                type: 'POST',
                data: {
                    mobile: mobile,
                    access_token: _token
                },
                url: AppUrl + "/{{config('ibrand.sms.route.prefix')}}/verify-code?_token=" + _token,
                success: function (data) {
                    if (data.success) {
                        $('input[name="access_token"]').val(_token);
                        var total = 60;
                        var message = '请等待{#counter#}秒';
                        el.text(message.replace(/\{#counter#}/g, total));
                        var timer = setInterval(function () {
                            total--;
                            el.text(message.replace(/\{#counter#}/g, total));

                            if (total < 1) {
                                el.data('status', '0');
                                el.text('发送验证码');
                                clearInterval(timer);
                            }
                        }, 1000)
                    } else {
                        el.data('status', '0');
                        el.text('发送验证码');
                        toastr.error('短信发送失败！');
                    }
                },
                error: function () {
                    el.data('status', '0');
                    el.text('发送验证码');
                    toastr.error('短信发送失败！');
                }
            })
        };

    });
    @endif

</script>
<script type="text/javascript">
    $(function () {
        new Swiper(".swiper-container", {

            //默认功能属性
            speed: 250,
            slidesPerView: 1,
            spaceBetween: 0,
            slidesPerGroup: 1,
            loop: true,
            autoplay: false,

            //分页索引
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },

            //分页按钮
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            }

        });
    })
</script>


