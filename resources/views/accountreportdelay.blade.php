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
        /*$('.timep').timepicker({
            'scrollDefault': 'now'
        });
        $('#workon').timepicker({
            'scrollDefault': 'now'
        });
        $('#workoff').timepicker({
            'scrollDefault': 'now'
        });*/
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
    .error{
        border: solid  red ;
    }
    </style>
</head>

<body style="font-family:微軟正黑體">
    <div class="container-fluid">
        @include('includes.navbar')
        <div class="row" style="margin-bottom:10px">
            <div class="col-xs-1" style="font-size:40px;font-weight:bold;color:red;">
            補
            </div>
            <div class="col-xs-2">
                <span id="r1" class="fui-calendar"></span>&nbsp;&nbsp;
                <input id="day" type="text" placeholder="日期" style="border:none;border-bottom:2px green solid;">
            </div>
            <div class="col-xs-2">
                <span class="fui-time"></span>&nbsp;&nbsp;
                <input id="workon" type="text" placeholder="上班時間(24小時制)" style="border:none;border-bottom:2px green solid;">
            </div>
            <div class="col-xs-2">
                <span class="fui-time"></span>&nbsp;&nbsp;
                <input id="workoff" type="text" placeholder="下班時間(24小時制)" style="border:none;border-bottom:2px green solid;">
            </div>
            <div class="col-xs-2">
                <span class="fui-home"></span>&nbsp;&nbsp;
                <input id="leave" type="text" placeholder="休假" data-toggle="dropdown" style="border:none;border-bottom:2px green solid;">
                <ul id="leaveul" role="menu" class="dropdown-menu">
                    <li><a>整天</a></li>
                    <li><a>半天</a></li>
                    <li><a>會議整天</a></li>
                    <li><a>會議半天</a></li>
                </ul>
                <input id="countv" type="hidden" value="2">
                <input id="username" type="hidden" value="{!!$username!!}">
                <input id="usernumber" type="hidden" value="{!!$usernumber!!}">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" style="border-bottom:#1ABC9C 2px solid;"></div>
        </div>
        <!--z1是樣板start-->
        <div id="z1" style="display:none">
            <div class="row">
                <input type="hidden" name="exist" id="exist" value="1">
                <div class="col-xs-6" style="margin-top:10px">
                    <div class="row" style="margin-top:10px">
                        <div class="col-xs-offset-3">
                            <div class="col-xs-4">
                                <input id="atime" type="text" id="n1" value="" placeholder="時間" class="timep form-control" />
                            </div>
                            <div class="col-xs-4">
                                <input id="where" type="text" value="" placeholder="地區" class="form-control" />
                            </div>
                            <div class="col-xs-3">
                                <input id="division" type="text" value="" placeholder="科別" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-xs-offset-3">
                            <div class="col-xs-5">
                                <input id="consumer" type="text" value="" placeholder="客戶名稱" class="form-control" />
                            </div>
                            <div class="col-xs-3">
                                <input id="who" type="text" value="" placeholder="拜訪對象" class="form-control" />
                            </div>
                            <div class="col-xs-3">
                                <input id="title" type="text" value="" placeholder="職稱" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-xs-offset-3">
                            <div class="col-xs-5">
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
                            <div class="col-xs-5">
                                <div class="btn-group">
                                    <button id="category" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button>
                                    <ul id="categoryul" role="menu" class="dropdown-menu">
                                        <li><a>寄款</a></li>
                                        <li><a>收單</a></li>
                                        <li><a>產品說明</a></li>
                                        <li><a>其他</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6" style="margin-top:10px">
                    <div class="row">
                        <div class="col-xs-6" style="margin-top:10px">
                            <textarea id="talk" placeholder="拜訪情形" rows="6" cols="60" class="form-control"></textarea>
                        </div>
                        <div class="col-xs-4" style="margin-top:10px">
                            <textarea id="other" placeholder="備註" rows="6" cols="20" class="form-control"></textarea>
                        </div>
                        <div class="col-xs-2" style="margin-top:50px">
                            <span id="plus1" class="plus1 fui-plus-circle"></span>
                            <br>
                            <span id="refuse1" class="refuse1 fui-cross-circle"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-xs-12" style="border-bottom:#1ABC9C 2px solid;"></div>
            </div>
        </div>
        <!--z1是樣板end-->
        <div id="z2" style="display:block">
            <div class="row">
                <input type="hidden" name="exist" id="exist" value="1">
                <div class="col-xs-6" style="margin-top:10px">
                    <div class="row" style="margin-top:10px">
                        <div class="col-xs-offset-3">
                            <div class="col-xs-4">
                                <input id="atime" type="text" id="n1" value="" placeholder="時間" class="timep form-control" />
                            </div>
                            <div class="col-xs-4">
                                <input id="where" type="text" value="" placeholder="地區" class="form-control" />
                            </div>
                            <div class="col-xs-3">
                                <input id="division" type="text" value="" placeholder="科別" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-xs-offset-3">
                            <div class="col-xs-5">
                                <input id="consumer" type="text" value="" placeholder="客戶名稱" class="form-control" />
                            </div>
                            <div class="col-xs-3">
                                <input id="who" type="text" value="" placeholder="拜訪對象" class="form-control" />
                            </div>
                            <div class="col-xs-3">
                                <input id="title" type="text" value="" placeholder="職稱" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:14px">
                        <div class="col-xs-offset-3">
                            <div class="col-xs-5">
                                <div class="btn-group">
                                    <button id="medicine" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇藥品<span class="caret"></span></button>
                                    <ul id="medicineul" role="menu" class="dropdown-menu">
                                        <li><a>Lendormin</a></li>
                                        <li><a>Mobic</a></li>
                                        <li><a>Pitavol</a></li>
                                        <li><a>Lexapro</a></li>    
                                        <li><a>Lepax10mg</a></li>
                                        <li><a>Lepax5mg</a></li>
                                        <li><a>Deanxit</a></li>
                                        <li><a>Denset</a></li>
                                        <li><a>Ebixa</a></li>
                                        <li><a>其他</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                            <div class="col-xs-5">
                                <div class="btn-group">
                                    <button id="category" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button>
                                    <ul id="categoryul" role="menu" class="dropdown-menu">
                                        <li><a>寄款</a></li>
                                        <li><a>收單</a></li>
                                        <li><a>產品說明</a></li>
                                        <li><a>其他</a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6" style="margin-top:10px">
                    <div class="row">
                        <div class="col-xs-6" style="margin-top:10px">
                            <textarea id="talk" placeholder="拜訪情形" rows="6" cols="60" class="form-control"></textarea>
                        </div>
                        <div class="col-xs-4" style="margin-top:10px">
                            <textarea id="other" placeholder="備註" rows="6" cols="20" class="form-control"></textarea>
                        </div>
                        <div class="col-xs-2" style="margin-top:50px">
                            <span id="plus1" class="plus1 fui-plus-circle"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-xs-12" style="border-bottom:#1ABC9C 2px solid;"></div>
            </div>
        </div>
        <!--php畫出暫存表格 start-->
        <!--php畫出暫存表格 end-->
        <div class="row" style="margin-top:40px;margin-bottom:40px">
            <!--div class="col-xs-offset-4 col-xs-2"><a id="temp" class="btn btn-block btn-lg btn-danger">暫存</a></div-->
            <div class="col-xs-offset-5 col-xs-2"><a id="done" class="btn btn-block btn-lg btn-info">送出</a></div>
        </div>
    </div>
    <script type="text/javascript">
    var cloneCount = 3;

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
        $("#leaveul li").on("click", function() {
            $("#leave").val($(this).text()).trim;
        });
    });
    </script>
    <script type="text/javascript">
    $("#done").click(function() {
        for (var i = 2; i <= $("#countv").val(); i++) {
            if ( $("#z" + i + " #atime").val() == '' && $("#z" + i + " #exist").val() == '1' ) {
                $("#z" + i + " #atime").addClass("error");
                return alert('時間未填寫');
            }
            else if ( $("#z" + i + " #where").val() == '' && $("#z" + i + " #exist").val() == '1' )
            {
                $("#z" + i + " #where").addClass("error");
                return alert('區域未填寫');                
            }
            else if ( $("#z" + i + " #consumer").val() == '' && $("#z" + i + " #exist").val() == '1' )
            {
                $("#z" + i + " #consumer").addClass("error");
                return alert('客戶名稱未填寫');
            }
            else if ( $("#z" + i + " #who").val() == '' && $("#z" + i + " #exist").val() == '1' )
            {
                $("#z" + i + " #who").addClass("error");
                return alert('拜訪對象未填寫');
            }  
            else if ( $("#z" + i + " #medicine").text() == '請選擇藥品' && $("#z" + i + " #exist").val() == '1' )
            {
                $("#z" + i + " #medicine").addClass("error");
                return alert('未選擇藥品');
            }  
            else if ( $("#z" + i + " #category").text() == '請選擇類別' && $("#z" + i + " #exist").val() == '1' )
            {
                $("#z" + i + " #category").addClass("error");
                return alert('未選擇類別');
            }  
            else if ( $("#z" + i + " #talk").val() == '' && $("#z" + i + " #exist").val() == '1' )
            {
                $("#z" + i + " #talk").addClass("error");
                return alert('訪談內容未填寫');
            }    
        };

        var reportday = new Date($('#day').val());
        var nowday = new Date();
        var r = (nowday-reportday) / (1000 * 60 * 60 * 24);
        if ($('#day').val() == '') {
            alert('日期尚未填入');
        } else {
            var countv = $("#countv").val();
            var info = [];
            for (var i = 2; i <= countv; i++) {
                if ($("#z" + i + " #exist").val() > 0) {
                    var infosub = [];
                    infosub.push($("#z" + i + " #atime").val(), $("#z" + i + " #where").val(), $("#z" + i + " #division").val(), $("#z" + i + " #consumer").val(), $("#z" + i + " #who").val(), $("#z" + i + " #title").val(), $("#z" + i + " #medicine").text(), $("#z" + i + " #category").text(), $("#z" + i + " #talk").val(), $("#z" + i + " #other").val());
                    info.push(infosub);
                };
            };
            $.ajax({
                type: 'POST',
                url: '/eip/public/accountreportajax',
                data: {
                    delay:'1',
                    allinfo: info,
                    day: $('#day').val(),
                    workon: $('#workon').val(),
                    workoff: $('#workoff').val(),
                    leave: $('#leave').val(),
                    username: $('#username').val(),
                    usernumber: $('#usernumber').val()
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data) {
                    alert('您的日報已送出\n謝謝');
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
