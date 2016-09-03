<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>基金净值估算_盘中估值涨幅_关注订阅</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta property="wb:webmaster" content="f438fed58adbca8e" />
    <link rel="stylesheet" href="http://g.alicdn.com/msui/sm/0.5.6/css/sm.min.css">
</head>
<body>
<div class="page">
    <!-- 标题栏 -->
    <header class="bar bar-nav">
        <a class="icon icon-me pull-left"></a>
        <a class="button button-link button-nav pull-right open-popup" data-popup=".popup-about">
            关于
            <span class="icon icon-menu"></span>
        </a>
    </header>
    <div class="bar bar-header-secondary">
        <div class="searchbar">
            <div class="search-input">
                <label class="icon icon-search" for="search"></label>
                <input type="search" id='search' placeholder='输入基金代码...'/>
            </div>
        </div>
    </div>
    <!-- 这里是页面内容区 -->
    <div class="content infinite-scroll" data-distance="50">
        <div id="content-container">

        </div>
    </div>
</div>
<div class="popup popup-about">
    <div class="content-block">
        <p>关于</p>

        <p>1.介于大多数基金网站没有盘中涨跌预警，便打算做一个订阅基金实盘涨跌的web-app应用，筛选自己购买的基金订阅或者收藏。</p>

        <p>2.根据订阅设置，订阅成功后，会根据邮箱发邮件提醒，暂时不做短信提醒。</p>

        <p>3.数据来源：数米和天天基金网。</p>

        <p><a href="#" class="close-popup">回到首页</a></p>
    </div>
</div>
<div class="panel-overlay"></div>
<div class="panel panel-left panel-reveal" id='panel-left-demo' style="background:#9a9da2">
    <div class="content-block-title" style="margin-top: 0.75rem">
        <div class="pull-left">昵称：<label id="nickname"></label></div>
        <div class="pull-right close-panel"><a href="#">关闭</a></div>
    </div>
    <div class="list-block">
        <ul style="background:#9a9da2">
            <li class="item-content item-link">
                <div class="item-media"><i class="icon icon-star"></i></div>
                <div class="item-inner">
                    <div class="item-title">我的订阅</div>
                    <div class="item-after" id="sub"></div>
                </div>
            </li>
        </ul>
    </div>
