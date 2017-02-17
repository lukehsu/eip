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
  	<script>
  		$(function() {
    	$( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  		});
  	</script>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		<div class="row">
		    <form action="orderfun">
            <div class="col-xs-2 col-md-2" style="width: 130px;font-size:22px">
                查詢日期:
            </div>   
            <div class="col-xs-2 col-md-2">
              <input type="text" name="datepicker" placeholder="請選擇日期" class="form-control datepicker" id="datepicker" value="{!!$day!!}" />
            </div>   
            <div class="col-xs-2 col-md-1">
              <input type="submit" id="submitmed" class="btn btn-block btn-lg btn-info">
            </div>  
            </form>
		</div>
		<br>
		<div class="row">
		<div class="col-xs-6 col-md-6">
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center;">
				<input class="magic-checkbox" type="checkbox" name="allcheckbox" id="allcheckbox" value="" > 
				<label for="allcheckbox">確認</label>
			</div>
			<div class="col-xs-5 col-md-5" style="text-align:center">
				金額
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">
				日期
			</div>
		</div>
		<HR>
		@foreach ($order as $key => $value )
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center">	
				<input class="magic-checkbox" type="checkbox" name="checkmedvalue[]" id="{!!$key!!}" value="{!!$key!!}" {!!$checkinfo[$key]!!} > 
				<label   for="{!!$key!!}">{!!$key!!}</label>
			</div>
			<div class="col-xs-5 col-md-5" align="center" >
				{!!$value!!}
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">	
				{!!$day!!}
			</div>
			<div class="col-xs-12 col-md-12" style="">	
				@foreach ($orderdetail[$key] as $k => $v)
					{!!$k!!}--{!!$v!!}
				@endforeach
			</div>
		</div>
		<HR>
		@endforeach
		</div>
		<div class="col-xs-6 col-md-6">
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center">
				品項
			</div>
			<div class="col-xs-5 col-md-5" style="text-align:center">
				數量
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">
				金額
			</div>
		</div>
		@foreach ($item as $key => $value )
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center">
				{!!$key!!}
			</div>
			<div class="col-xs-5 col-md-5" style="text-align:center">
				{!!$qty[$key]!!}
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">
				{!!$value!!}
			</div>		
		</div>
		<HR>
		@endforeach
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center;color:red;">
				合計
			</div>
			<div class="col-xs-5 col-md-5" style="text-align:center">
				
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center;color:red;">
				{!!$totalsum!!}
			</div>		
		</div>
		</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('#allcheckbox').change(function(){
				var x = [];
				if($('#allcheckbox').prop("checked"))
				{
					$('input[name="checkmedvalue[]"]').prop("checked",true);
					$('input[name="checkmedvalue[]"]').each(function(){
						x.push($(this).prop('id'));
					})	
					$.ajax({
						type: 'POST',
						url: '/eip/public/orderfunajax',
						data: { info : x , day: $('#datepicker').val() , allx:'0'} ,
						dataType: 'json',
						headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
						success:  function(data){
							alert(data);
						},
						error: function(xhr, type){
							alert('系統異常未送出');
						}
					});				
				}
				else	
				{
					$('input[name="checkmedvalue[]"]').prop("checked",false);
					$('input[name="checkmedvalue[]"]').each(function(){
						x.push($(this).prop('id'));
					})	
					$.ajax({
						type: 'POST',
						url: '/eip/public/orderfunajax',
						data: { info : x , day: $('#datepicker').val(),allx:'1'} ,
						dataType: 'json',
						headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
						success:  function(data){
							alert(data);
						},
						error: function(xhr, type){
							alert('系統異常未送出');
						}
					});	
				}
			})
			$('input[name="checkmedvalue[]"]').click(function(){
				if ($(this).prop("checked")) {
					$.ajax({
						type: 'POST',
						url: '/eip/public/orderfunajax',
						data: { info : $(this).val() , day: $('#datepicker').val(),allx:'2'} ,
						dataType: 'json',
						headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
						success:  function(data){
							alert(data);
						},
						error: function(xhr, type){
							alert('系統異常未送出');
						}
					});
				}
				else
				{
					$.ajax({
						type: 'POST',
						url: '/eip/public/orderfunajax',
						data: { info : $(this).val() , day: $('#datepicker').val(),allx:'3'} ,
						dataType: 'json',
						headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
						success:  function(data){
							alert(data);
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