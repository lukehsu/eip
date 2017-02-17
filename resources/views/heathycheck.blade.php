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
			$( ".datepicker3" ).datepicker({dateFormat:'yy-mm-dd'});
		});
	</script>
</head>
<body>
	<div class="container-fluid original">
		@include('includes.navbar')
		<hr>
		<div class="row">
			<div class="col-xs-1 col-md-1" style="margin-bottom: 5px">
				選擇日期:
			</div> 
			<div class="col-xs-2 col-md-2" style="margin-bottom: 5px">
				<input type="text" name="datepicker3" style="border-width:0px 0px 1px 0px;" placeholder="" class="form-control datepicker3" id="datepicker3" value="" />
				<input type="hidden" name="" id="checked">
			</div> 
			<div class="col-xs-1 col-md-1" style="margin-bottom: 5px">
				<input type="submit" id="submitchoose" class="btn btn-lg btn-info">
			</div>   			
			<div class="col-xs-12 col-md-12">
				<table style="width:100%">
					<tr>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">ISP</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">Fire Wall</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">Switch</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">VM Host</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">NAS</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">ARTS</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">確認</font>
						</td>
					</tr>
					<tr>
						<td>
							<input class="magic-radio" type="radio" name="ISP" id="ISPG" value="正常" >
							<label for="ISPG" style="">正常
							</label>
							<input class="magic-radio" type="radio" name="ISP" id="ISPF" value="異常" >
							<label for="ISPF" style="">異常  
							</label>
						</td>
						<td>
							<input class="magic-radio teamradio" type="radio" name="FireWall" id="FireWallG" value="正常" >
							<label for="FireWallG" style="">正常
							</label>
							<input class="magic-radio teamradio" type="radio" name="FireWall" id="FireWallF" value="異常" >
							<label for="FireWallF" style="">異常  
							</label>
						</td>
						<td>
							<input class="magic-radio" type="radio" name="Switch" id="SwitchG" value="正常" >
							<label for="SwitchG" style="">正常
							</label>
							<input class="magic-radio" type="radio" name="Switch" id="SwitchF" value="異常" >
							<label for="SwitchF" style="">異常  
							</label>
						</td>
						<td>
							<input class="magic-radio" type="radio" name="VMHost" id="VMHostG" value="正常" >
							<label for="VMHostG" style="">正常
							</label>
							<input class="magic-radio" type="radio" name="VMHost" id="VMHostF" value="異常" >
							<label for="VMHostF" style="">異常  
							</label> 
						</td>
						<td>
							<input class="magic-radio" type="radio" name="NAS" id="NASG" value="正常" >
							<label for="NASG" style="">正常
							</label>
							<input class="magic-radio" type="radio" name="NAS" id="NASF" value="異常" >
							<label for="NASF" style="">異常  
							</label>
						</td>
						<td>
							<input class="magic-radio" type="radio" name="ARTS" id="ARTSG" value="正常" >
							<label for="ARTSG" style="">正常
							</label>
							<input class="magic-radio" type="radio" name="ARTS" id="ARTSF" value="異常" >
							<label for="ARTSF" style="">異常  
							</label>
						</td>
						<td>
							<input type="submit" id="checkok" class="btn btn-lg btn-info">
						</td>
					</tr>
				</table>
			</div>
		</div>
		<hr>
		<div class="row" style="margin-top: 30px">
			<div class="col-xs-2 col-md-2">
				查詢歷史紀錄:
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
		</div>
		<div class="row" style="margin-top: 30px">
			<div class="col-xs-10 col-md-10">
				<table style="width:80%" id="mytable">		
					<tr >
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">ISP</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">Fire Wall</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">Switch</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">VM Host</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">NAS</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">ARTS</font>
						</td>
						<td bgcolor="#95A5A6">
							<font color="#FFFFFF">日期</font>
						</td>
					</tr>			
				</table>
			</div>
		</div>
	</div>
