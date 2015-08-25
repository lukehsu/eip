<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>業務部日報表</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
  @include('includes.navbar')
<script type="text/javascript">
    $(document).ready(function() {
      $("#checklogin").click(function()
      {  

      $.ajax({
        type: 'POST',
        url: '/eip/public/login',
        data: { name : $("#login-name").val(), password : $("#login-pass").val() },
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
          alert($("#logindisplays").val());
        },
                  error: function(xhr, type)
                  {
                    alert('Ajax error!')
                  }
    	}); 
   	});  
   }); 
</script>   
</body>
</html>