<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>店家總攬</title>
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
			<div class="col-xs-6 col-md-6" style="text-align:center">	
				<div class="col-xs-3 col-md-3" ><a href="createvendor" class="btn btn-block btn-lg btn-primary">新增店家</a></div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center">
				選擇今日餐點
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">
				電話
			</div>
			<div class="col-xs-5 col-md-5" style="text-align:center">
				項目
			</div>
		</div>
		<HR>
		@foreach ($vendor as $value)
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center;display: block;">	
            	<input class="magic-radio " type="radio" name="radio" id="{!!$value!!}" value="{!!$value!!}"  {!!$todaymeal[$value]!!}>
            	<label style="width:160px;" for="{!!$value!!}">{!!$value!!}</label>	
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">
				{!!$vendortel[$value]!!}	
			</div>
			<div class="col-xs-5 col-md-5" align="center" >
				<div class="col-md-offset-3 col-xs-3 col-md-3" style="width:110px;" ><a  id="edit" href="createvendor?vendor={!!$value!!}" class="btn btn-block btn-lg btn-primary">編輯</a></div>
				<div class="col-xs-3 col-md-3" style="width:110px;" ><a  id="{!!$value!!}"   class="btn btn-block btn-lg btn-danger del" >刪除</a></div>
			</div>
		</div>
		<HR>
		@endforeach
	</div>
	<script type="text/javascript">
		$(function(){
			$('.del').click(function(){
				var cf = confirm('是否確認要刪除');
				if (cf == true) {
					$.ajax({
						type: 'POST',
						url: '/eip/public/vendorfundelajax',
						data: { info : $(this).prop('id') },
						dataType: 'json',
						headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
						success:  function(data){
							alert('已刪除:'+data+ '!!');
							document.location.href = "/eip/public/vendorfun";
						},
						error: function(xhr, type){
							alert('系統異常更新並未送出');
						}
					}); 
				}				
			})
			$('input[name="radio"]').change(function(){
				var vendor = $(this).val();
				$.ajax({
					type: 'POST',
					url: '/eip/public/vendorfunajax',
					data: { info : vendor },
					dataType: 'json',
					headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
					success:  function(data){
						alert('今日您所選擇的餐廳是:'+data+ '\n如需更改直接點選其他店家即可');
						document.location.href = "/eip/public/vendorfun";
					},
					error: function(xhr, type){
						alert('系統異常更新並未送出');
					}
				}); 
			})
		})
	</script>
</body>
</html>