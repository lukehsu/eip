<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
    <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
    <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
    <script src="./bootstrap331/dist/js/jquery.circliful.min.js"></script>
<style type="text/css"> 
body { 
background:url(./bootstrap331/dist/test.png) no-repeat;
background-size:cover;
} 
</style>
<style> 
.circliful { 
    position: relative;  
} 
.circle-text, .circle-info, .circle-text-half, .circle-info-half { 
    width: 100%; 
    position: absolute; 
    text-align: center; 
    display: inline-block; 
} 
.circle-info, .circle-info-half { 
    color: #999; 
} 
.circliful .fa { 
    margin: -10px 3px 0 3px; 
    position: relative; 
    bottom: 4px; 
} 
</style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <h4>業務業績</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            保瑞西藥業績
        </div>
        <div class="col-md-4">
            <div id="myStat1" data-dimension="350" data-text="35%" data-info="New Clients"  
            data-width="20" data-fontsize="30" data-percent="35" data-fgcolor="#61a9dc"  
            data-bgcolor="#eee" data-fill="#ddd"></div>
        </div>
        <div class="col-md-2">
            保瑞西藥業績
        </div>
        <div class="col-md-4">
            <div id="myStat2" data-dimension="350" data-text="80%" data-info="New Clients"  
            data-width="20" data-fontsize="30" data-percent="80" data-fgcolor="#61a9dc"  
            data-bgcolor="#eee" data-fill="#ddd"></div>
        </div>
    </div>
</div>
<script> 
$( document ).ready(function() { 
        $('#myStat1').circliful(); 
        $('#myStat2').circliful(); 
        $('#myStat3').circliful(); 
        $('#myStat4').circliful(); 
    }); 
</script> 	
</body>
</html>