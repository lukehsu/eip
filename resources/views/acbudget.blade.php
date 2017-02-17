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
            <div class="col-xs-3" style="margin-top:30px"><u>銷售分析表:</u></div>
        </div>
        <div class="row">

        @foreach ($monthsarray as $keys => $value)
            <div class="col-xs-offset-1 col-xs-10" style="margin-top:15px;background-color:#95A5A6;color:#FFFFFF;">{!!$itemcnname[$keys]!!} - {!!$keys!!}</div> 
            <div class="col-xs-offset-1 col-xs-10" style="margin-top:15px">
                <div class="col-xs-4" >客戶名稱</div> 
                <div class="col-xs-2">數量</div> 
                <div class="col-xs-3">單價</div> 
                <div class="col-xs-3">金額</div>
                <div class="col-xs-12" style="border-bottom:#dfdfdf 1px solid;margin-top:5px"></div>
            </div>
            <div class="col-xs-offset-1 col-xs-10" style="margin-top:5px">

                    @foreach ($value as $key => $val)
                    <div class="col-xs-4">{!!$key!!}</div> 
                    <div class="col-xs-2">{!!$val['qty']!!}</div> 
                    <div class="col-xs-3">{!!number_format($val['uniprice'],2)!!}</div> 
                    <div class="col-xs-3">{!!number_format($val['money'])!!}</div>
                    <div class="col-xs-12" style="border-bottom:#eeeeee 1px solid;margin-top:5px"></div>
                    @endforeach

            </div>
        @endforeach    
        </div>
    </div>
</body>
</html>
