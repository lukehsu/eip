<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>滿意度調查表</title>
    <link rel="stylesheet"  href="../bootstrap331/dist/css/bootstrap.css">
    <link rel="stylesheet"  href="../bootstrap331/dist/css/flat-ui.css">
    <link rel="stylesheet"  href="../bootstrap331/dist/css/jstarbox.css">
    <script type="text/javascript" src="../bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../bootstrap331/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../bootstrap331/dist/js/jstarbox.js"></script>

</head>
<style type="text/css">
  input:focus {
  outline : 0;
}
</style>
<body style="font-family:微軟正黑體">
<div class="container-fluid">
    <div class="row" style="margin-top:20px;" >
      <div class="col-md-offset-2 col-md-3">
        <p>異常日期&nbsp;&nbsp;:&nbsp;&nbsp;{!!$date!!}</p>
        <p>系統異常分類&nbsp;&nbsp;:&nbsp;&nbsp;{!!$items!!}</p>
        <p>系統異常描述&nbsp;&nbsp;:&nbsp;&nbsp;{!!$description!!}</p>
        <input id="ordernumber" type="hidden" value="{!!$ordernumber!!}">
      </div>  
      <div class="col-md-offset-2 col-md-3">
        <p>資訊部回覆&nbsp;&nbsp;:&nbsp;&nbsp;{!!$response!!}</p>
      </div>
    </div>
    <div class="row" style="margin-top:10px;">
      <div class="col-md-12" style="border-bottom:#1ABC9C 5px double;"></div>
    </div>
    <div class="row" style="margin-top:110px;margin-left:10px" >
      <div class="col-md-offset-5 col-md-3">
        <div class="starbox">
        </div>
      </div>  
    </div>
    <div class="row" style="margin-top:30px;margin-right:180px" >
      <div class="col-md-offset-5 col-md-5" >
        <span class="fui-new"></span>&nbsp;&nbsp;<input id="comment" type="text" style="border:none;border-bottom:2px green solid;" size="30">
      </div>  
    </div>
    <div class="row" style="margin-top:40px" >
      <div class="col-md-offset-5 col-md-2" >
        <button id="done" class="btn btn-block btn-lg btn-info">送出</button>
      </div>  
    </div>
</div>
<script type="text/javascript">
  $('.starbox').starbox({
    average: 0.5,
    changeable: true,
    autoUpdateAverage: true,
    ghosting: true,
    buttons: 10
  });
</script>
<script type="text/javascript">
  $('#done').click(function(){
    var rank = $('.starbox').starbox("getValue")*5;
    $.ajax({
        type: 'POST',
        url: '/eip/public/itservicerank',
        data: {rank:rank,comment: $('#comment').val(),ordernumber:$('#ordernumber').val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){

        },
        error: function(xhr, type){
          alert('??');
        }
    }); 
  });
</script>
</body>
</html>