<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>註冊帳號</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="login-form col-md-4  col-md-offset-4"  style="height:350px;display:none;margin-top:60px;" id="logindisplay" >
        <h4>Bora Sign</h4>
        <div class="form-group">
          <input type="text" class="form-control login-field" style="margin-top:20px;" value="" placeholder="Account" id="login-name" autocomplete="on" />
          <label class="login-field-icon fui-user" for="login-name"></label>
        </div>
        <div class="form-group">
          <input type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" />
          <label class="login-field-icon fui-lock" for="login-pass"></label>
        </div>
        <label class="" id="error" >&nbsp</label>
        <a class="btn btn-primary btn-lg btn-block" id="checklogin" style="margin-top:25px;">Login</a>
      </div>
    </div>
  </div> 
<script type="text/javascript">
    $(document).ready(function() {
      $('#logindisplay').fadeIn(1000);
      $("#checklogin").click(function()
      {  
        $.ajax({
        type: 'POST',
        url: '/eip/public/signok',
        data: { name : $("#login-name").val(), password : $("#login-pass").val() },
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
          window.location.replace("http://127.0.0.1/eip/public/login" );
        },
        error: function(xhr, type){
          $('#error').html('此帳號已被註冊過')
        }
      }); 
    });  
   }); 
</script>  
<script type="text/javascript">
  $(document).ready(function() {
    $("#login-pass").keypress(function(event){
      code = (event.keyCode ? event.keyCode : event.which);
      if (code == 13)
      {
        $("#checklogin").click();
      }
    });
  }); 
</script> 
</body>
</html>