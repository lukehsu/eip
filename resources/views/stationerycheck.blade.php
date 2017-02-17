<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>訂單總攬</title>
	<link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/createcss.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/magic-check.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap-datetimepicker.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
	<script src="./bootstrap331/dist/js/jquery-ui.js"></script>
	<style type="text/css">
		hr{

		}
	</style>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		<!--div class="row" >
			<div class="col-xs-3 col-md-6" style="text-align:center;">
				<input class="magic-checkbox" type="checkbox" name="allcheckbox" id="allcheckbox" value="" > 
				<label for="allcheckbox">確認</label>
			</div>
			<div class="col-xs-4 col-md-6" style="text-align:center">
				申請項目
			</div>
		</div-->
		@foreach ($man as $date => $value )
		<div class="row">
			<div class="col-xs-12 col-md-12" style="background-color:#F1C40F;text-align:left">
				{!!$date!!}
			</div>	
		</div>
		@foreach ($value as $key => $val )
		<div class="row" style="border:1px #95A5A6 solid;margin-bottom:15px;">
			<div class="col-xs-6 col-md-6" style="text-align:center;">
				<input id="date{!!$sorttemp[$date][$key]!!}" type="hidden" name="" value="{!!$date!!}">
				<input class="magic-checkbox" type="checkbox" name="checkmedvalue[]" id="allcheck{!!$sorttemp[$date][$key]!!}" value="{!!$key!!}" > 
				<label for="allcheck{!!$sorttemp[$date][$key]!!}">{!!$key!!}</label>				
			</div>
			<div class="col-xs-6 col-md-6" style="text-align:center">
				{!!$val!!}
			</div>			
		</div>
		@endforeach
		@endforeach
	</div>
	<script type="text/javascript">
		$(function(){
			$('#allcheckbox').change(function(){
			})
			$('input[name="checkmedvalue[]"]').click(function(){
				if ($(this).prop("checked")) {
					var str = $(this).prop('id');
					var date = str.replace('allcheck','date');
					$.ajax({
						type: 'POST',
						url: '/eip/public/stationerycheckajax',
						data: { info : $(this).val() , day: $('#'+date).val() } ,
						dataType: 'json',
						headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
						success:  function(data){
							alert(data);
							document.location.href = "/eip/public/stationerycheck";
						},
						error: function(xhr, type){
							alert('系統異常未送出');
						}
					});
				}			
			})
		})
	</script>
</body>
</html>