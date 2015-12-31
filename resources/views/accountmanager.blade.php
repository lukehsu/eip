<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>業務報表檢視</title>
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
        $('#startday').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            language: "zh-TW",
            autoclose: true
        });
        $('#endday').datepicker({
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
    
    .error {
        border: solid red;
    }
    </style>
</head>

<body style="font-family:微軟正黑體">
    <div class="container-fluid">
        @include('includes.navbar')
        <div class="row" style="margin-bottom:10px">
            <form id="form1" name="form1" method="post" action="accountmanagerexcel">
            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                <div class="col-md-offset-2 col-md-2" style="margin-top:30px">
                    <span id="r1" class="fui-calendar"></span>
                    <input id="startday" name="startday" type="text" placeholder="搜尋日期起點" style="border:none;border-bottom:2px green solid;">
                </div>
                <div class="col-md-2" style="margin-top:30px">
                    <span id="r1" class="fui-calendar" ></span>
                    <input id="endday" name="endday"  type="text" placeholder="搜尋日期終點" style="border:none;border-bottom:2px green solid;">
                </div>
                <div class="col-md-2" style="margin-top:30px">
                    <span class="fui-user"></span>
                    <input id="accname" name="accname" type="text" placeholder="業務人員" data-toggle="dropdown" style="border:none;border-bottom:2px green solid;">
                    <ul id="accnameul" role="menu" class="dropdown-menu">
                        <li style="cursor: pointer;"><a>
                        所有業務人員
                    </a></li>
                        @foreach ($personalarrs as $personalarr)
                        <li style="cursor: pointer;"><a>
                        {!!$personalarr!!}
                        </a></li>
                        @endforeach
                    </ul>
                    <input id="countv" type="hidden" value="2">
                </div>
                <div class="col-md-1" style="margin-top:15px">
                    <a id="done" class="btn btn-block btn-lg btn-info">預覽</a>
                </div>
                <div class="col-md-1" style="margin-top:15px">
                    <button id="export" class="btn btn-block btn-lg btn-info">匯出</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="border-bottom:#1ABC9C 2px solid;"></div>
    </div>
    <!--z1是樣板start-->
    <div id="z1" style="display:none">
        <div class="row">
            <div id="visitday" class="col-md-offset-1 col-md-3" style="margin-top:10px;font-weight:bold">
                日期:
            </div>
            <div id="visituser" class="col-md-3" style="margin-top:10px;font-weight:bold">
                姓名:
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="exist" id="exist" value="1">
            <div class="col-md-6" style="margin-top:10px">
                <div class="row" style="margin-top:10px">
                    <div class="col-md-offset-3">
                        <div class="col-md-4">
                            <input id="atime" type="text" id="n1" value="" placeholder="時間" class="timep form-control" />
                        </div>
                        <div class="col-md-4">
                            <input id="where" type="text" value="" placeholder="地區" class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <input id="division" type="text" value="" placeholder="科別" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:14px">
                    <div class="col-md-offset-3">
                            <div class="col-md-5">
                                <input id="consumer" type="text" value="" placeholder="客戶名稱" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <input id="who" type="text" value="" placeholder="拜訪對象" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <input id="title" type="text" value="" placeholder="職稱" class="form-control" />
                            </div>
                    </div>
                </div>
                <div class="row" style="margin-top:14px">
                    <div class="col-md-offset-3">
                        <div class="col-md-5">
                            <div class="btn-group">
                                <button id="medicine" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇藥品<span class="caret"></span></button>
                                <ul id="medicineul" role="menu" class="dropdown-menu">
                                </ul>
                            </div>
                            <!-- /btn-group -->
                        </div>
                        <div class="col-md-5">
                            <div class="btn-group">
                                <button id="category" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button>
                                <ul id="categoryul" role="menu" class="dropdown-menu">
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
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-12" style="border-bottom:#1ABC9C 2px solid;"></div>
        </div>
    </div>
    <script type="text/javascript">
    $("#done").click(function() {
        if ( $("#startday").val() == '' ) 
        {
            return alert('起點時間未選擇');
        }
        else if ( $("#endday").val() == '' )
        {
            return alert('終點時間未選擇');                
        }
        else if ( $("#accname").val() == '' )
        {
            return alert('業務名稱未選擇');
        }
        for (var i = 2; i <= $("#countv").val(); i++) {
            $('#z' + i).remove();
        };
        $.ajax({
            type: 'POST',
            url: '/eip/public/accountmanagerajax',
            data: {
                startday: $('#startday').val(),
                endday: $('#endday').val(),
                accname: $('#accname').val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data) {
                var cloneCount = 2;
                $.each(data.main, function(key, data) {
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
                    $("#z" + v + " #visitday").html('日期:' + data['0']).trim;
                    $("#z" + v + " #visituser").html('姓名:' + data['1']).trim;
                    $("#z" + v + " #atime").val(data['5']).trim;
                    $("#z" + v + " #where").val(data['6']).trim;
                    $("#z" + v + " #division").val(data['7']).trim;
                    $("#z" + v + " #consumer").val(data['8']).trim;
                    $("#z" + v + " #who").val(data['9']).trim;
                    $("#z" + v + " #title").val(data['10']).trim;
                    $("#z" + v + " #talk").val(data['13']).trim;
                    $("#z" + v + " #other").val(data['14']).trim;
                    $("#z" + v + " #medicine").html(data['11']).trim;
                    $("#z" + v + " #category").html(data['12']).trim;
                    $("#countv").val(v);
                });
            },
            error: function(xhr, type) {
                alert('??');
            }
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#accnameul li").on("click", function() {
            $("#accname").val($(this).text().trim());
        });
    });
    </script>
</body>

</html>
