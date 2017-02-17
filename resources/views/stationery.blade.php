<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title>文具申請</title>
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
			<div class="col-xs-6 col-md-6">
				<span style="font-size: 20px"><H1><span>文具申請單</span></H1>
			</div>	
			<div class="col-xs-6 col-md-6">
				<span style="font-size: 20px"><H1>申請日期: <span> {!!$today!!} </span> </span></H1>
			</div>	
		</div>
		<div class="row" style="margin-top: 30px">
			<div class="row">
				<div class="col-xs-offset-1 col-md-offset-1 col-xs-2 col-md-2">
					<H2>姓名:</H2><span id="name">{!!$name!!}</span>
				</div>
				<div class="col-xs-offset-1 col-md-offset-1 col-xs-2 col-md-2">
					<H2>部門:</H2><span id="dep">{!!$dep!!}</span>
				</div>
			</div>	
			<div class="row" style="margin-top: 30px">
				<div class="col-xs-offset-1 col-md-offset-1 col-xs-3 col-md-3">
				<H2>申請項目</H2>
				</div>
			</div>	
			<div id="z1" class="row" style="margin-top: 10px;display:none">
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-offset-1 col-md-offset-1 col-xs-3 col-md-3">
          				<div class="form-group">
            				<input type="text" value="" placeholder="品項" class="form-control item" />
         			 	</div>
					</div>
					<div class="col-md-offset-1 col-xs-2 col-md-2">
          				<div class="form-group">
            				<input type="text" value="" placeholder="規格" class="form-control standard" />
         			 	</div>
					</div>
					<div class="col-md-offset-1 col-xs-1 col-md-1">
          				<div class="form-group">
            				<input type="text" value="" placeholder="數量" class="form-control qty" />
         			 	</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-offset-1 col-md-offset-1 col-xs-6 col-md-6">
						是否指定品牌
            			<input class="magic-radio radioinputy" type="radio" name="radio" id="t" value="">
            			<label class="radiolabely" style="width:45px;" for="t">是</label>	
            			<input class="brand" type="text" placeholder="品牌名稱" style="border-width:0px 0px 2px 0px;outline:none;"  />
            			<input class="magic-radio radioinputn" type="radio" name="radio" id="t1" value="" checked>
            			<label class="radiolabeln" style="width:80px;" for="t1">否</label>	
					</div>		
            		<div class="col-xs-2 col-md-2">
              			<input type="submit" class="btn btn-block btn-lg btn-info add" value="新增欄位">
            		</div>				
				</div>
			</div>	
			<div id="z2" class="row" style="margin-top: 10px">
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-offset-1 col-md-offset-1 col-xs-3 col-md-3">
          				<div class="form-group">
            				<input type="text" value="" placeholder="品項" class="form-control item" />
         			 	</div>
					</div>
					<div class="col-md-offset-1 col-xs-2 col-md-2">
          				<div class="form-group">
            				<input type="text" value="" placeholder="規格" class="form-control standard" />
         			 	</div>
					</div>
					<div class="col-md-offset-1 col-xs-2 col-md-2">
          				<div class="form-group">
            				<input type="text" value="" placeholder="數量(需註明單位)" class="form-control qty" />
         			 	</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-12">
					<div class="col-xs-offset-1 col-md-offset-1 col-xs-6 col-md-6">
						是否指定品牌
            			<input class="magic-radio radioinputy" type="radio" name="radio" id="radioy" value="">
            			<label class="radiolabely" style="width:45px;" for="radioy">是</label>	
            			<input class="brand" type="text"  style="border-width:0px 0px 2px 0px;outline:none;"  />
            			<input class="magic-radio radioinputn" type="radio" name="radio" id="radion" value="" checked>
            			<label class="radiolabeln" style="width:80px;" for="radion">否</label>	
					</div>		
            		<div class="col-xs-2 col-md-2">
              			<input type="submit" class="btn btn-block btn-lg btn-info add" value="新增欄位">
            		</div>				
				</div>
			</div>	
			<div class="row">
				<div class="col-xs-offset-5 col-md-offset-5 col-xs-2 col-md-2">
					<a  id="go" class="btn btn-block btn-lg btn-primary" style="width:90px;margin-top: 60px">送出</a>
				</div>
			</div>
		</div>
	</div>
	<input id="countx"  type="hidden" name="" value="2">
	<script type="text/javascript">
		$(".add").click(function(){
			var x = parseFloat($("#countx").val()) + 1;
			var y = x-1;
			$("#countx").val(x);
			$('#z1').clone(true).prop('id', 'z'+ x ).css('display', 'block').insertAfter($('#z'+y));	
			$('#z'+x+' .radioinputy').prop('id','radioy'+x);
			$('#z'+x+' .radiolabely').prop('for','radioy'+x);
			$('#z'+x+' .radioinputn').prop('id','radion'+x);
			$('#z'+x+' .radiolabeln').prop('for','radion'+x);
			$('#z'+x+' .radioinputy').prop('name','radio'+x);
			$('#z'+x+' .radioinputn').prop('name','radio'+x);
			$('#radion'+x).prop('checked',true);
		})
	</script>
	<script type="text/javascript">
		$("#go").click(function(){
			var i = parseFloat($("#countx").val());
			var infoarray = [];
			var info = []
			var Today = new Date(); 
			var tday = Today.getFullYear()+'-'+(Today.getMonth()+1)+'-'+Today.getDate();
			for (var x = 2; x <= i; x++) {
            	var str=$('#z'+x+' .qty').val();  
            	if(escape(str).indexOf("%u")<0){  
            		alert("請填寫數量單位");  
            		return false;
            	}  
				infoarray.push($('#z'+x+' .item').val(),$('#z'+x+' .standard').val(),$('#z'+x+' .qty').val(),$('#z'+x+' .radioinputy').val(),$('#z'+x+' .brand').val(),$('#z'+x+' .radioinputn').val());
				info.push(infoarray);	
				var infoarray = [];
			}
			$.ajax({
				type: 'POST',
				url: '/eip/public/stationeryajax',
				data: { info : info ,name:$('#name').text() ,dep:$('#dep').text(),tday:tday} ,
				dataType: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
				success:  function(data){
					alert(data);
					document.location.href = "/eip/public/stationery";
				},
				error: function(xhr, type){
					alert('系統異常新增並未送出');
				}
			}); 
		});
	</script>
</body>
</html>