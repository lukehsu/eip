<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>預定餐點</title>
	<link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/createcss.css">
	<link rel="stylesheet"  href="./bootstrap331/dist/css/magic-check.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		<div class="row">
			<div class="col-md-6">
				<span style="font-size: 20px">名稱: <span> {!!$todaymeal!!}</span></span>
				<input id="todaymeal" type="hidden" name="" value="{!!$todaymeal!!}">
			</div>	
			<div class="col-md-6">
				<span style="font-size: 20px">日期: <span> {!!$today!!} </span> </span>
			</div>	
		</div>
		<div class="row" style="margin-top: 30px">
			<div class="col-md-offset-1 col-md-10 col-md-offset-1">
				@foreach ($allitems as $category => $items)
				<div class="col-xs-12 col-md-12"> <h1>{!!$category!!}:</h2>
					@foreach ($items as $value)
					<div class="col-xs-3 col-md-3">
						<input class="magic-checkbox" type="checkbox" name="checkmedvalue[]" id="{!!$value!!}" value="{!!$itemscollectionprice[$value]!!}" > 
						<label style="width:190px;" for="{!!$value!!}">{!!$value!!} - {!!$itemscollectionprice[$value]!!} </label>
					</div>
					@endforeach
				</div>
				@endforeach
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-9 col-md-2">
					<h2><span style="color:red;margin-left: 2px" >您的消費金額共:<span id="sum" style="color:red;" > 0 </span> </span></h2>
					<a  id="go" class="btn btn-block btn-lg btn-primary" style="width:90px;margin-top: 20px">送出</a>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('input:checkbox').click(function(){
				if ($(this).prop('checked')) 
				{
					$("#sum").text( parseFloat($("#sum").text()) + parseFloat($(this).val()) );
				}
				else
				{
					$("#sum").text( parseFloat($("#sum").text()) - parseFloat($(this).val()) );
				}	
			});
		});
	</script>
	<script type="text/javascript">
		$("#go").click(function(){
			var x = [];
			var Today = new Date(); 
			var tday = Today.getFullYear()+'-'+(Today.getMonth()+1)+'-'+Today.getDate();
			$('input[name="checkmedvalue[]"]:checked').each(function(){
				x.push($(this).prop('id'));
			})
			$.ajax({
				type: 'POST',
				url: '/eip/public/orderluajax',
				data: { info : x , day: tday, vendor:$('#todaymeal').val()} ,
				dataType: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
				success:  function(data){
					alert(data);
					document.location.href = "/eip/public/orderlu";
				},
				error: function(xhr, type){
					alert('系統異常新增並未送出');
				}
			}); 
		});
	</script>
</body>
</html>