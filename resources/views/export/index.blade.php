@extends('admin::layouts.bootstrap_modal')

@section('modal_class')
    modal-lg
@stop
@section('title')
    数据导出
@stop

@section('after-styles-end')
    <link rel="stylesheet" href="{{ admin_asset ("/vendor/libs/ladda/ladda-themeless.min.css") }}">
@stop


@section('body')
    <div class="row">
        <div class="progress progress-striped active">
            <div style="width: 5%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-danger">
                <span class="sr-only">40% Complete (success)</span>
            </div>
        </div>
        <div id="down"></div>
    </div>

@stop

<script src="{{ admin_asset ("/vendor/libs/ladda/spin.min.js") }}"></script>
<script src="{{ admin_asset ("/vendor/libs/ladda/ladda.min.js") }}"></script>
<script src="{{ admin_asset ("/vendor/libs/ladda/ladda.jquery.min.js") }}"></script>
<script src="{{ admin_asset ("/vendor/libs/loader/jquery.loader.min.js") }}"></script>

@section('footer')

    <button type="button" class="btn btn-link" data-dismiss="modal">关闭</button>
    <script>

        var get_data_url=$('#{{$toggle}}').data('link');

        if(typeof link_get_data_url!="undefined"){
            var get_data_url=link_get_data_url;
            delete window.link_get_data_url;
        }

        console.log(get_data_url);


        var downUrl='{{route('admin.export.downLoadFile')}}';

        function _get(url){
            $.get(url,function(result){
                if(result.data.status=='goon'){
                    var current=result.data.page;
                    var total=result.data.totalPage;
                    var process=(current/total).toFixed(2);
                    console.log(current);
                    console.log(total);
                    $('.progress-bar').css('width',process*100+'%');
                    _get(result.data.url);

                }else{
                    $('.progress-bar').css('width','98%');
                    var down_url=downUrl+'?type='+result.data.type+'&cache='+result.data.cache+'&title='+result.data.title+'&prefix='+result.data.prefix;
                    $.get(down_url,function (res) {
                        if(res.status){
                            $('.progress-bar').css('width','100%');
                            $('#down').html('文件生成成功<a no-pjax href="'+res.data.url+'">点击下载</a>');
                        }else{
                            $('.progress-bar').css('width','0%');
                            $('#down').html('导出失败，请重试');
                        }

                    });
                }
            });
        }

        $(function () {
            _get(get_data_url);
        });


    </script>
@stop






