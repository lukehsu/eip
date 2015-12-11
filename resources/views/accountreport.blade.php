<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>業務人員日報表</title>
    <link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
    <link rel="stylesheet" href="./bootstrap331/dist/css/jquery.timepicker.css">
    <link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
    <link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap-datepicker3.css">
    <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/jqueryd.min.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/flat-ui.min.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/application.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/jquery.timepicker.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap3-datepicker.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/locales/bootstrap-datepicker.zh-TW.min.js" charset="UTF-8"></script>
    <script>
    $(function() {
        $('.timep').timepicker({
            'scrollDefault': 'now'
        });
        $('#workon').timepicker({
            'scrollDefault': 'now'
        });
        $('#workoff').timepicker({
            'scrollDefault': 'now'
        });
        $('#day').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            language: "zh-TW",
            autoclose: true
        });
    });
    </script>
    <style type="text/css">
    input:focus {
        outline: 0;
    }
    </style>
</head>

<body style="font-family:微軟正黑體">
    <div class="container-fluid">
        @include('includes.navbar')
        <div class="row" style="margin-bottom:10px">
            <div class="col-md-offset-1 col-md-2">
                <span id="r1" class="fui-calendar"></span>&nbsp;&nbsp;
                <input id="day" type="text" placeholder="日期" style="border:none;border-bottom:2px green solid;">
            </div>
            <div class="col-md-2">
                <span class="fui-time"></span>&nbsp;&nbsp;
                <input id="workon" type="text" placeholder="上班時間" style="border:none;border-bottom:2px green solid;">
            </div>
            <div class="col-md-2">
                <span class="fui-time"></span>&nbsp;&nbsp;
                <input id="workoff" type="text" placeholder="下班時間" style="border:none;border-bottom:2px green solid;">
            </div>
            <div class="col-md-2">
                <span class="fui-home"></span>&nbsp;&nbsp;
                <input id="leave" type="text" placeholder="休假" style="border:none;border-bottom:2px green solid;">
                <input id="countv" type="hidden" value="2">
                <input id="username" type="hidden" value="{!!$username!!}">
                <input id="usernumber" type="hidden" value="{!!$usernumber!!}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="border-bottom:#1ABC9C 2px solid;"></div>
        </div>
        <!--z1是樣板start-->
        <div id="z1" style="display:none">
            <div class="row">
                <input type="hidden" name="exist" id="exist" value="1">
                <div class="col-md-6" style="margin-top:10px">
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-offset-3">
                            <div class="col-md-4">
                                <input id="atime" type="text" id="n1" value="" placeholder="時間" class="timep form-control" />
                            </div>
                            <div class="col-md-3">
                                <input id="where" type="text" value="" placeholder="地區" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <input id="division" type="text" value="" placeholder="科別" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-md-offset-3">
                            <div class="col-md-6">
                                <input id="consumer" type="text" value="" placeholder="客戶名稱" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <input id="who" type="text" value="" placeholder="拜訪對象" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-md-offset-3">
                            <div class="col-md-5">
                                <div class="btn-group">
                                    <button id="medicine" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇藥品<span class="caret"></span></button>
                                    <ul id="medicineul" role="menu" class="dropdown-menu">
                                        <li><a>Pitavol</a></li>
                                        <li><a>Denset</a></li>
                                        <li><a>Lepax10mg</a></li>
                                        <li><a>Lepax5mg</a></li>
                                        <li><a>Lexapro</a></li>
                                        <li><a>Ebixa</a></li>
                                        <li><a>Deanxit</a></li>
                                        <li><a>Lendormin</a></li>
                                        <li><a>Mobic</a></li>
                                        <li><a>其他</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <div class="col-md-5">
                                <div class="btn-group">
                                    <button id="category" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button>
                                    <ul id="categoryul" role="menu" class="dropdown-menu">
                                        <li><a>寄款</a></li>
                                        <li><a>收單</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="margin-top:10px">
                    <div class="row">
                        <div class="col-md-6" style="margin-top:10px">
                            <textarea id="talk" placeholder="拜訪情形" rows="6" cols="60" class="form-control"></textarea>
                        </div>
                        <div class="col-md-4" style="margin-top:10px">
                            <textarea id="other" placeholder="備註" rows="6" cols="20" class="form-control"></textarea>
                        </div>
                        <div class="col-md-2" style="margin-top:50px">
                            <span id="plus1" class="plus1 fui-plus-circle"></span>
                            <br>
                            <span id="refuse1" class="refuse1 fui-cross-circle"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-12" style="border-bottom:#1ABC9C 2px solid;"></div>
            </div>
        </div>
        <!--z1是樣板end-->
        <div id="z2" style="display:block">
            <div class="row">
                <input type="hidden" name="exist" id="exist" value="1">
                <div class="col-md-6" style="margin-top:10px">
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-offset-3">
                            <div class="col-md-4">
                                <input id="atime" type="text" id="n1" value="" placeholder="時間" class="timep form-control" />
                            </div>
                            <div class="col-md-3">
                                <input id="where" type="text" value="" placeholder="地區" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <input id="division" type="text" value="" placeholder="科別" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-md-offset-3">
                            <div class="col-md-6">
                                <input id="consumer" type="text" value="" placeholder="客戶名稱" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <input id="who" type="text" value="" placeholder="拜訪對象" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-md-offset-3">
                            <div class="col-md-5">
                                <div class="btn-group">
                                    <button id="medicine" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇藥品<span class="caret"></span></button>
                                    <ul id="medicineul" role="menu" class="dropdown-menu">
                                        <li><a>Pitavol</a></li>
                                        <li><a>Denset</a></li>
                                        <li><a>Lepax10mg</a></li>
                                        <li><a>Lepax5mg</a></li>
                                        <li><a>Lexapro</a></li>
                                        <li><a>Ebixa</a></li>
                                        <li><a>Deanxit</a></li>
                                        <li><a>Lendormin</a></li>
                                        <li><a>Mobic</a></li>
                                        <li><a>其他</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <div class="col-md-5">
                                <div class="btn-group">
                                    <button id="category" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button>
                                    <ul id="categoryul" role="menu" class="dropdown-menu">
                                        <li><a>寄款</a></li>
                                        <li><a>收單</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="margin-top:10px">
                    <div class="row">
                        <div class="col-md-6" style="margin-top:10px">
                            <textarea id="talk" placeholder="拜訪情形" rows="6" cols="60" class="form-control"></textarea>
                        </div>
                        <div class="col-md-4" style="margin-top:10px">
                            <textarea id="other" placeholder="備註" rows="6" cols="20" class="form-control"></textarea>
                        </div>
                        <div class="col-md-2" style="margin-top:50px">
                            <span id="plus1" class="plus1 fui-plus-circle"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-md-12" style="border-bottom:#1ABC9C 2px solid;"></div>
            </div>
        </div>
        <!--php畫出暫存表格 start-->
        <!--php畫出暫存表格 end-->
        <div class="row" style="margin-top:40px;margin-bottom:40px">
            <!--div class="col-md-offset-4 col-md-2"><a id="temp" class="btn btn-block btn-lg btn-danger">暫存</a></div-->
            <div class="col-md-offset-5 col-md-2"><a id="done" class="btn btn-block btn-lg btn-info">送出</a></div>
        </div>
    </div>
    <script type="text/javascript">
    var cloneCount = 3;
    if ({!!$ticketnumber!!} > 0) {
        $("#z2").slideUp("fast");
        $("#z2 #exist").val("0");
        $.each({!!$ticketarray!!}, function(key, data) {
            var v = cloneCount++;
            $('#countv').val(v);
            $('#z1').clone(true).attr('id', 'z' + v).css('display', 'block').insertAfter($('[id^=z]:last'));
            //下拉式選單選擇物件
            $("#z" + v).find("#medicineul li").on("click", function() {
                $("#z" + v + " #medicine").html($(this).text() + '<span class="caret"></span>').trim;
            });
            $("#z" + v).find("#categoryul li").on("click", function() {
                $("#z" + v + " #category").html($(this).text() + '<span class="caret"></span>').trim;
            });
            $("#z" + v + " #refuse1").on("click", function() {
                $("#z" + v).slideUp("slow");
                $("#z" + v + " #exist").val("0");
            })
            $("#day").val(data['0']).trim;
            $("#workon").val(data['3']).trim;
            $("#workoff").val(data['4']).trim;
            $("#z" + v + " #atime").val(data['5']).trim;
            $("#z" + v + " #where").val(data['6']).trim;
            $("#z" + v + " #division").val(data['7']).trim;
            $("#z" + v + " #consumer").val(data['8']).trim;
            $("#z" + v + " #who").val(data['9']).trim;
            $("#z" + v + " #talk").val(data['12']).trim;
            $("#z" + v + " #other").val(data['13']).trim;
            $("#z" + v + " #medicine").html(data['10'] + '<span class="caret"></span>').trim;
            $("#z" + v + " #category").html(data['11'] + '<span class="caret"></span>').trim;
        });
    };


    $(".plus1").click(function() {
        var v = cloneCount++;
        $('#countv').val(v);
        $('#z1').clone(true).attr('id', 'z' + v).css('display', 'block').insertAfter($('[id^=z]:last'));
        //下拉式選單選擇物件
        $("#z" + v).find("#medicineul li").on("click", function() {
            $("#z" + v + " #medicine").html($(this).text() + '<span class="caret"></span>').trim;
        });
        $("#z" + v).find("#categoryul li").on("click", function() {
            $("#z" + v + " #category").html($(this).text() + '<span class="caret"></span>').trim;
        });
        $("#z" + v + " #refuse1").on("click", function() {
            $("#z" + v).slideUp("slow");
            $("#z" + v + " #exist").val("0");
        })
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#z2").find("#medicineul li").on("click", function() {
            $("#z2 #medicine").html($(this).text() + '<span class="caret"></span>').trim;
        });
        $("#z2").find("#categoryul li").on("click", function() {
            $("#z2 #category").html($(this).text() + '<span class="caret"></span>').trim;
        });
    });
    </script>
    <script type="text/javascript">
    $("#done").click(function() {
        var reportday = new Date($('#day').val());
        var nowday = new Date();
        var r = (nowday-reportday) / (1000 * 60 * 60 * 24);
        if ($('#day').val() == '') {
            alert('日期尚未填入');
        } else if (r >= 1) {
            alert('您已超過當日送單日期');
        } else {
            var countv = $("#countv").val();
            var info = [];
            for (var i = 2; i <= countv; i++) {
                if ($("#z" + i + " #exist").val() > 0) {
                    var infosub = [];
                    infosub.push($("#z" + i + " #atime").val(), $("#z" + i + " #where").val(), $("#z" + i + " #division").val(), $("#z" + i + " #consumer").val(), $("#z" + i + " #who").val(), $("#z" + i + " #medicine").text(), $("#z" + i + " #category").text(), $("#z" + i + " #talk").val(), $("#z" + i + " #other").val());
                    info.push(infosub);
                };
            };
            $.ajax({
                type: 'POST',
                url: '/eip/public/accountreportajax',
                data: {
                    allinfo: info,
                    day: $('#day').val(),
                    workon: $('#workon').val(),
                    workoff: $('#workoff').val(),
                    username: $('#username').val(),
                    usernumber: $('#usernumber').val()
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data) {
                    alert('您的日報已送出\n\n提醒您如需有要修改日報的內容請於當天晚間12點前修改完成並送出\n\n謝謝');
                    document.location.href = "http://127.0.0.1/eip/public/dashboard";
                },
                error: function(xhr, type) {
                    alert('??');
                }
            });
        }
    });
    </script>
</body>
</html>
