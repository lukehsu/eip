<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>建立系統維護紀錄</title>
	<link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/createcss.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/magic-check.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/jquery-ui-timepicker-addon.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
	<script src="./bootstrap331/dist/js/jquery-ui.js"></script>
	<script type="text/javascript" src="./bootstrap331/dist/js/jquery-ui-timepicker-addon.js"></script>
	<link rel="stylesheet"  href="./bootstrap331/dist/css/jquery-ui-timepicker-addon.css">
  	<script>
  		$(function() {
    		$( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
    		$( ".datepickerb" ).datetimepicker({"dateFormat": "yy-mm-dd","timeFormat": "HH:mm"});
  		});
  	</script>
  	<style type="text/css">
  		.inp{
  				border-width:0px 0px 2px 0px;
  				outline:none;
  			}
  		.inpp{
  				border-width:2px 2px 2px 2px;
  				outline:none;
  			}
  	</style>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		@if ($exist == 1)
		<div class="row">
			<div class="col-xs-2 col-md-2">
				<h2>發生日期:</h2>
			</div>
			<div class="col-xs-2 col-md-2">
				<input id="accidentdate" class="brand datepicker inp" type="text" value="{!!$accidentdate!!}" >
			</div>
			<div class="col-xs-2 col-md-2">
				<h2>排除障礙時間:</h2>
			</div>
			<div class="col-xs-2 col-md-2">
				<input id="closedate" class="brand datepickerb inp" type="text" value="{!!$closedate!!}"  >
			</div>
			<div class="col-xs-2 col-md-2">
				<h2>處理人員:</h2>
			</div>
			<div class="col-xs-2 col-md-2">
				<input id="closeman" class="brand inp" type="text" value="{!!$name!!}" >
				<input id="caseid" class="brand inp" type="hidden" value="{!!$id!!}" >
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>故障描述:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="describe" cols="20" rows="1" class="inpp" >{!!$describe!!}</textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>原因:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="how" cols="50" rows="5" class="inpp" >{!!$how!!}</textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>處理方式:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="howdo" cols="40" rows="5" class="inpp">{!!$howdo!!}</textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>備註:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="others" cols="40" rows="5" class="inpp">{!!$others!!}</textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-offset-5 col-md-offset-5 col-xs-3 col-md-3">
				<a  id="pre" href="/eip/public/systemcheck" class="btn  btn-lg btn-primary" style="width:90px;">返回</a>
				<a  id="update" class="btn  btn-lg btn-primary" style="width:90px;">更新</a>
			</div>
		</div>
		@else
		<div class="row">
			<div class="col-xs-2 col-md-2">
				<h2>發生日期:</h2>
			</div>
			<div class="col-xs-2 col-md-2">
				<input id="accidentdate" class="brand datepicker inp" type="text" >
			</div>
			<div class="col-xs-2 col-md-2">
				<h2>排除障礙時間:</h2>
			</div>
			<div class="col-xs-2 col-md-2">
				<input id="closedate" class="brand datepickerb inp" type="text" >
			</div>
			<div class="col-xs-2 col-md-2">
				<h2>處理人員:</h2>
			</div>
			<div class="col-xs-2 col-md-2">
				<input id="closeman" class="brand inp" type="text" value="{!!$name!!}" >
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>故障描述:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="describe" cols="20" rows="1" class="inpp"></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>原因:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="how" cols="50" rows="5" class="inpp"></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>處理方式:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="howdo" cols="40" rows="5" class="inpp"></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-3 col-md-3">
				<h2>備註:</h2>
			</div>
			<div class="col-xs-6 col-md-6">
				<textarea id="others" cols="40" rows="5" class="inpp"></textarea>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-offset-5 col-md-offset-5 col-xs-3 col-md-3">
				<a  id="go" class="btn btn-block btn-lg btn-primary" style="width:90px;">送出</a>
			</div>
		</div>
		@endif
	</div>
	<script type="text/javascript">
		$(function(){
			$("#update").click(function(){
				$.ajax({
					type: 'POST',
					url: '/eip/public/systemupdateajax',
					data: { caseid:$('#caseid').val(), accidentdate:$('#accidentdate').val(), closedate:$('#closedate').val(), closeman:$('#closeman').val(), describe:$('#describe').val(), how:$('#how').val(), howdo:$('#howdo').val(),others:$('#others').val()} ,
					dataType: 'json',
					headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
					success:  function(data){
						alert(data);
						document.location.href = "/eip/public/systemcheck"
					},
					error: function(xhr, type){
						alert('系統異常未送出');
					}
				});	
			})
			$("#go").click(function(){
				$.ajax({
					type: 'POST',
					url: '/eip/public/systemcreateajax',
					data: { accidentdate:$('#accidentdate').val(), closedate:$('#closedate').val(), closeman:$('#closeman').val(), describe:$('#describe').val(), how:$('#how').val(), howdo:$('#howdo').val(),others:$('#others').val()} ,
					dataType: 'json',
					headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
					success:  function(data){
						alert(data);
						document.location.href = "/eip/public/systemcheck"
					},
					error: function(xhr, type){
						alert('系統異常未送出');
					}
				});	
			})
		})
	</script>
</body>
</html>