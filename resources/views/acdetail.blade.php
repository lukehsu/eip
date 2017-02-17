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
</head>

<body>
    <div class="container-fluid">
        @include('includes.navbar')
        <div class="row" style="margin-top:10px">
            <div class="col-xs-12" style="border-bottom:#1ABC9C 2px solid;"></div>
        </div>
        <div class="row">
            <div class="col-xs-3" style="margin-top:30px">{!!$name!!}銷售分析表:</div>
        </div>
        <div class="row">

   
            <div class="col-xs-offset-1 col-xs-10" style="margin-top:15px;background-color:#95A5A6;color:#FFFFFF;"></div> 
            <div class="col-xs-offset-1 col-xs-10" style="margin-top:15px">
                <div class="col-xs-2" >日期</div> 
                <div class="col-xs-3" >客戶名稱</div> 
                <div class="col-xs-5">品名</div> 
                <div class="col-xs-2">金額</div>
                <div class="col-xs-12" style="border-bottom:#dfdfdf 1px solid;margin-top:5px"></div>
            </div>
            <div class="col-xs-offset-1 col-xs-10" style="margin-top:5px">
                    @foreach ($info as $key => $value)
                        <div class="col-xs-12" style="margin-top:15px;background-color:#95A5A6;color:#FFFFFF;">{!!$key!!} - 合計 {!!$infosum[$key]!!}</div>  
                        @foreach ($value as $val)
                            <div class="col-xs-2">{!!$val['Invdate']!!}</div>
                            <div class="col-xs-3">{!!$val['customer']!!}</div> 
                            <div class="col-xs-5">{!!$val['Itemchname']!!}</div> 
                            <div class="col-xs-2">{!!$val['money']!!}</div> 
                            <div class="col-xs-12" style="border-bottom:#eeeeee 1px solid;margin-top:5px"></div>  
                        @endforeach 
                    @endforeach
                    <div class="col-xs-12" style="margin-top:15px;background-color:#34495E;color:#FFFFFF;">全品項加總 - {!!$infototalsum!!}</div> 
            </div>
        </div>
    </div>
</body>
</html>