<script type="text/javascript">
	$("#checkok").click(function(){
		if ($("#datepicker3").val()=='') {alert('日期未選'); return false;}
		if (!$('input[name="ISP"]:checked').val()) { alert('ISP未選'); return false;}
		if (!$('input[name="FireWall"]:checked').val()) { alert('FireWall未選'); return false;}	
		if (!$('input[name="Switch"]:checked').val()) { alert('Switch未選'); return false;}	
		if (!$('input[name="VMHost"]:checked').val()) { alert('VMHost未選'); return false;}	
	    if (!$('input[name="NAS"]:checked').val()) { alert('NAS未選'); return false;}	
		if (!$('input[name="ARTS"]:checked').val() ) { alert('ARTS未選'); return false;}	
      $.ajax({
        type: 'POST',
        url: '/eip/public/heathycheckajax',
        data: {  ISP:$('input[name="ISP"]:checked').val()
        		,FireWall:$('input[name="FireWall"]:checked').val()
        		,Switch:$('input[name="Switch"]:checked').val()
        		,VMHost:$('input[name="VMHost"]:checked').val()
        		,NAS:$('input[name="NAS"]:checked').val()
        		,ARTS:$('input[name="ARTS"]:checked').val()
        		,sysdate:$("#datepicker3").val()
        		,search:2
        		,checked:$("#checked").val()},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
        	alert(data);
        	window.location.reload('heathycheck')
        },
        error: function(xhr, type){
          $('#error').html('error');
        }
      }); 
	});
</script>	
<script type="text/javascript">
	$("#submitchoose").click(function(){
      $.ajax({
        type: 'POST',
        url: '/eip/public/heathycheckajax',
        data: {sysdate:$("#datepicker3").val(),search:1},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
        	if (data=='當日還未檢查') {
        		alert('當日還未檢查')
        		$("#checked").val('0');
        		$('input[name="ISP"]').prop('checked',false);
        		$('input[name="FireWall"]').prop('checked',false);
        		$('input[name="Switch"]').prop('checked',false);
        		$('input[name="VMHost"]').prop('checked',false);
        		$('input[name="ISP"]').prop('checked',false);
        		$('input[name="NAS"]').prop('checked',false);
        		$('input[name="ARTS"]').prop('checked',false);
        		return false;
        	}
        	$("#checked").val('1');
        	if (data[0]=='正常') {
        		$('input[name="ISP"]')[0].checked = true;
        	}
        	else
        	{
        		$('input[name="ISP"]')[1].checked = true;
        	}	
        	if (data[1]=='正常') {
        		$('input[name="FireWall"]')[0].checked = true;
        	}
        	else
        	{
        		$('input[name="FireWall"]')[1].checked = true;
        	}	
        	if (data[2]=='正常') {
        		$('input[name="Switch"]')[0].checked = true;
        	}
        	else
        	{
        		$('input[name="Switch"]')[1].checked = true;
        	}
        	if (data[3]=='正常') {
        		$('input[name="VMHost"]')[0].checked = true;
        	}
        	else
        	{
        		$('input[name="VMHost"]')[1].checked = true;
        	}	
        	if (data[4]=='正常') {
        		$('input[name="NAS"]')[0].checked = true;
        	}
        	else
        	{
        		$('input[name="NAS"]')[1].checked = true;
        	}
        	if (data[5]=='正常') {
        		$('input[name="ARTS"]')[0].checked = true;
        	}
        	else
        	{
        		$('input[name="ARTS"]')[1].checked = true;
        	}
        },
        error: function(xhr, type){
          $('#error').html('error');
        }
      }); 
	});
</script>
<script type="text/javascript">
	$("#submitmed").click(function(){
      $.ajax({
        type: 'POST',
        url: '/eip/public/heathycheckajax',
        data: {startdate:$("#datepicker1").val(),enddate:$("#datepicker2").val(),search:3},
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
        success:  function(data){
        	var num = 1;
        	var td = '';
        	var tr = '';
        	var trc = '';
        	$.each(data,function(key,value){
        		if (num==1) {
        			tr = "<tr>";
        		}
        		else
        		{
        			 tr = '';
        		}	
        		if (num==7) {
        			trc = "</tr>";
        			num = 0 ;
        		}
        		else
        		{
        			 trc = "";
        		}
        		td = tr + td + "<td>"+value+"</td>" + trc ;
        		num = num +1 ;	
        	});	
        	$('#mytable').html('');
        	$('#mytable').append('<tr ><td bgcolor="#95A5A6"><font color="#FFFFFF">ISP</font></td><td bgcolor="#95A5A6"><font color="#FFFFFF">FireWall</font></td><td bgcolor="#95A5A6"><font color="#FFFFFF">Switch</font></td><td bgcolor="#95A5A6"><font color="#FFFFFF">VM Host</font></td><td bgcolor="#95A5A6"><font color="#FFFFFF">NAS</font></td><td bgcolor="#95A5A6"><font color="#FFFFFF">ARTS</font></td><td bgcolor="#95A5A6"><font color="#FFFFFF">日期</font></td></tr>');	
        	$('#mytable tr:last').after(td);
        },
        error: function(xhr, type){
          $('#error').html('error');
        }
      }); 
	});
</script>
</body>
</html>