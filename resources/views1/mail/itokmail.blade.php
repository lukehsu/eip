<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    資訊部回覆:<br>
    {!!$response!!}<br>
    -----------------------------------------------------------------------------<br>    
    滿意度調查:<br>
    <font color="blue">請務必填寫滿意度調查表，完成後方可以在建立新的資訊需求單，謝謝</font><br>
    <a href="{!!$comment!!}">{!!$comment!!}</a><br>
    -----------------------------------------------------------------------------<br> 
    單號:{!!$ordernumber!!}<br>
    部門:{!!$dep!!}<br>
    日期:{!!$date!!}<br>
    員編:{!!$enumber!!}<br>
    姓名:{!!$name!!}<br>
    問題描述:{!!$description!!}<br>
    連結: http://192.168.1.35/eip/public/{!!$ordernumber!!}/it
    </body>
</html>