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
    .error{
        border: solid  red ;
    }
    </style>
</head>

<body style="font-family:微軟正黑體">
    <div class="container-fluid">
        @include('includes.navbar')
        <div class="row" style="margin-bottom:10px">
        <form id="form1" name="form1" method="post" action="transferdailycheck">
            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
            <div class="row" style="margin-top:60px">
            <div class="col-md-offset-5 col-md-2">
                <span id="r1" class="fui-calendar"></span>&nbsp;&nbsp;
                <input id="startday" name="startday" type="text" placeholder="請選開始日期" style="border:none;border-bottom:2px green solid;">
            </div>
            </div>
            <div class="row" style="margin-top:60px">
            <div class="col-md-offset-5 col-md-2">
                <span id="r1" class="fui-calendar"></span>&nbsp;&nbsp;
                <input id="endday" name="endday" type="text" placeholder="請選結束日期" style="border:none;border-bottom:2px green solid;">
            </div>
            </div>
            <div class="row" style="margin-top:60px">
            <div class="col-md-offset-5 col-md-2" style="margin-bottom:10px">
                <button id="transferexcel" class="btn btn-block btn-lg btn-info">送出</button>
            </div>
            </div>
        </form>
        </div>
    </div>    
</body>
</html>
