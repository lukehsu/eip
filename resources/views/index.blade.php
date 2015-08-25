<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>登入頁面</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
  <style type="text/css">
  .div_table-cell{
    width:450px; 
    height:500px; 
    background-color:#34495E; 
    display:table-cell; 
    text-align:center; 
    vertical-align:middle;
    border:solid 2px #fff;  
    }
</style> 
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-offset-4 col-md-4 div_table-cell">
          <form class="navbar-form navbar-left" method="POST" action="login">
              <input type="text" id="name" name="name" class="form-control" />
              <input type="text" id="password" name="password"  class="form-control" />
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
              <button type="submit" class="btn btn-default">登入</button>
          </form>
      </div>
  </div>
</div> 
</body>
</html>