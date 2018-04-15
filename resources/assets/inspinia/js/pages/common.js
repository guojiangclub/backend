(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS之类的
        module.exports = factory();
    } else {
        // 浏览器全局变量(root 即 window)
        root.utils = factory();
    }
}(this, function () {
    String.prototype.trim = String.prototype.trim || function () {
        return this.replace(/^\s+|\s+$/g, '');
    };

    var getValue = function(array, obj) {
        var key = array.shift();
        var val = obj[key];

        if (array.length) {
            val = getValue(array, val);
        }

        return val;
    }

    return {
        convertTemplate: function (template, data) {
            return template.replace(/\{#(.+?)#}/g, function ($0, $1) {
                var arr = $1.split('.');
                var val = getValue(arr, data);

                return typeof val !== 'undefined' ? val : $0;
            })
        },
        paging: function (total, current) {
            var html = '';
            html += '<li data-page="1"><a>首页</a></li>';
            if (current != 1) {
                html += '<li class="previous" data-page="' + (current - 1) + '"><a><i class="fa fa-angle-double-left"></i></a></li>';
            }
            var min, max;

            min = Math.max(1, current - 4);
            max = Math.min(min + 9, total);

            for (var i=min,len=max;i<=len;i++) {
                if (i === current) {
                    html += '<li data-page="' + i + '" class="active"><a>' + i + '</a></li>';
                } else {
                    html += '<li data-page="' + i + '"><a href="#">' + i + '</a></li>';
                }
            }
            if (current != total) {
                html += '<li class="next" data-page="' + (current + 1) + '"><a><i class="fa fa-angle-double-right"></i></a></li>';
            }
            html += '<li data-page="' + total + '"><a>末页</a></li>';
            return html;
        }
    }
}));