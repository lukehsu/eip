<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登入頁面</title>
  	@include('head.bootstrapcss')
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 text-center">
         	<form class="navbar-form navbar-left" method="POST" action="login">
              	<input type="text" id="name" name="name" class="form-control" />
              	<input type="text" id="password" name="password"  class="form-control" />
              	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            	<button type="submit" class="btn btn-default">
              		登入
            	</button>
          	</form>
		</div>
	</div>
</div> 
</body>
</html>