</div>
<script src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script src='http://g.alicdn.com/msui/sm/0.5.6/js/sm.min.js' charset='utf-8'></script>
<script src="http://cdn.bootcss.com/moment.js/2.10.6/moment.min.js"></script>
<script src="statics/js/fundcode_search.js"></script>
<script>
    var domain = "http://www.cc-wang.cn/apis",//"http://127.0.0.1/refund/apis/",;
        len = fundArray.length;

    $(function () {

        init();

        $(document).on('keyup', '#search', function () {
            if ($.trim($(this).val()).length == 6) {
                $.showPreloader();
                for (var i = 0; i < len; i++) {
                    var code = fundArray[i][0];
                    if (code == $.trim($(this).val())) {
                        if(window.sessionStorage){
                            var html = window.sessionStorage.getItem('funds_'+code);
                            if(html =="" || html==undefined){
                                $.get(domain + '/funds/' + code, function (res) {
                                    setTimeout(function(){
                                        if (!res.error) {
                                            $('#content-container').html('');
                                            $('#content-container').html(load(res.data));
                                            window.sessionStorage.setItem('funds'+code,  $('#content-container').html());
                                            $.hidePreloader();
                                        } else {
                                            $.hidePreloader();
                                            init();
                                        }
                                    },500);

                                });
                            }else{
                                setTimeout(function(){
                                    $('#content-container').html('');
                                    $('#content-container').html(html);
                                },500);

                            }
                        }else{
                            $.get(domain + '/funds/' + code, function (res) {
                                setTimeout(function(){
                                    if (!res.error) {
                                        $('#content-container').html('');
                                        $('#content-container').html(load(res.data));
                                        $.hidePreloader();
                                    } else {
                                        $.hidePreloader();
                                        init();
                                    }
                                },500);

                            });
                        }
                    }
                }
            } else {
                setTimeout(function(){
                    init();
                },500);
            }
        });

       /* $.post(domain+'/subs/',{mail:"574635594@qq.com"},function(data){
            console.log(data);
        });*/
    });

    function init() {
        if(window.sessionStorage){
            var html = window.sessionStorage.getItem('funds');
            if(html =="" || html==undefined){
                $.get(domain + '/funds/', function (res) {
                    if (res.error == 0) {
                        var result = [];
                        for (var i = 0; i < res.data.length; i++) {
                            result.push(load(res.data[i]));
                        }
                        $('#content-container').html('');
                        $('#content-container').html(result.join(''));
                        window.sessionStorage.setItem('funds',  $('#content-container').html());
                    }
                });
            }else{
                $('#content-container').html('');
                $('#content-container').html(html);
            }
        }else{
            $.get(domain + '/funds/', function (res) {
                if (res.error == 0) {
                    var result = [];
                    for (var i = 0; i < res.data.length; i++) {
                        result.push(load(res.data[i]));
                    }
                    $('#content-container').html('');
                    $('#content-container').html(result.join(''));
                }
            });
        }


    }

    function load(data) {
        var arr = [], date = '', style = '', fund = '';
        arr.push(' <div class="card">');
        arr.push('<div class="card-content">');
        arr.push('<div class="list-block media-list"><ul> ');
        arr.push('<li><a href="#" class="item-link item-content"> <div class="item-inner"> <div class="item-title-row"> <div class="item-title" style="font-weight: 200;">基金名称</div> <div class="item-after">' + data.fundname + '</div> </div> </div> </a> </li>');
        arr.push('<li class="item-content"> <div class="item-inner"> <div class="item-title-row"> <div class="item-title" style="font-weight: 200;">基金代码</div> <div class="item-after">' + data.fundcode + '</div> </div> </div></li>');

        if (data.fundrate != '') {
            if (data.fundrate.replace('%', '') > 0) {
                style = 'color:#e11f61';
            } else if (data.fundrate.replace('%', '') < 0) {
                style = 'color:#00CC66';
            }
        }

        if (moment().day() == 0) {
            date = moment().subtract(2, 'days').format('MM-DD');
        } else if (moment().day() == 1) {
            date = moment().subtract(3, 'days').format('MM-DD');
        } else {
            date = moment().subtract(1, 'days').format('MM-DD');
        }
        if (data.fundvalue != '' && data.fundrate != '') {
            if (moment.unix(data.createdate).format('MM-DD') == moment().format('MM-DD')) {
                date = moment().format('MM-DD');
            }
            fund = data.fundvalue + '/' + data.fundrate + '(' + date + ')';
        } else {
            fund = data.fundvalue + '(' + date + ')';
        }
        arr.push('<li class="item-content"> <div class="item-inner"> <div class="item-title-row"> <div class="item-title" style="font-weight: 200;">单位净值</div> <div class="item-after" style="' + style + '">' + fund + '</div> </div> </div> </li>');


        if (data.estimaterate.replace('%', '') > 0) {
            style = 'color: #e11f61';
        } else if (data.estimaterate.replace('%', '') < 0) {
            style = 'color:#00CC66';
        }
        arr.push('<li class="item-content"> <div class="item-inner"> <div class="item-title-row"> <div class="item-title" style="font-weight: 200;">估算值/增长率</div> <div class="item-after" style="' + style + '">' + data.estimatevalue + '/' + data.estimaterate + '</div> </div> </div> </li>');
        if (data.deviationrate != '') {
            arr.push('<li class="item-content"> <div class="item-inner"> <div class="item-title-row"> <div class="item-title" style="font-weight: 200;">偏差率</div> <div class="item-after">' + data.deviationrate + '</div> </div> </div> </li>');
        }
        arr.push('</ul> </div> </div>');
        arr.push('<div class="card-footer"><a href="#"  data-code="' + data.fundcode + '" class="link">订阅</a></div>');
        arr.push('</div>');

        return arr.join('');
    }
</script>

</body>
</html>