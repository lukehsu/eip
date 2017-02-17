<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>餐點明細</title>
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