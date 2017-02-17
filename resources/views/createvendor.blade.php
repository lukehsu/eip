<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>建立店家</title>
	<link rel="stylesheet" href="./bootstrap331/dist/css/bootstrap.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/flat-ui.css">
	<link rel="stylesheet" href="./bootstrap331/dist/css/createcss.css">
	<script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		<div class="row">
			<div class="col-xs-3 col-md-3" style="text-align:center">
				店家資訊
			</div>
			<div class="col-xs-3 col-md-3" style="text-align:center">
				分類
				<span style="margin-left: 4px" id="itemsplus"  class="fui-plus-circle"></span>
			</div>
			<div class="col-xs-4 col-md-4" style="text-align:center">
				項目
			</div>
			<div class="col-xs-2 col-md-2" style="text-align:center">
				金額
			</div>
		</div>
		<HR>
			<div class="row">
				<div class="col-xs-3 col-md-3" style="text-align:center">
					<input id="restaurant" type="text"  placeholder="店家名稱" class="form-control" style="margin-left:60px; width:150px;" value="{!!$vendor!!}" />
					<input id="restauranttel" type="text"  placeholder="電話" class="form-control" style="margin-left:60px; width:150px;" value="{!!$vendortel!!}" />
				</div>
				<div id="category" class="col-xs-3 col-md-3" style="text-align:center">
				<input id="countcategory" type="hidden" name="" value="{!!$j!!}" >
					<!--判斷是否為新增-->
					@if ( isset($vendor)  )
					@foreach ($categorysedit as $key => $value )
					<div style="margin-bottom: 28px" class="btn-group">
						<button id="{!!$key!!}" data-toggle="dropdown" class="btn btn-primary dropdown-toggle bid" type="button">{!!$value!!}<span class="caret"></span></button>
						<ul id="{!!$categorysuledit[$key]!!}"  role="menu" class="dropdown-menu ulid">
							@foreach ($categorys as $category )
							<li><a>{!!$category!!}</a></li>
							@endforeach
						</ul>
					</div>
					<br>
					@endforeach
					@else
					<div style="margin-bottom: 28px" class="btn-group">
						<button id="categoryb0" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button>
						<ul id="categoryul0"  role="menu" class="dropdown-menu ulid">
							@foreach ($categorys as $category )
							<li><a>{!!$category!!}</a></li>
							@endforeach
						</ul>
					</div>
					<br>
					@endif
				</div>
				<div id="items" class="col-xs-4 col-md-4" style="" >
					@if ( isset($vendor)  )
					@foreach ($items as $key => $value )
					<input id="{!!$key!!}" type="text" value="{!!$value!!}" placeholder="請輸入" class="form-control" style="margin-left:80px; width:200px;" /><br>
					@endforeach
					@else
					<input id="itemsname0" type="text" value="" placeholder="請輸入" class="form-control" style="margin-left:80px;width:200px;"  /><br>
					@endif
				</div>
				<div id="price" class="col-xs-2 col-md-2" >
					@if ( isset($vendor)  )
					@foreach ($itemsprice as $key => $value )
					<input id="{!!$key!!}" type="text" value="{!!$value!!}" placeholder="金額" class="form-control" style="margin-left:55px;width:75px;"  /><br>
					@endforeach
					@else
					<input id="pricename0" type="text" value="" placeholder="金額" class="form-control" style="margin-left:55px;width:75px;"  /><br>
					@endif
				</div>
			</div>
			<HR>
				<div class="row">
					<div class="col-xs-offset-10 col-xs-2 col-md-offset-10 col-md-2" style="text-align:center">
						<a  id="go" class="btn btn-block btn-lg btn-primary" style="width:150px">送出</a>
					</div>
				</div>
			</div>
		<script type="text/javascript">
			$(function(){
				$("#itemsplus").click(function(){
					var mealcategory = {!!$categorysjava!!};
					var mealcategorystring = '' ;
					var x ;
					x = 1 ;
					$.each(mealcategory,function(key,value){
						mealcategorystring += '<li><a>'+value+'</a></li>';
					})
					$("#countcategory").val($("#countcategory").val()+x);
					var y = $("#countcategory").val().length;
					$("#category").append('<div style="margin-bottom: 28px" class="btn-group"><button id="categoryb'+y+'" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">請選擇類別<span class="caret"></span></button><ul id="categoryul'+y+'" role="menu" class="dropdown-menu ulid">'+mealcategorystring+'</ul></div><br>');
					$("#items").append('<input id="itemsname'+y+'" type="text" value="" placeholder="請輸入" class="form-control" style="margin-left:80px; width:200px;" /><br>');
					$("#price").append('<input id="pricename'+y+'" type="text" value="" placeholder="金額" class="form-control" style="margin-left:55px; width:75px;" /><br>');
					$("#categoryul" + y + " li").on("click", function() {
						$("#categoryb"+y).html($(this).text() + '<span class="caret"></span>').trim;
					});
				})
				$(".ulid li").on("click", function() {
					var bid = $(this).parent('.ulid').prop('id');
					var buttonid = bid.replace('categoryul','categoryb');
					$("#"+buttonid).html($(this).text() + '<span class="caret"></span>').trim;
				});
			})
		</script>
		<script type="text/javascript">
			$("#go").click(function(){
				var y = $("#countcategory").val().length;
				var itemsarray = [];
				for (var i = 0; i <= y; i++) {
					if ($("#categoryb"+i).text()=="請選擇類別") {
						alert('尚有類別未選擇');
						return false;
					}
					if ($("#itemsname"+i).val() !='' && $("#pricename"+i).val()!='') {
						itemstemp = [ $("#restaurant").val()  , $("#categoryb"+i).text() , $("#itemsname"+i).val() , $("#pricename"+i).val() , $("#restauranttel").val()];
						itemsarray.push(itemstemp);
					}
				}
				$.ajax({
					type: 'POST',
					url: '/eip/public/createvendorajax',
					data: { info : itemsarray },
					dataType: 'json',
					headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
					success:  function(data){
						alert(data);
						document.location.href = "/eip/public/createvendor";
					},
					error: function(xhr, type){
						alert('系統異常新增並未送出');
					}
				}); 
			});
		</script>
</body>
</html>