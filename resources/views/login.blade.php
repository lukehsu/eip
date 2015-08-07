<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>Document</title>
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/flat-ui.css">
  <link rel="stylesheet"  href="../public/bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <script type="text/javascript" src="../bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<div class="secure">Secure Login form</div>
{!! Form::open(array('url'=>'account/login','method'=>'POST', 'id'=>'myform')) !!}
<div class="control-group">
  <div class="controls">
     {!! Form::text('email','',array('id'=>'','class'=>'form-control span6','placeholder' => 'Email')) !!}
  </div>
</div>
<div class="control-group">
  <div class="controls">
  {!! Form::password('password',array('class'=>'form-control span6', 'placeholder' => 'Please Enter your Password')) !!}
  </div>
</div>
{!! Form::button('Login', array('class'=>'send-btn')) !!}
{!! Form::close() !!}
<button id="send-btn">test</button>
<script type="text/javascript">
$(document).ready(function(){
  $('.send-btn').click(function(){            
    $.ajax({
      url: 'login',
      type: "post",
      data: {'email':$('input[name=email]').val(), '_token': $('input[name=_token]').val()},
      success: function(data){
        alert(data);
      }
    });      
  }); 
});
</script>
</body>
</html>