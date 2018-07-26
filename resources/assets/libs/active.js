$(function  () {
    if($("#left-menu-active").length>0){
        $("a").each(function () {
            $(this).attr('no-pjax',1);
        });
        var active=$("#left-menu-active").data('left-menu-active');
        $("span").each(function() {
            if ($(this).text() == active) {
                $(this).parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().addClass("in");
            }
        });
    }

    if($("#title_name").length>0){
        var title=$("#title_name").data('title');
        if(title.length){
            $('title').html(title);
        }
    }
})
