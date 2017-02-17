<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>系統維護紀錄表</title>
	<link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/createcss.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/magic-check.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap-datetimepicker.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
	<script src="./bootstrap331/dist/js/jquery-ui.js"></script>
  	<script>
  		$(function() {
    	$( ".datepicker1" ).datepicker({dateFormat:'yy-mm-dd'});
    	$( ".datepicker2" ).datepicker({dateFormat:'yy-mm-dd'});
  		});
  	</script>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		<div class="row">
		    <form action="systemcheck">
            	<div class="col-xs-offset-2 col-md-offset-2 col-xs-2 col-md-2" style="width: 130px;font-size:20px">
                	查詢日期:
            	</div>   
            	<div class="col-xs-2 col-md-2">
              		<input type="text" name="datepicker1" placeholder="起點日期" class="form-control datepicker1" id="datepicker1" value="" />
            	</div>    
            	<div class="col-xs-2 col-md-2">
              		<input type="text" name="datepicker2" placeholder="終點日期" class="form-control datepicker2" id="datepicker2" value="" />
            	</div>   
            	<div class="col-xs-1 col-md-1">
              		<input type="submit" id="submitmed" class="btn btn-lg btn-info">
            	</div>  
            	<div class="col-xs-1 col-md-1">
                	<a  href="/eip/public/systemcreate" class="btn  btn-lg btn-info">建立案件</a>
            	</div>  
            </form>
		</div>
		<br>
		<hr>
		<div class="row">
		 	<div class="row">
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-2 col-md-2" style="text-align:center;">
						日期
					</div>
					<div class="col-xs-2 col-md-2" style="text-align:center">
						故障描述
					</div>
					<div class="col-xs-2 col-md-2" style="text-align:center">
						原因
					</div>
					<div class="col-xs-2 col-md-2" style="text-align:center">
						處理方式
					</div>
					<div class="col-xs-3 col-md-3" style="text-align:center">
						編輯
					</div>
				</div>
			</div>
			<HR>
			<div class="col-xs-12 col-md-12">
			@foreach ($allinfo as $key => $value )
				<div class="row" id="row{!!$key!!}">
				@foreach ($value as $val )
					<div class="col-xs-2 col-md-2" style="text-align:center;">
						{!!$val!!}
					</div>
				@endforeach
					<div class="col-xs-3 col-md-3" style="text-align:center;">
						<a  class="btn btn-lg btn-primary edit" id="edit{!!$key!!}">編輯</a>
					</div>
				</div>
				<hr>
			@endforeach
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('.edit').click(function(){
				var targettemp = $(this).prop('id');
				var target = targettemp.replace("edit","");
				document.location.href = "/eip/public/systemcreate?id="+target;
			})
		})
	</script>
</body>
</html>