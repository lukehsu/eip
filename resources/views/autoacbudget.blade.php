<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>保瑞日報表</title>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap.css">
  <link rel="stylesheet"  href="./bootstrap331/dist/css/flat-ui.css">
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet"  href="./bootstrap331/dist/css/bootstrap-datetimepicker.css"> 
  <link rel="stylesheet"  href="./bootstrap331/dist/css/datepickerplacehold.css">
  <script src="./bootstrap331/dist/js/highcharts.js"></script>
  <script src="./bootstrap331/dist/js/html2canvas.js"></script>
  <script type="text/javascript">
$(document).ready(function(){
  var line1 = [14, 32, 41, 44, 40, 47, 53, 67];
  var plot5 = $.jqplot('chart5', [line1], {
      title: 'Chart with Point Labels', 
      seriesDefaults: {
        showMarker:false,
        pointLabels: {
          show: true,
          edgeTolerance: 5
        }},
      axes:{
        xaxis:{min:1}
      }
  });
});
  </script>
</head>
<body>
<div class="container-fluid" id="ourdiv" style="background-color:#FFFFFF">
  <div class="row">
    <div id="chart5" class="col-md-12" style="margin-left:20px;height:300px;font-size:12px" ></div>
  </div>
</div>
  <script type="text/javascript" src="./bootstrap331/dist/js/jquery.jqplot.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/shCore.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/shBrushJScript.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/shBrushXml.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.barRenderer.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.pieRenderer.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.categoryAxisRenderer.min.js"></script>
  <script type="text/javascript" src="./bootstrap331/dist/js/jqplot.pointLabels.js"></script>
</body>
</html>