<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>業績預估達成率</title>
    <link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
    <link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
    <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
    <script src="./bootstrap331/dist/js/jquery.circliful.min.js"></script>
    <style>
    .circliful {
        position: relative;
    }
    
    .circle-text,
    .circle-info,
    .circle-text-half,
    .circle-info-half {
        width: 100%;
        position: absolute;
        text-align: center;
        display: inline-block;
    }
    
    .circle-info,
    .circle-info-half {
        color: #999;
    }
    
    .circliful .fa {
        margin: -10px 3px 0 3px;
        position: relative;
        bottom: 4px;
    }
    </style>
    <script>
    $(document).ready(function() {
        $('#myStat1').circliful();
        $('#myStat2').circliful();
        $('#myStat3').circliful();
        $('#myStat4').circliful();
    });
    </script>
</head>

<body>
    <div class="container-fluid">
        @include('includes.navbar')
        <div class="row" style="margin-bottom:10px">
            <form id="form1" name="form1" method="post" action="accountmanagerexcel">
                <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                <div class="col-xs-offset-1 col-xs-2" style="margin-top:30px">
                    <span id="r1" class="fui-calendar"></span>
                    <input id="startday" name="startday" type="text" placeholder="搜尋日期起點" style="border:none;border-bottom:2px green solid;">
                </div>
                <div class="col-xs-2" style="margin-top:30px">
                    <span id="r1" class="fui-calendar"></span>
                    <input id="endday" name="endday" type="text" placeholder="搜尋日期終點" style="border:none;border-bottom:2px green solid;">
                </div>
                <div class="col-xs-2" style="margin-top:30px">
                    <span class="fui-user"></span>
                    <input id="accname" name="accname" type="text" placeholder="業務人員" data-toggle="dropdown" style="border:none;border-bottom:2px green solid;">
                    <ul id="accnameul" role="menu" class="dropdown-menu">
                        <li style="cursor: pointer;">
                            <a>
                            </a>
                        </li>
                    </ul>
                    <input id="countv" type="hidden" value="2">
                </div>
                <div class="col-xs-2" style="margin-top:30px">
                    <span class="fui-user"></span>
                    <input id="accname" name="accname" type="text" placeholder="藥品" data-toggle="dropdown" style="border:none;border-bottom:2px green solid;">
                    <ul id="accnameul" role="menu" class="dropdown-menu">
                        <li style="cursor: pointer;">
                            <a>
                            </a>
                        </li>
                    </ul>
                    <input id="countv" type="hidden" value="2">
                </div>
                <div class="col-xs-2" style="margin-top:30px">
                    <span class="fui-lock"></span>
                    <input id="accname" name="accname" type="text" placeholder="客戶" data-toggle="dropdown" style="border:none;border-bottom:2px green solid;">
                    <ul id="accnameul" role="menu" class="dropdown-menu">
                        <li style="cursor: pointer;">
                            <a>
                            </a>
                        </li>
                    </ul>
                    <input id="countv" type="hidden" value="2">
                </div>
            </form>
        </div>
        <div class="row" style="margin-top:30px">
            <div class="col-xs-offset-5 col-xs-2">
                <a href="#fakelink" class="btn  btn-lg btn-info">送出</a>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-xs-12" style="border-bottom:#1ABC9C 2px solid;"></div>
        </div>
        <div class="row">
            <div class="col-xs-6"><u>本月預估數量達成率:</u></div>
            <div class="col-xs-6"><u>本月總數量達成率:</u></div>
        </div>
        <div class="row">
            <div class="col-xs-offset-1 col-xs-5">
                <div id="myStat1" data-dimension="200" data-text="205%" data-info="New Clients" data-width="20" data-fontsize="30" data-percent="205" data-fgcolor="#61a9dc" data-bgcolor="#eee" data-fill="#ddd">
                </div>
            </div>
            <div class="col-xs-offset-1 col-xs-5">
                <div id="myStat2" class="col-xs-6" data-dimension="200" data-text="35%" data-info="New Clients" data-width="20" data-fontsize="30" data-percent="35" data-fgcolor="#61a9dc" data-bgcolor="#eee" data-fill="#ddd">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3" style="margin-top:30px"><u>銷售分析表:</u></div>
        </div>
        <div class="row">
            <div class="col-xs-offset-1 col-xs-8" style="margin-top:30px">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th class="text-left">
                                月份
                            </th>
                            <th class="text-center">
                                {!!$thismonth!!}
                            </th>
                            <th class="text-center" colspan="4">
                               {!!$lastmonth!!}
                            </th>
                            <th class="text-center" colspan="4">
                                {!!$thismonth!!}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class='text-left'>
                                客戶名稱
                            </td>
                            <td class='text-left'>
                                中國醫藥大學附屬醫院
                            </td>
                            <td class='text-center'>
                                第一周
                            </td>
                            <td class='text-center'>
                                第二周
                            </td>
                            <td class='text-center'>
                                第三周
                            </td>

                            <td class='text-center'>
                                第四周
                            </td>
                            @foreach($weekarrs as $weekarr)
                            <td class='text-center'>
                                第{!!$weekarr!!}週
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class='text-left'>
                                單價
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                當月預估銷售量
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                當月實際銷售量
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                當月銷售量達成率
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                當月預估銷售金額
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                當月實際銷售金額
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                當月銷售金額達成率
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                促銷/贈品 數量
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                實際銷售單價
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                去年同期銷售數量
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                去年同期增/減
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                去年同期銷售金額
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                        <tr>
                            <td class='text-left'>
                                去年同期增/減
                            </td>
                            <td class='text-center'>
                                5
                            </td>
                            <td class='text-center'>
                                4
                            </td>
                            <td class='text-center'>
                                3
                            </td>
                            <td class='text-center'>
                                2
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                            <td class='text-center'>
                                1
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
